<?php

namespace App\Http\Controllers;

use App\Mail\PRInquiryMail;
use App\Mail\ReceptionMail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Mail\InquiryMail;

class MailController extends Controller
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
    public function PRinquirySend(Request $request)
    {
        Mail::send(
            new PRInquiryMail(
                $request->type,
                $request->name,
                $request->mail,
                $request->tel,
                $request->body,
                $request->inquiry_date
            )
        );
    }
    
    public function LawyerInquirySend(Request $request)
    {
        Mail::send(
            new PRInquiryMail(
                $request->type,
                $request->name,
                $request->mail,
                $request->tel,
                $request->body,
                $request->inquiry_date
            )
        );
    }
    
    public function ReceptionSend(Request $request)
    {
        Mail::send(
            new ReceptionMail(
                $request->type,
                $request->name,
                $request->mail,
                $request->body,
                $request->inquiry_date
            )
        );
    }

}