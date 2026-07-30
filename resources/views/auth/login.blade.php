<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris Hukum</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            color: #1e293b;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 24px;
            background: white;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .login-header {
            text-align: center;
            padding: 40px 30px 20px;
        }
        .login-icon-box {
            width: 60px;
            height: 60px;
            background: rgba(15, 59, 115, 0.08);
            color: #0f3b73;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .form-control {
            border-radius: 12px;
            padding: 12px 16px;
            border-color: #e2e8f0;
            background-color: #f8fafc;
        }
        .form-control:focus {
            background-color: white;
            border-color: #0f3b73;
            box-shadow: 0 0 0 4px rgba(15, 59, 115, 0.1);
        }
        .btn-primary {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            background-color: #0f3b73;
            border: none;
            transition: all 0.2s;
        }
        .btn-primary:hover {
            background-color: #0a254d;
            transform: translateY(-1px);
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            color: #64748b;
        }
        .form-control.ps-0 {
            border-radius: 0 12px 12px 0;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="text-center mb-0">
                <img src="{{ asset('images/logo_tegal.png') }}" alt="Logo Bagian Hukum Setda Kota Tegal" style="max-width: 100%; height: auto; max-height: 180px; object-fit: contain; margin-bottom: 10px;">
                <h4 style="color: #0f3b73; font-weight: bold; margin-top: 15px; font-size: 1.2rem;">BAGIAN HUKUM<br>SETDA KOTA TEGAL</h4>
            </div>
        </div>

        <div class="card-body px-4 pb-5 pt-0">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="form-label text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Username</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <svg class="" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
</svg>
                        </span>
                        <input id="username" type="text" class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="superadmin">
                    </div>
                    @error('username')
                        <span class="invalid-feedback d-block mt-2" role="alert" style="font-size: 0.75rem;"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label text-muted small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <svg class="" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
</svg>
                        </span>
                        <input id="password" type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block mt-2" role="alert" style="font-size: 0.75rem;"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">Ingat saya</label>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        Masuk Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>


</body>
</html>