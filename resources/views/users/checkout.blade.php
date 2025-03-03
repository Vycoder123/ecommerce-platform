<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán</title>
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
        .checkout-container {
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
        .checkout-details {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-paypal {
            background: linear-gradient(to right, #009cde, #003087);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-paypal:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .welcome-message {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        @if (auth()->check())
            <div class="header-section d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Thanh toán</h2>
                    <small class="welcome-message">Review your cart and proceed to payment</small>
                </div>
                <div>
                    <a href="{{ route('cart.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                </div>
            </div>

            <div class="checkout-details">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4">Chi tiết giỏ hàng</h3>
                    <ul class="list-group">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                                <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-4 text-xl font-bold">
                        Tổng tiền: ${{ number_format($total, 2) }}
                        <div class="text-sm text-gray-600">
                            ({{ number_format($total / 23000, 2, '.', '') }} USD)
                        </div>
                    </div>
                </div>

                <form action="{{ route('paywithpaypal') }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="btn btn-paypal w-100">
                        <i class="fab fa-paypal"></i> Thanh toán với PayPal
                    </button>
                </form>
            </div>
        @else
            <div class="text-center mt-5">
                <h2>Vui lòng đăng nhập để thanh toán</h2>
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
