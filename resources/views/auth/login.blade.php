@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center w-100">
        <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 400px; margin-bottom: 20px;">
        

        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-white">
                        <strong>Autenticarse para iniciar sesión</strong>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input id="email" type="email" class="form-control" name="email" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Recordarme</label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">🔐 Acceder</button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}">Olvidé mi contraseña</a><br>
                            <a href="{{ route('register') }}">Crear una nueva cuenta</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
