<?php

namespace DexBarrett\Http\Controllers;

use Illuminate\Http\Request;
use DexBarrett\Http\Requests;
use DexBarrett\Http\Controllers\Controller;
use GrahamCampbell\Throttle\Facades\Throttle;


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

        $throttler = Throttle::get(['ip' => $request->ip(), 'route' => $request->url()], 3, 30);

        if ($throttler->check() === false) {
            return redirect()->action('SessionController@index')
                ->withInput()
                ->with('message', 'se ha excedido el número de intentos de login')
                ->with('message-type', 'danger');  
        }

        if (auth()->attempt(['username' => $username, 'password' => $password])) {

            $throttler->clear();

            return redirect()->intended(action('AdminController@index'));
        }

        $throttler->hit();

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
