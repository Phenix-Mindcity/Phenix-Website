<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
use View;

class EcurieController extends Controller
{
    public function ecurie(Request $request) {
        $ecuries = DB::table('ecurie')->get();
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.ecurie")->with([
            "ecuries"=>$ecuries,
            "sponsors"=>$sponsors
        ]);
    }

    public function createEcurie(Request $request) {
        $rules = array(
            'logo' => 'clamav|max:10240|required|image',
            'name' => 'required',
            'sponsor' => 'required',
        );

        $messages = [
            'logo.clamav' => 'Une erreur inconnue est survenue.',
            'logo.required' => 'Vous devez donner un logo valide.',
            'logo.max' => 'Le fichier est trop gros.',
            'logo.image' => 'Le fichier doit être une image.',
            'name.required' => "Vous devez donner le nom",
            'sponsor.required' => "Vous devez donner une description",
        ];

        $file = $request->file('logo');

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $ecuries = DB::table('ecurie')->where("name", $request->input('name'))->get()->first();
        if ($ecuries != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        $lastEcurie = DB::table('ecurie')->get()->last();
        $id = $lastEcurie != null ? $lastEcurie->id+1 : 1;

        Storage::disk('public')->put('/ecuries/' . $id . "." . $file->getClientOriginalExtension(), file_get_contents($file));

        DB::table("ecurie")
            ->insert([
                'id' => $id,
                'name' => $request->input('name'),
                'sponsor' => $request->input('sponsor'),
                'fileName' => $id . "." . $file->getClientOriginalExtension(),
            ]);

        return redirect()->back()->with('success', "L'écurie a bien été ajouté");
    }

    public function editEcurie(Request $request, $id) {
        $ecurie = DB::table('ecurie')->where("id", $id)->get();
        $sponsors = DB::table('sponsors')->get();

        return View::make("dashboard.editEcurie")->with([
            "ecurie"=>$ecurie->first(),
            "sponsors"=>$sponsors
        ]);
    }

    public function editEcuriePost(Request $request, $id) {
        $file = $request->file('logo');
        $ecuries = DB::table('ecurie')->get();
        $actualEcurie = $ecuries->where("id", $id)->first();

        if ($actualEcurie->name != $request->input('name') && $ecuries->where("name", $request->input('name'))->first() != null) return redirect()->back()->withErrors("Ce nom existe déjà !");

        if ($file) {
            $rules = array(
                'logo' => 'clamav|max:10240|required|image',
                'name' => 'required',
                'sponsor' => 'required',
            );

            $messages = [
                'logo.clamav' => 'Une erreur inconnue est survenue.',
                'logo.required' => 'Vous devez donner un logo valide.',
                'logo.max' => 'Le fichier est trop gros.',
                'logo.image' => 'Le fichier doit être une image.',
                'name.required' => "Vous devez donner le nom",
                'sponsor.required' => "Vous devez donner  un sponsor valide",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            Storage::disk('public')->put('/ecuries/' . $id . "." . $file->getClientOriginalExtension(), file_get_contents($file));

            DB::table("ecurie")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'sponsor' => $request->input('sponsor'), 'fileName'=> $id . "." . $file->getClientOriginalExtension()]);
        } else {
            $rules = array(
                'name' => 'required',
                'sponsor' => 'required',
            );

            $messages = [
                'name.required' => "Vous devez donner le nom",
                'sponsor.required' => "Vous devez donner un sponsor valide",
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::table("ecurie")
                ->where("id", $id)
                ->update(['name' => $request->input('name'), 'sponsor' => $request->input('sponsor')]);
        }

        if ($actualEcurie->name != $request->input('name')) {
            DB::table("bet")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);

            DB::table("pilotes")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);

            DB::table("score")
                ->where("ecurie", $actualEcurie->name)
                ->update(['ecurie' => $request->input('name')]);
        }



        return redirect("/ecurie")->with('success', "L'écurie a bien été modifié");
    }

    public function deleteEcurie(Request $request, $id) {
        $actualEcurie = DB::table('ecurie')->where("id", $id)->get()->first();
        DB::table('ecurie')->delete($id);

        DB::table("bet")->where('ecurie', $actualEcurie->name)->delete();
        DB::table("pilotes")->where('ecurie', $actualEcurie->name)->delete();
        DB::table("score")->where('ecurie', $actualEcurie->name)->delete();

        return redirect("/ecurie")->with('success', "L'écurie a bien été supprimé");
    }
}
