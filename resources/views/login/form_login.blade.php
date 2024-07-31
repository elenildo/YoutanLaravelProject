@extends('layout')
@section('title', 'Login')

@section('content')

<div class="p-4 md:p-5 space-y-4">
    <div class="max-w-sm mx-auto">
        <h1>Login</h1>

        @if ($msg = Session::get('login_error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <span class="font-medium">Erro: </span> {{ $msg }}
        </div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Erro: </span> {{ $error }}
            </div>
            @endforeach
        @endif

        <form action="{{ route('login.auth')}}" method="post" class="my-8">
            @csrf
            <label for="email" class="block mb-2 w-100 text-sm font-medium text-gray-900 dark:text-white">E-mail</label>
            <input type="email" name="email" id="email" placeholder="e-mail" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <label for="password" class="block mb-2 w-100 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
            <input type="password" name="password" id="password" placeholder="senha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 my-6">Entrar</button>
            <label for="remember" class="inline mb-2 mx-2 w-100 text-sm font-medium text-gray-900 dark:text-white">Lembrar-me</label>
            <input type="checkbox" name="remember" id="remember">
        </form>
        <a href="{{ route('register.auth') }}" class="no-underline hover:underline text-cyan-800">Registrar novo usuário</a>
    </div>
</div>

@endsection