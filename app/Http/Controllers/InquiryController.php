<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Mail\InquiryMail;

class InquiryController extends Controller
{
    public function inquirySend(Request $request)
    {


        Mail::send(
            new InquiryMail(
                $request->type,
                $request->name,
                $request->mail,
                $request->tel,
                $request->body,
                $request->inquiry_date
            )
        );
    }
}