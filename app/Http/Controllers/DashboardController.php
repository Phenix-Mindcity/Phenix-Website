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
        return View::make("dashboard.profile");
    }

    public function editProfile(Request $request) {
        DB::table("users")
            ->where("id", Auth::user()->id)
            ->update(['fullname' => $request->input('name'), "phone" => $request->input('phone'), "locale" => $request->input('pronom')]);

        return redirect("/dashboard");
    }

    public function validateBet(Request $request, $BetID) {
        $bets = DB::table('bet')->where("id", $BetID)->get();
        if ($bets->first()->status != 0 && $bets->first()->status != 4) return redirect()->back()->withErrors("Tu ne peux pas modifier le statut de ce pari");

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
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $bets = DB::table('bet')->where("discord", Auth::user()->id)->where("course", $currentCourse->name)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.pari")->with([
            "bets"=>$bets,
            "ecuries"=>$ecuries
        ]);
    }

    public function putBet(Request $request) {
        DB::table("bet")
            ->insert([
                'discord' => Auth::user()->id,
                'course' => $request->input('course'),
                'ecurie' => $request->input('ecurie'),
                'montant' => $request->input('montant'),
            ]);

        return redirect("/pari");
    }

    public function score(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $users = DB::table('users')->get();
        $scores = DB::table('score')->get();
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

        Storage::disk('public')->put('/profile/' . $request->input('name') . ".png", file_get_contents($file));

        $token = Str::random(32);
        Cache::add($token, now()->addMinutes(60));

        return redirect()->back()->with('success', "Pour ajouter un membre, donner lui ce lien : " . URL::to("/join/".$token));
    }

    public function join(Request $request, $token) {
        if (Cache::get($token) == null) return redirect("/dashboard")->withErrors(["Le lien est invalide"]);

        Cache::delete($token);

        DB::table("users")
            ->where("id", Auth::user()->id)
            ->update(['rank' => 5]);

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

            Storage::disk('public')->put('/profile/' . $request->input('name') . ".png", file_get_contents($file));

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

        return redirect("/membres")->with('success', "Le membre a bien été modifié");
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

        if ($file) {
            $rules = array(
                'logo' => 'clamav|max:10240|required|image',
                'name' => 'required',
                'description' => 'required',
            );

            $messages = [
                'logo.clamav' => 'Une erreur inconnue est survenue.',
                'logo.required' => 'Vous devez donner un logo valide.',
                'logo.max' => 'Le fichier est trop gros.',
                'logo.image' => 'Le fichier doit être une image.',
                'name.required' => "Vous devez donner le nom",
                'description.required' => "Vous devez donner une description",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/sponsors/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $request->input('description'), 'fileName'=> $request->input('name') . "." . $file->getClientOriginalExtension()]);
        } else {
            $rules = array(
                'name' => 'required',
                'description' => 'required',
            );

            $messages = [
                'name.required' => "Vous devez donner le nom",
                'description.required' => "Vous devez donner une description",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $request->input('description')]);
        }

        return redirect("/sponsor")->with('success', "Le sponsor a bien été modifié");
    }

    public function createSponsor(Request $request) {
        $rules = array(
            'logo' => 'clamav|max:10240|required|image',
            'name' => 'required',
            'description' => 'required',
        );

        $messages = [
            'logo.clamav' => 'Une erreur inconnue est survenue.',
            'logo.required' => 'Vous devez donner un logo valide.',
            'logo.max' => 'Le fichier est trop gros.',
            'logo.image' => 'Le fichier doit être une image.',
            'name.required' => "Vous devez donner le nom",
            'description.required' => "Vous devez donner une description",
        ];

        $file = $request->file('logo');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }


        Storage::disk('public')->put('/sponsors/' . $request->input('name') . "." . $file->getClientOriginalExtension(), file_get_contents($file));

        DB::table("sponsors")
            ->insert([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'fileName' => $request->input('name') . "." . $file->getClientOriginalExtension(),
            ]);

        return redirect()->back()->with('success', "Le sponsor a bien été ajouté");
    }

    public function inscription(Request $request) {
        return View::make("dashboard.inscription");
    }

}
