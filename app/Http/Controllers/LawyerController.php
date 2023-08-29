<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\LawyerComment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\LawyerMail;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->jsonResponse(Lawyer::select('*')
            ->where('license', "<=", 1)
            ->get());
    }


    public function getLawyer(Request $request)
    {
        return $this->jsonResponse(Lawyer::select('*')
            ->where('lawyer_id', $request->id)
            ->where('license', 1)
            ->get());
    }

    public function adminSearch(Request $request)
    {
        return $this->jsonResponse(Lawyer::where('license', '<=', 1)->where(function ($query) use ($request) {
            $query
                ->orWhere('name', 'like', "%$request->key%")
                ->orWhere('tel', $request->key)
                ->orWhere('num', $request->key);
        })->get());
    }
    public function getRequestLawyer(Request $request)
    {
        return $this->jsonResponse(Lawyer::select('*')
            ->where('license', 2)
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
            'tel' => $request->tel,
            'num' => $request->num,
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
            Lawyer::where('lawyer_id', $request->lawyer_id)->update([
                'img' => $path,
                'name' => $request->name,
                'mail' => $request->mail,
                'pass' => $request->pass,
                'tel' => $request->tel,
                'num' => $request->num,
                'url' => $request->url,
            ]);
        } else
            Lawyer::where('lawyer_id', $request->lawyer_id)->update([
                'name' => $request->name,
                'mail' => $request->mail,
                'pass' => $request->pass,
                'tel' => $request->tel,
                'num' => $request->num,
                'url' => $request->url,
            ]);
    }
    /**
     * Display the specified resource.
     */
    public function licenseUpdate(Request $request)
    {
        $license = Lawyer::select('license')->where('lawyer_id', $request->lawyer_id)->first();
        if ($license->license == 2)
            Mail::send(
                new LawyerMail(
                    1,
                    $request->name,
                    $request->mail,
                    $request->num,
                )
            );
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
        $license = Lawyer::select('license')->where('lawyer_id', $request->lawyer_id)->first();
        if ($license->license == 2)
            Mail::send(
                new LawyerMail(
                    0,
                    $request->name,
                    $request->mail,
                    $request->num,
                )
            );
        Lawyer::where('lawyer_id', $request->lawyer_id)
            ->delete();
        LawyerComment::where('lawyer_id', $request->lawyer_id)
            ->delete();
    }
}