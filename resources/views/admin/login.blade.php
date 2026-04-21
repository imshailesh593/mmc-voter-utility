<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MMC Elections 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .login-wrap {
            width: 100%;
            max-width: 380px;
        }
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-brand-title {
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #ef4444;
            margin-bottom: 0.3rem;
        }
        .login-brand-sub {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.3);
            letter-spacing: 0.05em;
        }
        .login-card {
            background: #1e293b;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.08);
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
        }
        .login-card-header {
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            padding: 1.5rem 1.75rem;
        }
        .login-card-header h1 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.2rem;
        }
        .login-card-header p {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.75);
        }
        .login-card-body {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }
        .form-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: rgba(255,255,255,0.5);
        }
        .form-input {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 0.7rem 1rem;
            font-size: 0.88rem;
            color: #fff;
            font-family: inherit;
            outline: none;
            transition: border-color 0.15s, background 0.15s;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.25); }
        .form-input:focus {
            border-color: #ef4444;
            background: rgba(255,255,255,0.09);
        }
        .form-input.has-error { border-color: #f87171; }
        .field-error {
            font-size: 0.72rem;
            color: #f87171;
            font-weight: 500;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #b91c1c, #ef4444);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: filter 0.15s;
            letter-spacing: 0.03em;
        }
        .btn-login:hover { filter: brightness(1.08); }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.3);
            text-decoration: none;
            transition: color 0.15s;
        }
        .back-link:hover { color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-brand">
            <div class="login-brand-title">MMC Admin Panel</div>
            <div class="login-brand-sub">Maharashtra Medical Council Elections 2026</div>
        </div>

        <div class="login-card">
            <div class="login-card-header">
                <h1>Sign In</h1>
                <p>Enter your credentials to access the admin panel</p>
            </div>
            <div class="login-card-body">
                <form method="POST" action="{{ route('admin.login.post') }}" style="display:contents">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input {{ $errors->has('email') ? 'has-error' : '' }}"
                            placeholder="admin@example.com"
                            autofocus
                            autocomplete="email"
                        >
                        @error('email')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input {{ $errors->has('password') ? 'has-error' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login">Sign In to Admin Panel</button>
                </form>
            </div>
        </div>

        <a href="{{ route('home') }}" class="back-link">← Back to Voter Portal</a>
    </div>
</body>
</html>
