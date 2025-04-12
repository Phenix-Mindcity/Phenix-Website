<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use View;

class DashboardController extends Controller
{
    public function profile(Request $request) {
        return View::make("dashboard.profile");
    }

    public function editProfile(Request $request) {
        DB::table("users")
            ->where("id", Auth::user()->id)
            ->update(['fullname' => $request->input('name'), "locale" => $request->input('pronom')]);

        return redirect("/dashboard");
    }

    public function home(Request $request) {
        $members = DB::table('users')->orderByDesc('rank')->where("rank", ">=", 5)->get();

        return View::make("dashboard.index")->with([
            "members"=>$members
        ]);
    }
}
