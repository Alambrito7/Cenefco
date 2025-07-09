@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center w-100">
        <img src="{{ asset('images/logo-cenefco.png') }}" alt="Logo CENEFCO" style="width: 200px; margin-bottom: 20px;">
        <h2 class="mb-4 font-weight-bold">CENEFCO</h2>
        <p style="margin-top: -15px; font-size: 14px;">CENTRO NACIONAL DE EDUCACIÓN <br> Y FORMACIÓN CONTINUA - BOLIVIA</p>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white text-center">
                        <strong>Verifica tu correo electrónico</strong>
                    </div>

                    <div class="card-body text-center">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Te hemos enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                            </div>
                        @endif

                        <p>
                            {{ __('Antes de continuar, revisa tu correo electrónico para obtener el enlace de verificación.') }}
                        </p>
                        <p>
                            {{ __('Si no recibiste el correo') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('haz clic aquí para solicitar otro') }}
                                </button>.
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
