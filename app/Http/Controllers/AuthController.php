<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        // ritorna true se un value è presente nella request ed è stato submittato
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            // intended ti rimanda, una volta autenticato, alla pagina che avevi richiesto inizialmente
            // se non c'è, allora rimanda a '/'
            return redirect()->intended('/');
        } else {
            // non diamo dettagli sull'errore per non dare info a utenti malevoli
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
