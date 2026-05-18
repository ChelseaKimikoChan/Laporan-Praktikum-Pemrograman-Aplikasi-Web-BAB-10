<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Daftar Akun Baru</h4>
                        <div id="alertContainer"></div>
                        
                        <form id="registerForm">
                            <div class="mb-3">
                                <label class="form-label">Name Akun</label>
                                <input type="text" id="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Daftar</button>
                        </form>
                        <p class="text-center mt-3 small">Sudah punya akun? <a href="/login">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/register.js'])
</body>
</html>