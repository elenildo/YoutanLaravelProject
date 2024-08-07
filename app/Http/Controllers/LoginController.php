<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function auth(UserRequest $request) 
    {
        if( Auth::attempt($request->validated(), $request->remember) ){
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

    public function store(UserStoreRequest $request)
    {
        $request->validated();

        $user = $request->all();
        $user['password'] = bcrypt($request->password);
        User::create($user);

        return redirect()->route('login');
    }
}
