<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Modern App</title>
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
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
            background: linear-gradient(135deg, #f5f7ff 0%, #e6e9ff 100%);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 900px;
        }

        .register-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            display: flex;
        }

        .register-visual {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, #5e35b1 100%);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            display: none;
        }

        .register-visual-content {
            max-width: 300px;
            text-align: center;
        }

        .register-visual h2 {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .register-visual p {
            opacity: 0.85;
            font-size: 15px;
            line-height: 1.5;
        }

        .illustration {
            width: 200px;
            height: 200px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
        }

        .register-form-container {
            flex: 1.5;
            padding: 40px;
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header h1 {
            font-weight: 600;
            font-size: 28px;
            color: var(--primary);
            margin-bottom: 8px;
        }

        .register-header p {
            color: var(--text-secondary);
            font-size: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .register-visual {
                display: flex;
            }
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            margin-bottom: 16px;
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

        .file-input-container {
            position: relative;
        }

        .file-input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            background-color: #f9fafb;
            cursor: pointer;
        }

        .file-input::file-selector-button {
            padding: 8px 16px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-right: 12px;
        }

        .file-input::file-selector-button:hover {
            background-color: var(--primary-dark);
        }

        .terms-container {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
        }

        .terms-container input {
            margin-top: 4px;
            margin-right: 10px;
            accent-color: var(--primary);
        }

        .terms-container label {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .terms-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .terms-link:hover {
            text-decoration: underline;
        }

        .register-button {
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
            margin: 16px 0 24px;
        }

        .register-button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            font-size: 15px;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-card {
                border-radius: 16px;
            }

            .register-form-container {
                padding: 24px;
            }

            .register-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-visual">
                <div class="illustration">👤</div>
                <div class="register-visual-content">
                    <h2>Join Our Community</h2>
                    <p>Create an account to access exclusive features and personalized content.</p>
                </div>
            </div>

            <div class="register-form-container">
                <div class="register-header">
                    <h1>Create Account</h1>
                    <p>Fill in your details to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name" class="form-label">{{ __('Full Name') }}</label>
                            <input id="name" name="name" type="text" required autocomplete="name" autofocus
                                class="form-input @error('name') error @enderror" value="{{ old('name') }}"
                                placeholder="Enter your full name">
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username" class="form-label">{{ __('Username') }}</label>
                            <input id="username" name="username" type="text" required autocomplete="username"
                                class="form-input @error('username') error @enderror" value="{{ old('username') }}"
                                placeholder="Choose a username">
                            @error('username')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" name="email" type="email" required autocomplete="email"
                                class="form-input @error('email') error @enderror" value="{{ old('email') }}"
                                placeholder="Enter your email">
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                            <input id="phone" name="phone" type="tel" autocomplete="tel"
                                class="form-input @error('phone') error @enderror" value="{{ old('phone') }}"
                                placeholder="Enter your phone number">
                            @error('phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="birthdate" class="form-label">{{ __('Birthdate') }}</label>
                            <input id="birthdate" name="birthdate" type="date" required
                                class="form-input @error('birthdate') error @enderror" value="{{ old('birthdate') }}">
                            @error('birthdate')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="profile_photo" class="form-label">{{ __('Profile Photo') }}</label>
                            <div class="file-input-container">
                                <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                                    class="file-input">
                            </div>
                            @error('profile_photo')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" required autocomplete="new-password"
                                class="form-input @error('password') error @enderror" placeholder="Create a password">
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                autocomplete="new-password" class="form-input" placeholder="Confirm your password">
                        </div>
                    </div>

                    <div class="terms-container">
                        <input id="terms" name="terms" type="checkbox" required>
                        <label for="terms">
                            {{ __('I agree to the') }} <a href="#"
                                class="terms-link">{{ __('Terms and Conditions') }}</a>
                            {{ __('and') }} <a href="#" class="terms-link">{{ __('Privacy Policy') }}</a>
                        </label>
                    </div>

                    <button type="submit" class="register-button">
                        {{ __('Create Account') }}
                    </button>

                    <div class="login-link">
                        <p>{{ __('Already have an account?') }} <a
                                href="{{ route('login') }}">{{ __('Login here') }}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
