<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .admin-container {
            max-width: 1200px;
            width: 100%;
            padding: 30px;
            margin: 0 auto;
        }
        .header-section {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            color: white;
        }
        .stats-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-manage-products {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-manage-products:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .btn-logout {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .welcome-message {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>
    <div class="admin-container">
        @if (auth()->check())
            <div class="header-section d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Xin chào, {{ auth()->user()->name }}!</h2>
                    <small class="welcome-message">Welcome to your admin dashboard</small>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-manage-products me-2">
                        <i class="fas fa-box"></i> Quản lý sản phẩm
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="stats-card">
                        <h4>Tổng sản phẩm</h4>
                        <p class="fs-2 fw-bold">{{ $totalProducts }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stats-card">
                        <h4>Tổng người dùng</h4>
                        <p class="fs-2 fw-bold">{{ $totalUsers }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="stats-card">
                        <h4>Tổng đơn hàng</h4>
                        <p class="fs-2 fw-bold">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center mt-5">
                <h2>Vui lòng đăng nhập để quản lý cửa hàng</h2>
                <div class="mt-4">
                    <a href="{{ route('login.form') }}" class="btn btn-primary me-2">Đăng nhập</a>
                    <a href="{{ route('register.form') }}" class="btn btn-success">Đăng ký</a>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
