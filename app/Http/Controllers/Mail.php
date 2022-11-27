<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class Email extends Controller{
    public static function mail($view,$correo,$asunto,$datos) {
                    //VIEW , DATOSPVIEW , CALLBACK
        Mail::send($view, $datos, function($message) {
            $message->to($correo, 'Cliente')->subject('Test Mail from Selva');
            $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
        });
        echo "Email Sent. Check your inbox.";
    }
}
