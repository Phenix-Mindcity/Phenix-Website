<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use View;

class SponsorController extends Controller
{
public function sponsor(Request $request) {
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.sponsor")->with([
            "sponsors"=>$sponsors
        ]);
    }

    public function createSponsor(Request $request) {
        $description = $request->input('description') == null ? "" : $request->input('description');

        $rules = array(
            'logo' => 'clamav|max:10240|required|image',
            'name' => 'required',
            'partner' => 'required',
        );

        $messages = [
            'logo.clamav' => 'Une erreur inconnue est survenue.',
            'logo.required' => 'Vous devez donner un logo valide.',
            'logo.max' => 'Le fichier est trop gros.',
            'logo.image' => 'Le fichier doit être une image.',
            'name.required' => "Vous devez donner le nom",
            'partner.required' => "Vous devez donner indiquer si il est partenaire",
        ];

        $file = $request->file('logo');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $sponsors = DB::table('sponsors')->where("name", $request->input('name'))->get()->first();
        if ($sponsors != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        $lastSponsor = DB::table('sponsors')->get()->last();
        $id = $lastSponsor != null ? $lastSponsor->id+1 : 1;


        Storage::disk('public')->put('/sponsors/' . $id . "." . $file->getClientOriginalExtension(), file_get_contents($file));

        DB::table("sponsors")
            ->insert([
                'id' => $id,
                'name' => $request->input('name'),
                'description' => $description,
                'fileName' => $id . "." . $file->getClientOriginalExtension(),
                'partner' => $request->input('partner')
            ]);

        return redirect()->back()->with('success', "Le sponsor a bien été ajouté");
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
        $description = $request->input('description') == null ? "" : $request->input('description');

        if ($actualSponsor->name != $request->input('name') && $sponsors->where("name", $request->input('name'))->first() != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        if ($file) {
            $rules = array(
                'logo' => 'clamav|max:10240|required|image',
                'name' => 'required',
                "partner" => 'required',
            );

            $messages = [
                'logo.clamav' => 'Une erreur inconnue est survenue.',
                'logo.required' => 'Vous devez donner un logo valide.',
                'logo.max' => 'Le fichier est trop gros.',
                'logo.image' => 'Le fichier doit être une image.',
                'name.required' => "Vous devez donner le nom",
                'partner.required' => "Vous devez donner indiquer si il est partenaire",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/sponsors/' . $id . "." . $file->getClientOriginalExtension(), file_get_contents($file));

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $description, 'partner' => $request->input('partner'), 'fileName'=> $id . "." . $file->getClientOriginalExtension()]);
        } else {
            $rules = array(
                'name' => 'required',
                "partner" => 'required',
            );

            $messages = [
                'name.required' => "Vous devez donner le nom",
                'partner.required' => "Vous devez donner indiquer si il est partenaire",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("sponsors")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'description' => $description, 'partner' => $request->input('partner')]);
        }


        if ($actualSponsor->name != $request->input('name')) {
            DB::table("ecurie")
                ->where("sponsor", $actualSponsor->name)
                ->update(['sponsor' => $request->input('name')]);
        }

        return redirect("/sponsor")->with('success', "Le sponsor a bien été modifié");
    }

    public function deleteSponsor(Request $request, $id) {
        $actualSponsor = DB::table('sponsors')->where("id", $id)->get()->first();
        DB::table('sponsors')->delete($id);

            DB::table("ecurie")
                ->where("sponsor", $actualSponsor->name)
                ->update(['sponsor' => "Aucun"]);

        return redirect("/sponsor")->with('success', "Le sponsor a bien été supprimé");
    }
}
