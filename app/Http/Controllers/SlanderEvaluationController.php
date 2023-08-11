<?php

namespace App\Http\Controllers;

use App\Models\SlanderEvaluation;
use Illuminate\Http\Request;

class SlanderEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->jsonResponse(SlanderEvaluation::all());
    }

    /**
     * Store a newly created resource in storage.
     */public function create(Request $request)
    {

        $ip = $request->ip();
        $timestamp = $request->ua;
        $secret = "ojsdalifhjowahpsdj";
        $id_hash = hash_hmac("sha1", $timestamp . $ip, $secret);
        $id_base64 = base64_encode($id_hash);
        $user_id = substr($id_base64, 0, 8);


        $check = SlanderEvaluation::select('*')
            ->where('slander_id', $request->slander_id)
            ->where('user_id', $user_id)
            ->get();

        if (!empty($check))
            SlanderEvaluation::where('slander_id', $request->slander_id)
                ->where('user_id', $user_id)
                ->delete();

        SlanderEvaluation::insert([
            'slander_id' => $request->slander_id,
            'user_id' => $user_id,
            'type' => $request->type,
            'slander_evaluation_date' => $request->slander_evaluation_date,
        ]);
    }

    public function destroy(Request $request)
    {

        $ip = $request->ip();
        $timestamp = $request->ua;
        $secret = "ojsdalifhjowahpsdj";
        $id_hash = hash_hmac("sha1", $timestamp . $ip, $secret);
        $id_base64 = base64_encode($id_hash);
        $user_id = substr($id_base64, 0, 8);

        SlanderEvaluation::where('slander_id', $request->slander_id)
            ->where('type', $request->type)
            ->where('user_id', $user_id)
            ->delete();
    }
}