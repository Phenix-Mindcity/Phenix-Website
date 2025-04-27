<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Auth;
use DB;
use View;

class BetController extends Controller
{
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

    public function validateBet(Request $request, $BetID) {
        $bets = DB::table('bet')->where("id", $BetID)->get();
        if ($bets->first()->status != 0 && $bets->first()->status != 3) return redirect()->back()->withErrors("Tu ne peux pas modifier le statut de ce pari");

        DB::table("bet")
            ->where("id", $BetID)
            ->update(['status' => $bets->first()->status+1]);

        return redirect()->back()->with('success', $bets->first()->status == 0 ? 'Le pari a été validé' : 'Le pari a été payé');
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
            'montant' => 'required|numeric|min:1|digits_between:1,7',
        );

        $messages = [
            'montant.required' => 'Vous devez donner un nombre valide.',
            'montant.numeric' => 'Vous devez donner un nombre valide.',
            'montant.min' => 'Vous devez donner un nombre supérieur à 1.',
            'montant.digits_between' => 'Vous devez donner un nombre supérieur à 1 et inférieur à 10 millions.',
            'ecurie.required' => 'Vous devez une écurie.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $bet = DB::table('bet')->where("discord", Auth::user()->id)->where("course", $currentCourse->name)->get();
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

}
