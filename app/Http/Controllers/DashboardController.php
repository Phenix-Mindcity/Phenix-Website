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

        App::setLocale($request->input('pronom'));

        return redirect("/dashboard");
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

    public function home(Request $request) {
        $members = DB::table('users')->orderByDesc('rank')->where("rank", ">=", 5)->get();

        return View::make("dashboard.index")->with([
            "members"=>$members
        ]);
    }

    public function pari(Request $request) {
        $bets = DB::table('bet')->where("discord", Auth::user()->id)->get();
        $ecuries = DB::table('ecurie')->get();

        return View::make("dashboard.pari")->with([
            "bets"=>$bets,
            "ecuries"=>$ecuries
        ]);
    }

    public function score(Request $request) {
        $scores = DB::table('score')->get();
        $finalScore = array();

        foreach($scores as $score) {
            if (!array_key_exists($score->ecurie, $finalScore)) $finalScore[$score->ecurie] = $score->score;
            else $finalScore[$score->ecurie] += $score->score;
        }

        return View::make("dashboard.score")->with([
            "scores"=>$finalScore
        ]);
    }

    public function participants(Request $request) {
        $users = DB::table('users')->get();
        $pilotes = DB::table('pilotes')->get();
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

    public function view_pari(Request $request) {
        return View::make("dashboard.view_pari");
    }

    public function membres(Request $request) {
        return View::make("dashboard.membres");
    }
}
