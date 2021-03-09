<?php

namespace App\Http\Controllers;

use App\MailSetup;
use Illuminate\Http\Request;
use App\Http\Requests\MailSetupRequest;
use Illuminate\Contracts\Encryption\Encrypter;

class MailSetupController extends Controller
{
    public function index()
        {
            $mail = MailSetup::first();
            // dd($mailSetup);
            return view('emails.mailConfig', ['mail' => $mail]);
        }

        public function store(MailSetupRequest $request)
        {
            $mail = MailSetup::create([
                'username' => $request['username'],
                'password' => encrypt($request['password']),
                'host' => $request['host'],
                'port' => $request['port'],
                'email' => $request['email'],
                'subject' => $request['subject'],
            ]);
            $mail->save();
            if ($mail) {
                return redirect('/mail')->with('successMail', 'Mail created successfully');
            }
            return redirect('/mail')->with('errorMail', 'Mail was not created! Please try again');
        }

        public function update(MailSetupRequest $request, MailSetup $mail)
        {
            $mail->update([
                'username' => $request['username'],
                'password' => encrypt($request['password']),
                'host' => $request['host'],
                'port' => $request['port'],
                'email' => $request['email'],
                'subject' => $request['subject'],
            ]);
            if ($mail) {
                return redirect('/mail')->with('successMail', 'Mail updated successfully');
            }
            return redirect('/mail')->with('errorMail', 'Mail was not updated! Please try again');
        }
}
