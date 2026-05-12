<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">

    <div class="d-flex justify-content-between mb-4">
        <h4>Book Category Management</h4>
        <div>
            <span class="text-muted me-3">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
            <a href="../dashboard/dashboard.php" class="btn btn-secondary btn-sm">Dashboard</a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm ms-2">Logout</a>
        </div>
    </div>

    <div id="msg" class="mb-3"></div>

    <!-- ADD FORM -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">Add Category</div>
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Category ID</label>
                    <input type="text" id="add_id" class="form-control" placeholder="e.g. C001">
                    <small class="text-muted">Format: C followed by numbers</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name</label>
                    <input type="text" id="add_name" class="form-control" placeholder="Category Name">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date Modified</label>
                    <input type="text" class="form-control" value="Auto-generated" disabled>
                    <small class="text-muted">Added automatically</small>
                </div>
            </div>
            <button onclick="addCategory()" class="btn btn-primary mt-3">Add Category</button>
        </div>
    </div>

    <!-- EDIT FORM -->
    <div class="card mb-4 border-warning" id="editForm" style="display:none;">
        <div class="card-header bg-warning">Edit Category</div>
        <div class="card-body">
            <input type="hidden" id="edit_old_id">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label">Category ID</label>
                    <input type="text" id="edit_id" class="form-control">
                    <small class="text-muted">Format: C followed by numbers</small>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category Name</label>
                    <input type="text" id="edit_name" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date Modified</label>
                    <input type="text" class="form-control" value="Auto-updated" disabled>
                </div>
            </div>
            <button onclick="updateCategory()" class="btn btn-warning mt-3">Save Changes</button>
            <button onclick="closeEdit()" class="btn btn-secondary mt-3">Cancel</button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header bg-dark text-white">All Categories</div>
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Date Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const H = 'category_handler.php';

    function showMsg(type, text) {
        document.getElementById('msg').innerHTML =
            `<div class="alert alert-${type} alert-dismissible fade show">${text}<button class="btn-close" data-bs-dismiss="alert"></button></div>`;
    }

    function loadTable() {
        fetch(`${H}?action=get_all`)
            .then(r => r.json())
            .then(res => {
                const tbody = document.getElementById('tableBody');
                if (res.status === 'success' && res.data.length > 0) {
                    tbody.innerHTML = res.data.map(c => `
                        <tr>
                            <td>${c.category_id}</td>
                            <td>${c.category_Name}</td>
                            <td>${c.date_modified}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEdit('${c.category_id}','${c.category_Name}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteCategory('${c.category_id}')">Delete</button>
                            </td>
                        </tr>`).join('');
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center">No categories found.</td></tr>`;
                }
            });
    }

    function addCategory() {
        const id   = document.getElementById('add_id').value.trim();
        const name = document.getElementById('add_name').value.trim();

        if (!id || !name) { showMsg('warning', 'Please fill in all fields.'); return; }
        if (!/^C\d+$/.test(id)) { showMsg('danger', 'Category ID must be like C001'); return; }

        const fd = new FormData();
        fd.append('action', 'add');
        fd.append('category_id', id);
        fd.append('category_name', name);

        fetch(H, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                showMsg(res.status === 'success' ? 'success' : 'danger', res.message);
                if (res.status === 'success') {
                    document.getElementById('add_id').value = '';
                    document.getElementById('add_name').value = '';
                    loadTable();
                }
            });
    }

    function openEdit(id, name) {
        document.getElementById('edit_old_id').value = id;
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('editForm').style.display = 'block';
        window.scrollTo(0, 0);
    }

    function closeEdit() {
        document.getElementById('editForm').style.display = 'none';
    }

    function updateCategory() {
        const old  = document.getElementById('edit_old_id').value;
        const id   = document.getElementById('edit_id').value.trim();
        const name = document.getElementById('edit_name').value.trim();

        if (!id || !name) { showMsg('warning', 'Please fill in all fields.'); return; }
        if (!/^C\d+$/.test(id)) { showMsg('danger', 'Category ID must be like C001'); return; }

        const fd = new FormData();
        fd.append('action', 'update');
        fd.append('old_category_id', old);
        fd.append('category_id', id);
        fd.append('category_name', name);

        fetch(H, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                showMsg(res.status === 'success' ? 'success' : 'danger', res.message);
                if (res.status === 'success') { closeEdit(); loadTable(); }
            });
    }

    function deleteCategory(id) {
        if (!confirm('Delete this category?')) return;

        const fd = new FormData();
        fd.append('action', 'delete');
        fd.append('category_id', id);

        fetch(H, { method: 'POST', body: fd })
            .then(r => r.json())
            .then(res => {
                showMsg(res.status === 'success' ? 'success' : 'danger', res.message);
                if (res.status === 'success') loadTable();
            });
    }

    document.addEventListener('DOMContentLoaded', loadTable);
</script>
</body>
</html>
