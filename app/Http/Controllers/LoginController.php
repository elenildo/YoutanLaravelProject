<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function auth(Request $request) 
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], [
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Email inválido',
            'password.required' => 'A senha é obrigatória'
        ]);

        if( Auth::attempt($credentials, $request->remember) ){
            $request->session()->regenerate();
            return redirect()->route('adm.clientes');
        }

        return redirect()->back()->with('login_error', 'E-mail ou senha inválida');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required','confirmed']
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Este e-mail já foi registrado anteriormente',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'Repita a senha corretamente'
        ]);

        $user = $request->all();
        $user['password'] = bcrypt($request->password);
        User::create($user);

        return redirect()->route('login');
    }
}
