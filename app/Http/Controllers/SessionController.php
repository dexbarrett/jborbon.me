<?php

namespace DexBarrett\Http\Controllers;

use Illuminate\Http\Request;

use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;


class SessionController extends Controller
{
    public function index()
    {
        return view('front.login');
    }

    public function create(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (auth()->attempt(['username' => $username, 'password' => $password])) {
            return redirect()->intended(action('AdminController@index'));
        }

        return redirect()->action('SessionController@index')
                ->withInput()
                ->with('message', 'los datos de usuario son incorrectos')
                ->with('message-type', 'warning');  
    }

    public function destroy()
    {
        if (auth()->check()) {
            auth()->logout();
        }

        return redirect()->to('/')
                ->with('message', 'Hasta la vista, baby')
                ->with('message-type', 'success');    
    }
}
