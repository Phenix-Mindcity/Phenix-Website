<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

    public function inscription(Request $request) {
        return View::make("dashboard.inscription");
    }

    public function membres(Request $request) {
        return View::make("dashboard.membres");
    }
}
