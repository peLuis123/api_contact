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
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Dirección de correo electrónico no válida', 'email' => $data['email']], 400);
        }

        // Verificar que el mensaje no esté vacío
        if (empty($data['message'])) {
            return response()->json(['error' => 'El mensaje no puede estar vacío'], 400);
        }
        Mail::raw($data['message'], function ($message) use ($data) {
            $message->to('pedro.ramos@devitm.com')
                    ->subject('Nuevo mensaje de contacto')
                    ->from($data['email'], $data['name']);
        });

        return response()->json(['message' => 'Mensaje enviado correctamente']);
    }
}
