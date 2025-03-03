{{-- show sản phẩm ở đây giỏ hàng gồm --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
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
        .cart-container {
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
        .cart-table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-update {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-update:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .btn-remove {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-remove:hover {
            background-color: #c82333;
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
        .btn-checkout {
            background: linear-gradient(to right, #28a745, #218838);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-checkout:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .welcome-message {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>
    <div class="cart-container">
        @if (auth()->check())
            <div class="header-section d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">Giỏ hàng của {{ auth()->user()->name }}</h2>
                    <small class="welcome-message">Manage your selected products here</small>
                </div>
                <div>
                    <a href="{{ route('user.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại cửa hàng
                    </a>
                </div>
            </div>

            @if ($cartItems->isEmpty())
                <div class="cart-table-container text-center">
                    <p class="text-muted">Giỏ hàng của bạn đang trống.</p>
                    <a href="{{ route('user.index') }}" class="btn btn-back mt-3">Tiếp tục mua sắm</a>
                </div>
            @else
                <div class="cart-table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($cartItems as $item)
                                @php $subTotal = $item->product->price * $item->quantity; $grandTotal += $subTotal; @endphp
                                <tr>
                                    <td>
                                        @if ($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        {{ $item->product->name }}
                                    </td>
                                    <td>${{ $item->product->price }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control me-2" style="width: 80px;">
                                            <button type="submit" class="btn btn-update">
                                                <i class="fas fa-sync-alt"></i> Cập nhật
                                            </button>
                                        </form>
                                    </td>
                                    <td>${{ number_format($subTotal, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-remove" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <h4>Tổng cộng: ${{ number_format($grandTotal, 2) }}</h4>
                        <a href="{{ route('checkout.index') }}" class="btn btn-checkout">
                            <i class="fas fa-check-circle"></i> Thanh toán
                        </a>
                    </div>
                </div>
            @endif
        @else
            <div class="text-center mt-5">
                <h2>Vui lòng đăng nhập để xem giỏ hàng</h2>
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
