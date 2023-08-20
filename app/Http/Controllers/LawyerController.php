<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\LawyerComment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->jsonResponse(Lawyer::all());
    }


    public function getLawyer(Request $request)
    {
        return $this->jsonResponse(Lawyer::select('*')
            ->where('lawyer_id', $request->id)
            ->get());
    }
    public function auth(Request $request)
    {
        return $this->jsonResponse(Lawyer::select('*')
            ->where('mail', $request->mail)
            ->where('pass', $request->pass)
            ->where('license', 1)
            ->get());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $path = null;
        if ($request['img'] != null) {
            $main_file = $request->file('img');
            $path = isset($main_file) ? $main_file->store('icon', 'public') : null;
        }

        Lawyer::insert([
            'img' => $path,
            'name' => $request->name,
            'mail' => $request->mail,
            'pass' => $request->pass,
            'url' => $request->url,
        ]);
    }

    public function update(Request $request)
    {
        $path = null;
        if ($request['img'] != null) {
            $main_file = $request->file('img');
            $path = isset($main_file) ? $main_file->store('icon', 'public') : null;
            $lawyer = Lawyer::where('lawyer_id', $request->lawyer_id)->first();
            Storage::disk('public')->delete($lawyer->img);
        }
        Lawyer::where('lawyer_id', $request->lawyer_id)->update([
            'img' => $path,
            'name' => $request->name,
            'mail' => $request->mail,
            'pass' => $request->pass,
            'url' => $request->url,
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function licenseUpdate(Request $request)
    {
        Lawyer::where('lawyer_id', $request->lawyer_id)->update([
            'license' => $request->license
        ]);
    }
    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Lawyer::where('lawyer_id', $request->lawyer_id)
            ->delete();
        LawyerComment::where('lawyer_id', $request->lawyer_id)
            ->delete();
    }
}