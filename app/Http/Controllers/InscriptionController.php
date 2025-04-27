<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use URL;
use Auth;
use DB;
use View;

class InscriptionController extends Controller
{
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
