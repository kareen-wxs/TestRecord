@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card no-select">
                    <div class="card-header d-flex align-items-center justify-content-between bg-white">
                        <div id="kz-title" class="d-block w-100 text-center">
                            <h2>Indikativ</h2>
                        </div>
                        <div id="tr-title" class="d-block w-100 text-center d-none">
                            <h2>Indikativ</h2>
                        </div>
                        <div id="ru-title" class="d-block w-100 text-center d-none">
                            <h2>Indikativ</h2>
                        </div>
                        <div class="login__logo_block text-end ms-lg-3">
                            <img src="{{ asset('images/ayu_logo.png') }}" class="login-logo">
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('adminLoginForm') }}">
                            @csrf
                            <input type="hidden" name="endRoute" class="endRoute" value="admin">
                            @error('login')
                                <span class="invalid-feedback text-center  mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="row mb-3">
                                <label id="kz-email" for="email" class="col-md-4 col-form-label text-md-end">Электрондық
                                    пошта</label>
                                <label id="tr-email" for="email" class="col-md-4 col-form-label text-md-end d-none">E-posta</label>
                                <label id="ru-email" for="email" class="col-md-4 col-form-label text-md-end d-none">Электронная почта</label>
                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" required
                                        autofocus>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label id="kz-pas" for="password" class="col-md-4 col-form-label text-md-end">Құпия
                                    сөз</label>
                                <label id="tr-pas" for="password" class="col-md-4 col-form-label text-md-end d-none">Parola</label>
                                <label id="ru-pas" for="password" class="col-md-4 col-form-label text-md-end d-none">Пароль</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="offset-md-4">
                                    <div class="d-flex gap-2">
                                        <input type="radio" id="kz-input" name="lang_code" value="kz" checked class="d-none">
                                        <label for="kz-input">
                                            <img id="kz-icon" src="{{ asset('images/kz_icon.png') }}"
                                                class="lang_img active" width="30">
                                        </label>
                                        <input type="radio" id="tr-input" name="lang_code" value="tr" class="d-none">
                                        <label for="tr-input">
                                            <img id="tr-icon" src="{{ asset('images/tr_icon.png') }}" class="lang_img"
                                                width="30">
                                        </label>
                                        <input type="radio" id="ru-input" name="lang_code" value="ru" class="d-none">
                                        <label for="ru-input">
                                            <img id="ru-icon" src="{{ asset('images/ru_icon.jpg') }}" class="lang_img"
                                                width="30">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" id="submit" class="btn btn-primary">
                                        <div id="kz-login">Кіру</div>
                                        <div id="tr-login" class="d-none">Giriş</div>
                                        <div id="ru-login" class="d-none">Войти</div>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kzIcon = document.getElementById('kz-icon');
            const trIcon = document.getElementById('tr-icon');
            const ruIcon = document.getElementById('ru-icon');
            const kzTitle = document.getElementById('kz-title');
            const trTitle = document.getElementById('tr-title');
            const ruTitle = document.getElementById('ru-title');
            const kzLogin = document.getElementById('kz-login');
            const trLogin = document.getElementById('tr-login');
            const ruLogin = document.getElementById('ru-login');
            const kzPas = document.getElementById('kz-pas');
            const trPas = document.getElementById('tr-pas');
            const ruPas = document.getElementById('ru-pas');
            const kzEmail = document.getElementById('kz-email');
            const trEmail = document.getElementById('tr-email');
            const ruEmail = document.getElementById('ru-email');

            kzIcon.addEventListener('click', function() {
                kzIcon.classList.add('active');
                trIcon.classList.remove('active');
                ruIcon.classList.remove('active');
                kzTitle.classList.remove('d-none');
                trTitle.classList.add('d-none');
                ruTitle.classList.add('d-none');
                kzLogin.classList.remove('d-none');
                trLogin.classList.add('d-none');
                ruLogin.classList.add('d-none');
                kzPas.classList.remove('d-none');
                trPas.classList.add('d-none');
                ruPas.classList.add('d-none');
                kzEmail.classList.remove('d-none');
                trEmail.classList.add('d-none');
                ruEmail.classList.add('d-none');
            });

            trIcon.addEventListener('click', function() {
                trIcon.classList.add('active');
                kzIcon.classList.remove('active');
                ruIcon.classList.remove('active');
                trTitle.classList.remove('d-none');
                kzTitle.classList.add('d-none');
                ruTitle.classList.add('d-none');
                trLogin.classList.remove('d-none');
                kzLogin.classList.add('d-none');
                ruLogin.classList.add('d-none');
                trPas.classList.remove('d-none');
                kzPas.classList.add('d-none');
                ruPas.classList.add('d-none');
                trEmail.classList.remove('d-none');
                kzEmail.classList.add('d-none');
                ruEmail.classList.add('d-none');
            });

            ruIcon.addEventListener('click', function() {
                ruIcon.classList.add('active');
                kzIcon.classList.remove('active');
                trIcon.classList.remove('active');
                ruTitle.classList.remove('d-none');
                kzTitle.classList.add('d-none');
                trTitle.classList.add('d-none');
                ruLogin.classList.remove('d-none');
                kzLogin.classList.add('d-none');
                trLogin.classList.add('d-none');
                ruPas.classList.remove('d-none');
                kzPas.classList.add('d-none');
                trPas.classList.add('d-none');
                ruEmail.classList.remove('d-none');
                kzEmail.classList.add('d-none');
                trEmail.classList.add('d-none');
            });
        });
    </script>
    <style>
        .no-select {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .card {
            border-top: 3px solid #28a745;
        }

        .login-logo {
            max-width: 120px;
        }

        .lang_img {
            border: 1px solid transparent;
            cursor: pointer;
        }

        .active {
            border: 1px solid #000;
        }

        @media (max-width: 930px) {
            .card-header {
                display: block !important;
            }

            .login__logo_block {
                text-align: center !important;
                margin-top: 20px;
                max-width: 100%;
            }

            .login-logo {
                max-width: 240px;
            }
        }

        @media (max-width: 390px) {
            .login-logo {
                max-width: 180px;
            }
        }
    </style>
@endsection
