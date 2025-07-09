@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center w-100">
        <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 20px;">
       

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-white">
                        <strong>Confirmar contraseña</strong>
                    </div>

                    <div class="card-body">
                        <p>{{ __('Por favor confirma tu contraseña antes de continuar.') }}</p>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">🔒 Confirmar</button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="mt-3 text-center">
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
