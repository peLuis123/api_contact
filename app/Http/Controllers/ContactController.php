<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];
        Mail::raw($data['message'], function ($message) use ($data) {
            $message->to('pedro.ramos@devitm.com')
                    ->subject('Nuevo mensaje de contacto')
                    ->from($data['email'], $data['name']);
        });

        return response()->json(['message' => 'Mensaje enviado correctamente']);
    }
}
