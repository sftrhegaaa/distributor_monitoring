<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributor Monitoring</title>
    <!-- Tambahkan link CSS, seperti Bootstrap atau custom CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Bisa tambahkan custom CSS di sini */
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header atau bagian atas layout -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Distributor Monitoring</a>
        </nav>

        <!-- Konten utama -->
        <?= $this->renderSection('content') ?>

    </div>

    <!-- Footer (Optional) -->
    <footer class="mt-4">
        <div class="text-center">
            <p>&copy; 2025 Distributor Monitoring</p>
        </div>
    </footer>

    <!-- Tambahkan JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Tambahkan script tambahan di sini -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
