const token = localStorage.getItem('token');
let currentUser = null; 

async function init() {
    if (token) {
        try {
            const response = await fetch('/api/user', {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            if (response.ok) {
                currentUser = await response.json();
                
                document.getElementById('formSection').style.display = 'block';
                document.getElementById('navAuth').innerHTML = `
                    <span class="text-light me-3">Halo, <strong>${currentUser.name}</strong></span>
                    <button onclick="logout()" class="btn btn-outline-danger btn-sm">Logout</button>
                `;
            } else {
                localStorage.removeItem('token');
                window.location.reload();
            }
        } catch (error) {
            console.error("Gagal memuat data user:", error);
        }
    } else {
        document.getElementById('newsSection').className = 'col-md-12';
        document.getElementById('navAuth').innerHTML = `
            <a href="/login" class="btn btn-outline-light btn-sm">Login Penulis</a>
        `;
    }

    loadNews();
}

function logout() {
    localStorage.removeItem('token');
    alert('Berhasil Logout!');
    window.location.reload();
}

async function loadNews() {
    const response = await fetch('/api/news');
    const news = await response.json();
    const listContainer = document.getElementById('newsList');
    listContainer.innerHTML = '';

    if(news.length === 0) {
        listContainer.innerHTML = `<p class="text-muted">Belum ada berita yang ditulis.</p>`;
        return;
    }

    news.forEach(item => {
        const authorName = item.user ? item.user.name : 'Anonim';

        let actionButtons = '';
        if (token && currentUser && currentUser.id === item.user_id) {
            actionButtons = `
                <div class="card-footer bg-transparent border-0 d-flex gap-2">
                    <button onclick="editNews(${item.id}, '${item.title}', '${escape(item.content)}')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="deleteNews(${item.id})" class="btn btn-danger btn-sm">Hapus</button>
                </div>
            `;
        }

        listContainer.innerHTML += `
            <div class="col-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">${item.title}</h5>
                        <p class="card-text text-secondary">${item.content}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                            <small class="text-muted">Penulis: <span class="badge bg-secondary">${authorName}</span></small>
                            <small class="text-muted">Diposting pada: ${new Date(item.created_at).toLocaleString('id-ID')}</small>
                        </div>
                    </div>
                    ${actionButtons}
                </div>
            </div>
        `;
    });
}

document.getElementById('newsForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('newsId').value;
    const title = document.getElementById('title').value;
    const content = document.getElementById('content').value;

    let url = '/api/news';
    let method = 'POST';

    if (id) {
        url = `/api/news/${id}`;
        method = 'PUT';
    }

    const response = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify({ title, content })
    });

    const data = await response.json();
    if (response.ok) {
        alert(data.message);
        resetForm();
        loadNews();
    } else {
        alert(data.message || 'Gagal mengeksekusi perintah!');
    }
});

function editNews(id, title, encodedContent) {
    document.getElementById('newsId').value = id;
    document.getElementById('title').value = title;
    document.getElementById('content').value = unescape(encodedContent);
    
    document.getElementById('formTitle').innerText = "Edit Berita ID #" + id;
    document.getElementById('submitBtn').className = "btn btn-warning w-100";
    document.getElementById('submitBtn').innerText = "Simpan Perubahan";
    document.getElementById('cancelBtn').style.display = "block";
}

async function deleteNews(id) {
    if (confirm('Apakah kamu yakin ingin menghapus berita ini?')) {
        const response = await fetch(`/api/news/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });

        const data = await response.json();
        alert(data.message);
        loadNews();
    }
}

function resetForm() {
    document.getElementById('newsId').value = '';
    document.getElementById('title').value = '';
    document.getElementById('content').value = '';
    document.getElementById('formTitle').innerText = "Tulis Berita Baru";
    document.getElementById('submitBtn').className = "btn btn-primary w-100";
    document.getElementById('submitBtn').innerText = "Simpan Berita";
    document.getElementById('cancelBtn').style.display = "none";
}

document.getElementById('cancelBtn').addEventListener('click', resetForm);

window.logout = logout;
window.editNews = editNews;
window.deleteNews = deleteNews;
window.loadNews = loadNews;

init();