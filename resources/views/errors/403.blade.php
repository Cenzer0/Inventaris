<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .error-icon {
            font-size: 5rem;
            color: #ef4444;
            margin-bottom: 1.5rem;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .error-title {
            font-weight: 800;
            color: #0f3b73;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .error-subtitle {
            font-weight: 600;
            color: #475569;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .error-desc {
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-back {
            background: #0f3b73;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-back:hover {
            background: #0a2952;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(15, 59, 115, 0.3);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">
            <i class="fas fa-shield-alt"></i>
        </div>

        <div class="error-subtitle">Akses Ditolak!</div>
        <div class="error-desc">
            Mohon maaf, Anda tidak memiliki izin (hak akses) untuk membuka halaman ini.<br>
            Halaman ini hanya dapat diakses oleh role tertentu.
        </div>
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Sebelumnya
        </a>
    </div>
</body>
</html>
