<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Modern App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #f8f9fa;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --border: #dee2e6;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 12px;
            --transition: all 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7ff;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .login-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .login-header {
            padding: 32px 32px 24px;
            text-align: center;
            background: linear-gradient(120deg, var(--primary), #5e35b1);
            color: white;
        }

        .login-header h1 {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .login-header p {
            opacity: 0.85;
            font-size: 14px;
        }

        .login-body {
            padding: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text-primary);
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .form-input.error {
            border-color: var(--danger);
        }

        .error-message {
            color: var(--danger);
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
        }

        .error-message::before {
            content: "!";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background-color: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 12px;
            margin-right: 6px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .checkbox-container input {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: var(--primary);
        }

        .checkbox-container label {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-bottom: 24px;
        }

        .login-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                border-radius: 16px;
            }

            .login-header,
            .login-body {
                padding: 24px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
            }

            .forgot-link {
                margin-top: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to continue to your account</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="login" class="form-label">{{ __('Email/Username/Phone') }}</label>
                        <input id="login" name="login" type="text" required autocomplete="username" autofocus
                            class="form-input @error('login') error @enderror" value="{{ old('login') }}"
                            placeholder="Enter your email, username or phone">
                        @error('login')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="form-input @error('password') error @enderror" placeholder="Enter your password">
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="remember-forgot">
                        <div class="checkbox-container">
                            <input id="remember" name="remember" type="checkbox">
                            <label for="remember">{{ __('Remember me') }}</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-button">
                        {{ __('Login') }}
                    </button>

                    <div class="register-link">
                        <p>{{ __("Don't have an account?") }} <a
                                href="{{ route('register') }}">{{ __('Register here') }}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
