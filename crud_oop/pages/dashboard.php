<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <button id="logoutButton" class="btn btn-danger float-end">Logout</button>
    <h2 class="mb-4 text-center">🗂️ Dashboard - Item List</h2>
    <h5 class="text-center">Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></h5>
    <!-- Add New Item Form -->
    <div class="card mb-4 add-item">
        <div class="card-body">
            <h5 class="card-title">Add New Item</h5>
            <form id="addItemForm">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="col">
                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card mb-4 edit-item d-none">
        <div class="card-body">
            <h5 class="card-title">Update Item</h5>
            <form id="updateItemForm">
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" name="title" class="form-control" id="edit-title">
                    </div>
                    <div class="col">
                        <input type="text" name="description" class="form-control" id="edit-description">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" id="update-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Item Table -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="itemsTable">
        <!-- Filled by AJAX -->
        </tbody>
    </table>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>
<!-- Custom -->
<script src="../assets/js/dashboard.js"></script>
</body>
</html>