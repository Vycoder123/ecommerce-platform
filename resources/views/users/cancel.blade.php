<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Canceled</title>
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
        .cancel-container {
            max-width: 1200px;
            width: 100%;
            padding: 30px;
            margin: 0 auto;
        }
        .header-section {
            background: linear-gradient(to right, #dc3545, #c82333);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            color: white;
        }
        .message-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-home {
            background-color: #6c757d;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }
        .welcome-message {
            font-size: 1rem;
            color: rgba(255, 255, 0.9);
        }
    </style>
</head>
<body>
    <div class="cancel-container">
        <div class="header-section d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Thanh toán bị hủy</h2>
                <small class="welcome-message">Có vẻ bạn đã hủy thanh toán</small>
            </div>
            <div>
                <a href="{{ route('user.index') }}" class="btn btn-home">
                    <i class="fas fa-home"></i> Quay lại trang chủ
                </a>
            </div>
        </div>

        <div class="message-container">
            <p>{{ $message }}</p>
            <p>Vui lòng thử lại sau hoặc liên hệ hỗ trợ nếu gặp vấn đề.</p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
