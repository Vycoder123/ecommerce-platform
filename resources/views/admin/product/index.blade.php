<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
        .product-table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-add-product {
            background: linear-gradient(to right, #00ddeb, #af48ff);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-add-product:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .btn-edit {
            background-color: #ffc107;
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }
        .btn-delete {
            background-color: #dc3545;
            border: none;
            border-radius: 25px;
            padding: 8px 15px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-delete:hover {
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
                    <h2 class="mb-0">Quản lý sản phẩm</h2>
                    <small class="welcome-message">View and manage your shop's products</small>
                </div>
                <div>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-add-product me-2">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </a>
                    <a href="{{ route('admin.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="product-table-container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($products->isEmpty())
                    <p class="text-center text-muted">Hiện tại chưa có sản phẩm nào trong cửa hàng.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Tồn kho</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/50" alt="No image" class="rounded">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-edit">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash-alt"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
