<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #00ddeb 0%, #af48ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .login-container h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .form-control {
            border: none;
            border-bottom: 1px solid #ddd;
            border-radius: 0;
            padding-left: 40px;
            background: transparent;
        }
        .form-control:focus {
            box-shadow: none;
            border-bottom: 1px solid #af48ff;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        .btn-login {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border: none;
            border-radius: 25px;
            padding: 10px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .forgot-password {
            color: #af48ff;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        .social-btn:hover {
            transform: translateY(-2px);
        }
        .facebook { background-color: #3b5998; }
        .twitter { background-color: #1da1f2; }
        .google { background-color: #db4437; }
        .or-divider {
            position: relative;
            text-align: center;
            margin: 20px 0;
            color: #aaa;
        }
        .or-divider::before,
        .or-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #ddd;
        }
        .or-divider::before {
            left: 0;
        }
        .or-divider::after {
            right: 0;
        }
        .signup-link {
            color: #af48ff;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center">Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4 input-icon">
                <i class="fas fa-user"></i>
                <input type="email" name="email" class="form-control" placeholder="Type your username" required>
                @error('email')
                    <div class="text-danger mt-1" style="font-size: 0.9rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4 input-icon">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Type your password" required>
                @error('password')
                    <div class="text-danger mt-1" style="font-size: 0.9rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-end mb-4">
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-login">LOGIN</button>
            </div>
        </form>

        <div class="or-divider">OR SIGN UP USING</div>

        <div class="social-login">
            <a href="#" class="social-btn facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-btn google"><i class="fab fa-google"></i></a>
        </div>

        <div class="text-center mt-3">
            <span>Or </span><a href="{{ route('register.form') }}" class="signup-link">SIGN UP</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
