<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | RAPI-Sekolah</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 25px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.08);
        }

        /* HEADER */

        .login-header {
            background: #2455a4;
            color: #ffffff;
            padding: 30px 25px;
            text-align: center;
            border-bottom: 4px solid #dbeafe;
        }

        .brand h1 {
            font-size: 25px;
            font-weight: bold;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .brand p {
            font-size: 13px;
            margin: 8px 0 0;
            color: #dbeafe;
        }

        /* KONTEN LOGIN */

        .login-content {
            padding: 32px;
        }

        .login-content h2 {
            text-align: center;
            font-size: 24px;
            margin: 0 0 10px;
            color: #1e293b;
        }

        .description {
            text-align: center;
            font-size: 13px;
            line-height: 1.7;
            color: #64748b;
            margin: 0 0 28px;
        }

        /* FORM */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
            color: #334155;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            display: block;
            width: 100%;
            height: 46px;
            padding: 0 13px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            background: #ffffff;
            color: #1e293b;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }

        .form-input:focus {
            border-color: #2455a4;
            box-shadow: 0 0 0 3px rgba(36, 85, 164, 0.10);
        }

        /* PASSWORD */

        .password-input {
            padding-right: 100px;
        }

        .password-toggle {
            position: absolute;
            top: 0;
            right: 0;
            height: 46px;
            padding: 0 12px;
            border: none;
            background: transparent;
            color: #2455a4;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: #173b78;
            text-decoration: underline;
        }

        /* INGAT SAYA DAN LUPA PASSWORD */

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin: 2px 0 25px;
            font-size: 12px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #64748b;
            cursor: pointer;
        }

        .remember input {
            width: 15px;
            height: 15px;
            margin: 0;
            accent-color: #2455a4;
            cursor: pointer;
        }

        .forgot-link {
            color: #2455a4;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* TOMBOL LOGIN */

        .login-button {
            display: block;
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 7px;
            background: #2455a4;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .login-button:hover {
            background: #1d4587;
        }

        .login-button:active {
            transform: scale(0.99);
        }

        /* PESAN ERROR */

        .error-message {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        /* PESAN SUKSES */

        .success-message {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        /* FOOTER */

        .login-footer {
            border-top: 1px solid #e2e8f0;
            padding: 18px 15px;
            text-align: center;
            font-size: 11px;
            line-height: 1.7;
            color: #94a3b8;
            background: #ffffff;
        }

        /* RESPONSIVE */

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-card {
                border-radius: 10px;
            }

            .login-header {
                padding: 25px 20px;
            }

            .brand h1 {
                font-size: 23px;
            }

            .login-content {
                padding: 25px 21px;
            }

            .login-content h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            {{-- HEADER --}}
            <div class="login-header">
                <div class="brand">
                    <h1>RAPI-Sekolah</h1>
                    <p>Sistem Informasi Sekolah</p>
                </div>
            </div>


            {{-- KONTEN LOGIN --}}
            <div class="login-content">

                <h2>Login ke Sistem</h2>

                <p class="description">
                    Silakan masuk menggunakan akun yang telah terdaftar
                    untuk melanjutkan ke sistem.
                </p>


                {{-- PESAN ERROR --}}
                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif


                {{-- PESAN STATUS --}}
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif


                {{-- FORM LOGIN --}}
                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    {{-- EMAIL --}}
                    <div class="form-group">

                        <label for="email">Alamat Email</label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input"
                            value="{{ old('email') }}"
                            placeholder="Masukkan alamat email"
                            required
                            autofocus
                            autocomplete="username"
                        >

                    </div>


                    {{-- PASSWORD --}}
                    <div class="form-group">

                        <label for="password">Password</label>

                        <div class="input-wrapper">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-input password-input"
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                id="togglePassword"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                            >
                                Tampilkan
                            </button>

                        </div>

                    </div>


                    {{-- INGAT SAYA DAN LUPA PASSWORD --}}
                    <div class="form-options">

                        <label class="remember">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                            >

                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="forgot-link"
                            >
                                Lupa password?
                            </a>
                        @endif

                    </div>


                    {{-- TOMBOL LOGIN --}}
                    <button type="submit" class="login-button">
                        Masuk ke Sistem
                    </button>

                </form>

            </div>


            {{-- FOOTER --}}
            <div class="login-footer">
                &copy; {{ date('Y') }} RAPI-Sekolah<br>
                Sistem Informasi Agenda dan Penjadwalan Sekolah
            </div>

        </div>

    </div>


    {{-- JAVASCRIPT SHOW / HIDE PASSWORD --}}
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const isHidden = passwordInput.type === 'password';

            passwordInput.type = isHidden ? 'text' : 'password';

            this.textContent = isHidden
                ? 'Sembunyikan'
                : 'Tampilkan';

            this.setAttribute(
                'aria-label',
                isHidden ? 'Sembunyikan password' : 'Tampilkan password'
            );

            this.setAttribute(
                'aria-pressed',
                isHidden ? 'true' : 'false'
            );
        });
    </script>

</body>

</html>