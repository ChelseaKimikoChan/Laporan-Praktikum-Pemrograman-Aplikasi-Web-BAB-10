<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Kumpulan Berita Terkini</a>
            <div id="navAuth">
                </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4" id="formSection" style="display: none;">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body">
                        <h5 class="card-title" id="formTitle">Tulis Berita Baru</h5>
                        <form id="newsForm">
                            <input type="hidden" id="newsId">
                            <div class="mb-3">
                                <label class="form-label">Judul Berita</label>
                                <input type="text" id="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Isi Berita</label>
                                <textarea id="content" class="form-control" rows="4" required></textarea>
                            </div>
                            <button type="submit" id="submitBtn" class="btn btn-primary w-100">Simpan Berita</button>
                            <button type="button" id="cancelBtn" class="btn btn-secondary w-100 mt-2" style="display: none;">Batal Edit</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8" id="newsSection">
                <h4>Semua Berita Terkini</h4>
                <hr>
                <div id="newsList" class="row">
                    </div>
            </div>
        </div>
    </div>
    @vite(['resources/js/index.js'])
</body>
</html>