<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
        .dashboard-container {
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
        .product-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .btn-add-to-cart {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-add-to-cart:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .btn-logout {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
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
    <div class="dashboard-container">
        @if (auth()->check())
            <div class="header-section d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Xin chào, {{ auth()->user()->name }}!</h2>
                    <small class="welcome-message">Welcome to your shopping dashboard</small>
                </div>
                <div>
                    <a href="{{ route('cart.index') }}" class="btn btn-add-to-cart me-2">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
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

            <!-- Danh sách sản phẩm -->
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="product-card">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}" style="max-height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/200" class="img-fluid rounded mb-3" alt="No image">
                            @endif
                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                            <p class="fw-bold">${{ $product->price }}</p>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="max-width: 80px;">
                                    <button type="submit" class="btn btn-add-to-cart">
                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center mt-5">
                <h2>Welcome to E-commerce Platform</h2>
                <div class="mt-4">
                    <a href="{{ route('login.form') }}" class="btn btn-primary me-2">Login</a>
                    <a href="{{ route('register.form') }}" class="btn btn-success">Register</a>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
