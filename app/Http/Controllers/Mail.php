<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class Mail extends Controller{
    public function mail() {
        $data = array('name'=>"Arunkumar");
        Mail::send('mail', $data, function($message) {
            $message->to('easyselva@gmail.com', 'Arunkumar')->subject('Test Mail from Selva');
            $message->from('selva@snamservices.com','Selvakumar');
        });
        echo "Email Sent. Check your inbox.";
    }
}
