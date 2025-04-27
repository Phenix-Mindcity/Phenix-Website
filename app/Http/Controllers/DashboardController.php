<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Auth;
use DB;
use View;

class DashboardController extends Controller
{
    public function home(Request $request) {
        $members = DB::table('users')->orderByDesc('rank')->where("rank", ">=", 5)->get();

        return View::make("dashboard.index")->with([
            "members"=>$members
        ]);
    }


    public function score(Request $request) {
        $currentCourse = DB::table("courses")->where("current", 1)->get()->first();
        $ecuries = DB::table('ecurie')->get();
        $users = DB::table('users')->get();
        $scores = DB::table('score')->orderBy('place', 'asc')->get();
        $finalScore = array();

        foreach($scores as $score) {
            if (!array_key_exists($score->ecurie, $finalScore)) $finalScore[$ecuries->where("name", $score->ecurie)->first()->id] = $score->score;
            else $finalScore[$score->ecurie] += $score->score;
        }

        ksort($finalScore);
        array_reverse($finalScore);

        return View::make("dashboard.score")->with([
            "currentCourse"=>$currentCourse,
            "users"=>$users,
            "globalScores"=>$finalScore,
            "scores"=>$scores,
            "ecuries"=>$ecuries
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
}
