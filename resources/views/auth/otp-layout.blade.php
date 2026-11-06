<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') | RAPI-Sekolah</title>

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
            margin: 0 0 25px;
        }

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

        .success-message {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .extra-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
        }

        .extra-link a {
            color: #2455a4;
            text-decoration: none;
        }

        .extra-link a:hover {
            text-decoration: underline;
        }

        .email-note {
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #2455a4;
            padding: 12px;
            border-radius: 7px;
            font-size: 13px;
            text-align: center;
            margin-bottom: 20px;
            word-break: break-word;
        }

        .login-footer {
            border-top: 1px solid #e2e8f0;
            padding: 18px 15px;
            text-align: center;
            font-size: 11px;
            line-height: 1.7;
            color: #94a3b8;
            background: #ffffff;
        }

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

            <div class="login-header">
                <div class="brand">
                    <h1>RAPI-Sekolah</h1>
                    <p>Sistem Informasi Sekolah</p>
                </div>
            </div>

            <div class="login-content">

                <h2>@yield('heading')</h2>

                <p class="description">
                    @yield('description')
                </p>

                @if ($errors->any())
                    <div class="error-message">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')

            </div>

            <div class="login-footer">
                &copy; {{ date('Y') }} RAPI-Sekolah<br>
                Sistem Informasi Agenda dan Penjadwalan Sekolah
            </div>

        </div>

    </div>

</body>
</html>