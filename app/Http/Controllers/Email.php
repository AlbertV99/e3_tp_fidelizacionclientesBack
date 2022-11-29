<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class Email extends Controller{
    public static function mail($view,$correo,$asunto,$datos) {
        // $carta = new Mail();
        // $carta->to($correo);
        // $carta->to($correo);
                    //VIEW , DATOSPVIEW , CALLBACK
        Mail::send($view, $datos, (function ($message) use ($correo,$asunto){
            $message->to($correo, 'Cliente')->subject($asunto);
            $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
        }) );

        echo "Email Sent. Check your inbox.";
    }

    private function crearFuncion($correo,$asunto){
        return (function ($message) use ($correo,$asunto){
            $message->to($correo, 'Cliente')->subject($asunto);
            $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
        });
    }
/*
function($message) {
    $message->to("tico.urquhart@gmail.com", 'Cliente')->subject('Test Mail from Selva');
    $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME')
});
 */

}
