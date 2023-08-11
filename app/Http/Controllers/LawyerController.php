<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Http\Request;

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
            ->where('id', $request->id)
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

    /**
     * Display the specified resource.
     */
    public function show(Lawyer $lawyer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lawyer $lawyer)
    {
        //
    }
}