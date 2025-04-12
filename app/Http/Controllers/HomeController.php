<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use View;

class HomeController extends Controller
{
    public function index() {
        $members = DB::table('users')->orderByDesc('rank')->where("rank", ">=", 5)->get();
        $sponsors = DB::table('sponsors')->get();

        return View::make("home")->with([
            "members"=>$members,
            "sponsors"=>$sponsors
        ]);
    }
}
