<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use URL;
use Auth;
use DB;
use View;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function profile(Request $request) {
        session(['url.intended' => url()->previous()]);
        return View::make("dashboard.profile");
    }

    public function editProfile(Request $request) {
        DB::table("users")
            ->where("id", Auth::user()->id)
            ->update(['fullname' => $request->input('name'), "phone" => $request->input('phone')]);

        return redirect(session()->get('url.intended'));
    }

    public function validateBet(Request $request, $BetID) {
        $bets = DB::table('bet')->where("id", $BetID)->get();
        if ($bets->first()->status != 0 && $bets->first()->status != 3) return redirect()->back()->withErrors("Tu ne peux pas modifier le statut de ce pari");

        DB::table("bet")
            ->where("id", $BetID)
            ->update(['status' => $bets->first()->status+1]);

        return redirect()->back()->with('success', $bets->first()->status == 0 ? 'Le pari a été validé' : 'Le pari a été payé');
    }

    public function view_pari(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $bets = DB::table('bet')->where("course", $currentCourse->name)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.view_pari")->with([
            "users" => $users,
            "bets"=>$bets,
            "ecuries"=>$ecuries
        ]);
    }

    public function home(Request $request) {
        $members = DB::table('users')->orderByDesc('rank')->where("rank", ">=", 5)->get();

        return View::make("dashboard.index")->with([
            "members"=>$members
        ]);
    }

    public function pari(Request $request) {
        $courses = DB::table("courses")->get();
        $bets = DB::table('bet')->where("discord", Auth::user()->id)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.pari")->with([
            "bets"=>$bets,
            "ecuries"=>$ecuries,
            "courses"=>$courses
        ]);
    }

    public function putBet(Request $request) {
        $rules = array(
            'ecurie' => 'required',
            'montant' => 'required|numeric|min:1',
        );

        $messages = [
            'montant.required' => 'Vous devez donner un nombre valide.',
            'montant.numeric' => 'Vous devez donner un nombre valide.',
            'montant.min' => 'Vous devez donner un nombre supérieur à 1.',
            'ecurie.required' => 'Vous devez une écurie.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $bet = DB::table('bet')->where("discord", Auth::user()->id)->where("course", $request->input('course'))->get();
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        if ($bet->first() != null) return redirect()->back()->withErrors("Tu as déjà déposé.e un pari !");
        if (time() >= strtotime($currentCourse->date)) return redirect()->back()->withErrors("Il est trop tard pour parier !");

        DB::table("bet")
            ->insert([
                'discord' => Auth::user()->id,
                'course' => $currentCourse->name,
                'ecurie' => $request->input('ecurie'),
                'montant' => $request->input('montant'),
            ]);

        return redirect("/pari");
    }

    public function score(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $scores = DB::table('score')->orderBy('place', 'asc')->get();
        $finalScore = array();

        foreach($scores as $score) {
            if (!array_key_exists($score->ecurie, $finalScore)) $finalScore[$score->ecurie] = $score->score;
            else $finalScore[$score->ecurie] += $score->score;
        }

        return View::make("dashboard.score")->with([
            "currentCourse"=>$currentCourse,
            "users"=>$users,
            "globalScores"=>$finalScore,
            "scores"=>$scores
        ]);
    }

    public function participants(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $pilotes = DB::table('pilotes')->where("course", $currentCourse->name)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.participants")->with([
            "users"=>$users,
            "pilotes"=>$pilotes,
            "ecuries"=>$ecuries
        ]);
    }

    public function membres(Request $request) {
        $members = DB::table('users')->where("rank", ">=", 5)->get();

        return View::make("dashboard.members")->with([
            "members"=>$members
        ]);
    }

    public function addMember(Request $request) {
        $rules = array(
            'photo' => 'clamav|max:10240|required|mimes:png',
        );

        $messages = [
            'photo.clamav' => 'Une erreur inconnue est survenue.',
            'photo.required' => 'Vous devez donner un logo valide.',
            'photo.max' => 'Le fichier est trop gros.',
            'photo.mimes' => 'Le fichier doit être un PNG.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $file = $request->file('photo');
        $token = Str::random(32);

        Storage::disk('public')->put('/profile/' . $token . ".png", file_get_contents($file));

        Cache::add($token, now()->addMinutes(60));

        return redirect()->back()->with('success', "Pour ajouter un membre, donner lui ce lien : " . URL::to("/join/".$token));
    }

    public function join(Request $request, $token) {
        if (Cache::get($token) == null) return redirect("/dashboard")->withErrors(["Le lien est invalide"]);
        if (Auth::user()->rank >= 5) return redirect()->back()->withErrors(["T'es déjà membre.."]);

        Cache::delete($token);

        Storage::disk('public')->move('/profile/' . $token . ".png", '/profile/' . Auth::user()->id . ".png");

        DB::table("users")
            ->where("id", Auth::user()->id)
            ->update(['rank' => 5, "role" => "Membre"]);

        file_get_contents("http://localhost:5000/updateMember?discord=" . Auth::user()->id);

        return redirect()->back()->with('success', "Bienvenue au sein de l'association !");
    }

    public function editMember(Request $request, $id) {
        $member = DB::table('users')->where("id", $id)->get();

        return View::make("dashboard.editMember")->with([
            "member"=> $member->first()
        ]);
    }


    public function editMemberPost(Request $request, $id) {
        $file = $request->file('photo');

        if ($file) {
            $rules = array(
                'photo' => 'clamav|max:10240|required|mimes:png',
                'rank' => 'required',
                'role' => 'required',
            );

            $messages = [
                'photo.clamav' => 'Une erreur inconnue est survenue.',
                'photo.required' => 'Vous devez donner un logo valide.',
                'photo.max' => 'Le fichier est trop gros.',
                'photo.mimes' => 'Le fichier doit être un PNG.',
                'rank.required' => "Vous devez donner le nom",
                'role.required' => "Vous devez donner une description",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/profile/' . $id . ".png", file_get_contents($file));

            DB::table("users")
                ->where("id", $id)
                ->update(['rank' => $request->input('rank'), 'role' => $request->input('role')]);
        } else {
            $rules = array(
                'rank' => 'required',
                'role' => 'required',
            );

            $messages = [
                'rank.required' => "Vous devez donner le nom",
                'role.required' => "Vous devez donner une description",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("users")
                ->where("id", $id)
                ->update(['rank' => $request->input('rank'), 'role' => $request->input('role')]);
        }

        file_get_contents("http://localhost:5000/updateMember?discord=" . Auth::user()->id);

        return redirect("/membres")->with('success', "Le membre a bien été modifié");
    }

    public function deleteMember(Request $request, $id) {
        $user = DB::table("users")->where("id", $id)->get()->first();
        if ($user == null) return redirect()->back()->withErrors("Impossible de trouver le membre");
        if ($id == Auth::user()->id) return redirect()->back()->withErrors("Tu ne peux t'auto-supprimer..................");
        if ($user->rank > Auth::user()->rank) return redirect()->back()->withErrors("Tu ne peux pas virer plus haut que toi.");

        DB::table("users")
            ->where("id", $id)
            ->update(['rank' => 0, 'role' => ""]);

        file_get_contents("http://localhost:5000/updateMember?discord=" . Auth::user()->id);

        return redirect("/membres")->with('success', "Le membre a bien été supprimé");
    }

    public function sponsor(Request $request) {
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.sponsor")->with([
            "sponsors"=>$sponsors
        ]);
    }

    public function editSponsor(Request $request, $id) {
        $sponsor = DB::table('sponsors')->where("id", $id)->get();

        return View::make("dashboard.editSponsor")->with([
            "sponsor"=>$sponsor->first()
        ]);
    }

    public function editSponsorPost(Request $request, $id) {
        $file = $request->file('logo');
        $sponsors = DB::table('sponsors')->get();
        $actualSponsor = $sponsors->where("id", $id)->first();

        if ($actualSponsor->name != $request->input('name') && $sponsors->where("name", $request->input('name'))->first() != null) return redirect()->back()->withErrors("Ce nom existe déjà !");


        if ($file) {
            $rules = array(
                'logo' => 'clamav|max:10240|required|image',
                'name' => 'required',
                'description' => 'required',
                "partner" => 'required',
            );

            $messages = [
                'logo.clamav' => 'Une erreur inconnue est survenue.',
                'logo.required' => 'Vous devez donner un logo valide.',
                'logo.max' => 'Le fichier est trop gros.',
                'logo.image' => 'Le fichier doit être une image.',
                'name.required' => "Vous devez donner le nom",
                'description.required' => "Vous devez donner une description",
                'partner.required' => "Vous devez donner indiquer si il est partenaire",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/sponsors/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $request->input('description'), 'partner' => $request->input('partner'), 'fileName'=> $request->input('name') . "." . $file->getClientOriginalExtension()]);
        } else {
            $rules = array(
                'name' => 'required',
                'description' => 'required',
                "partner" => 'required',
            );

            $messages = [
                'name.required' => "Vous devez donner le nom",
                'description.required' => "Vous devez donner une description",
                'partner.required' => "Vous devez donner indiquer si il est partenaire",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $request->input('description'), 'partner' => $request->input('partner')]);
        }


        if ($actualSponsor->name != $request->input('name')) {
            DB::table("ecurie")
                ->where("sponsor", $actualSponsor->name)
                ->update(['sponsor' => $request->input('name')]);
        }

        return redirect("/sponsor")->with('success', "Le sponsor a bien été modifié");
    }

    public function createSponsor(Request $request) {
        $rules = array(
            'logo' => 'clamav|max:10240|required|image',
            'name' => 'required',
            'description' => 'required',
            'partner' => 'required',
        );

        $messages = [
            'logo.clamav' => 'Une erreur inconnue est survenue.',
            'logo.required' => 'Vous devez donner un logo valide.',
            'logo.max' => 'Le fichier est trop gros.',
            'logo.image' => 'Le fichier doit être une image.',
            'name.required' => "Vous devez donner le nom",
            'description.required' => "Vous devez donner une description",
            'partner.required' => "Vous devez donner indiquer si il est partenaire",
        ];

        $file = $request->file('logo');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $sponsors = DB::table('sponsors')->where("name", $request->input('name'))->get()->first();
        if ($sponsors != null) return redirect()->back()->withErrors("Ce nom existe déjà !");


        Storage::disk('public')->put('/sponsors/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

        DB::table("sponsors")
            ->insert([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'fileName' => $request->input('name') . "." . $file->getClientOriginalExtension(),
                'partner' => $request->input('partner')
            ]);

        return redirect()->back()->with('success', "Le sponsor a bien été ajouté");
    }

    public function deleteSponsor(Request $request, $id) {
        DB::table('sponsors')->delete($id);

        return redirect("/sponsor")->with('success', "Le sponsor a bien été supprimé");
    }

    public function ecurie(Request $request) {
        $ecuries = DB::table('ecurie')->get();
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.ecurie")->with([
            "ecuries"=>$ecuries,
            "sponsors"=>$sponsors
        ]);
    }

    public function editEcurie(Request $request, $id) {
        $ecurie = DB::table('ecurie')->where("id", $id)->get();
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.editEcurie")->with([
            "ecurie"=>$ecurie->first(),
            "sponsors"=>$sponsors
        ]);
    }

    public function editEcuriePost(Request $request, $id) {
        $file = $request->file('logo');
        $ecuries = DB::table('ecurie')->get();
        $actualEcurie = $ecuries->where("id", $id)->first();

        if ($actualEcurie->name != $request->input('name') && $ecuries->where("name", $request->input('name'))->first() != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        if ($file) {
            $rules = array(
                'logo' => 'clamav|max:10240|required|image',
                'name' => 'required',
                'sponsor' => 'required',
            );

            $messages = [
                'logo.clamav' => 'Une erreur inconnue est survenue.',
                'logo.required' => 'Vous devez donner un logo valide.',
                'logo.max' => 'Le fichier est trop gros.',
                'logo.image' => 'Le fichier doit être une image.',
                'name.required' => "Vous devez donner le nom",
                'sponsor.required' => "Vous devez donner  un sponsor valide",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/ecuries/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

            DB::table("ecurie")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'sponsor' => $request->input('sponsor'), 'fileName'=> $request->input('name') . "." . $file->getClientOriginalExtension()]);
        } else {
            $rules = array(
                'name' => 'required',
                'sponsor' => 'required',
            );

            $messages = [
                'name.required' => "Vous devez donner le nom",
                'sponsor.required' => "Vous devez donner un sponsor valide",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("ecurie")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'sponsor' => $request->input('sponsor')]);
        }

        if ($actualEcurie->name != $request->input('name')) {
            DB::table("bet")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);

            DB::table("pilotes")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);

            DB::table("score")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);
        }



        return redirect("/ecurie")->with('success', "L'écurie a bien été modifié");
    }

    public function createEcurie(Request $request) {
        $rules = array(
            'logo' => 'clamav|max:10240|required|image',
            'name' => 'required',
            'sponsor' => 'required',
        );

        $messages = [
            'logo.clamav' => 'Une erreur inconnue est survenue.',
            'logo.required' => 'Vous devez donner un logo valide.',
            'logo.max' => 'Le fichier est trop gros.',
            'logo.image' => 'Le fichier doit être une image.',
            'name.required' => "Vous devez donner le nom",
            'sponsor.required' => "Vous devez donner une description",
        ];

        $file = $request->file('logo');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $ecuries = DB::table('ecurie')->where("name", $request->input('name'))->get()->first();
        if ($ecuries != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        Storage::disk('public')->put('/ecuries/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

        DB::table("ecurie")
            ->insert([
                'name' => $request->input('name'),
                'sponsor' => $request->input('sponsor'),
                'fileName' => $request->input('name') . "." . $file->getClientOriginalExtension(),
            ]);

        return redirect()->back()->with('success', "L'écurie a bien été ajouté");
    }

    public function deleteEcurie(Request $request, $id) {
        DB::table('ecurie')->delete($id);

        return redirect("/ecurie")->with('success', "L'écurie a bien été supprimé");
    }

    public function result(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $pilotes = DB::table('pilotes')->where("course", $currentCourse->name)->get();

        return View::make("dashboard.result")->with([
            "users"=>$users,
            "pilotes"=>$pilotes
        ]);
    }

    public function setResult(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $allPilotes = DB::table("pilotes")->where("course", $currentCourse->name)->get();

        foreach($request->post() as $id=>$place) {
            if ($id == "_token") continue;
            $pilote = DB::table("pilotes")->where("discord", $id)->where("course", $currentCourse->name)->get()->first();
            $pilote->ecurie = str_replace("\r\n",'', $pilote->ecurie);
            $score = $place <= 5 ? (count($allPilotes)*2) - (abs($place - 1)*2) : count($allPilotes) - abs($place - 5);
            if ($score < 0) $score = 0;


            DB::table("score")
                ->insert([
                    'discord' => $id,
                    'course' => $currentCourse->name,
                    'place' => $place,
                    'ecurie' => $pilote->ecurie,
                    'score' => $score,
                ]);




            if ($place == 1) {
                DB::table("bet")
                    ->where("course", $currentCourse->name)
                    ->where("ecurie", $pilote->ecurie)
                    ->where("status", 1)
                    ->update(['status' => 3]);

                DB::table("bet")
                    ->where("course", $currentCourse->name)
                    ->where("ecurie", "!=", $pilote->ecurie)
                    ->where("status", 1)
                    ->update(['status' => 2]);
            }
        }

        return redirect("/result")->with('success', "Les résultats ont bien été envoyés");
    }

    public function inscription(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $pilotes = DB::table('pilotes')->where("course", $currentCourse->name)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.inscription")->with([
            "pilotes"=>$pilotes,
            "ecuries"=>$ecuries,
            "users"=>$users
        ]);
    }


    public function addPilote(Request $request) {
        $rules = array(
            'ecurie' => 'required',
        );

        $messages = [
            'ecurie.required' => 'Vous devez donner une écurie.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $token = Str::random(32);
        Cache::add($token, $request->input('ecurie'), now()->addMinutes(60));

        return redirect()->back()->with('success', "Pour l'inscrire, il doit se connecter et accéder à ce lien : " . URL::to("/inscrire/".$token));
    }

    public function inscrire(Request $request, $token) {
        $ecurie = Cache::get($token);
        if ($ecurie == null) return redirect("/dashboard")->withErrors(["Le lien est invalide"]);
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();

        Cache::delete($token);

        DB::table("pilotes")
            ->insert([
                'discord' => Auth::user()->id,
                'course' => $currentCourse->name,
                'ecurie' => $ecurie,
            ]);

        file_get_contents("http://localhost:5000/updatePilote?discord=" . Auth::user()->id);

        return redirect()->back()->with('success', "Tu es bien inscrit.e, félicitation !");
    }

    public function editPilote(Request $request, $id) {
        $pilote = DB::table('pilotes')->where("id", $id)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.editPilote")->with([
            "pilote"=> $pilote->first(),
            "ecuries"=>$ecuries
        ]);
    }


    public function editPilotePost(Request $request, $id) {
        $rules = array(
            'ecurie' => 'required',
        );

        $messages = [
            'ecurie.required' => 'Vous devez donner une écurie.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        DB::table("pilotes")
            ->where("id", $id)
            ->update(['ecurie' => $request->input('ecurie')]);

        return redirect("/inscription")->with('success', "L'inscription a bien été modifié");
    }

    public function deletePilote(Request $request, $id) {
        DB::table('pilotes')->delete($id);

        file_get_contents("http://localhost:5000/updatePilote?discord=" . Auth::user()->id);

        return redirect("/inscription")->with('success', "L'inscription a bien été supprimé");
    }
}
