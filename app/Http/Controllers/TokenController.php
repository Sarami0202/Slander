<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use Illuminate\Support\Facades\Mail;
use App\Mail\TokenMail;
use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        $lawyer = Lawyer::select('*')
            ->where('mail', $request->mail)
            ->where('license', 1)
            ->first();
        if ($lawyer == null)
            return (false);
        $date = date('Y-m-d h:i:s', strtotime("+5 minutes"));
        $token = str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
        Token::insert([
            'mail' => $request->mail,
            'token' => $token,
            'token_date' => $date,
        ]);
        Mail::send(
            new TokenMail(
                $request->mail,
                $token,
                $date,
            )
        );
        return ($lawyer);
    }

    public function auth(Request $request)
    {
        $date = date('Y-m-d h:i:s');
        $code = Token::select('token')
            ->where('mail', $request->mail)
            ->where('token_date', '>=', $date)
            ->orderBy('token_date', 'desc')
            ->first();
        if ($code != null)
            if ($request->token == $code->token)
                return (true);
            else
                return ($code);
        else
            return (false);
    }

    /**
     * Display the specified resource.
     */
    public function show(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Token $token)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Token $token)
    {
        //
    }
}