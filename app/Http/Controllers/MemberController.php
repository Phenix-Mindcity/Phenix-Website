<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class MemberController extends Controller
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
}
