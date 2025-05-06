<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Distributor</title>
    
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Link ke Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
        .territory-item {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Tambah Distributor</h2>

    <!-- Flashdata message -->
    <?= session()->getFlashdata('message'); ?>

    <form method="post" action="<?= base_url('/distributor/store') ?>">
        <!-- Kode Distributor -->
        <div class="mb-3">
            <label for="kode_distributor" class="form-label">Kode Distributor</label>
            <input type="text" class="form-control" id="kode_distributor" name="kode_distributor" required>
        </div>

        <!-- Nama Distributor -->
        <div class="mb-3">
            <label for="nama_distributor" class="form-label">Nama Distributor</label>
            <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" required>
        </div>

        <!-- Region -->
        <div class="mb-3">
            <label for="region-select" class="form-label">Region</label>
            <select name="kode_region" id="region-select" class="form-control select2" required>
                <option value="">-- Pilih Region --</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['kode_region'] ?>"><?= $region['nama_region'] ?> (<?= $region['area'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Nama Owner -->
        <div class="mb-3">
            <label for="nama_owner" class="form-label">Nama Owner</label>
            <input type="text" class="form-control" id="nama_owner" name="nama_owner" required>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" required>
        </div>

        <hr>
        <h4>Territory</h4>
        <div id="territory-list">
            <div class="territory-item">
                <input type="text" class="form-control mb-2" name="territory[0][kode_territory]" placeholder="Kode Territory" required>
                <input type="text" class="form-control mb-2" name="territory[0][nama_territory]" placeholder="Nama Territory" required>
            </div>
        </div>

        <button type="button" id="add-territory" class="btn btn-secondary mb-3">+ Tambah Territory</button>
        <hr><br>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- Script Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script jQuery dan Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Inisialisasi Select2 untuk Region
    $('#region-select').select2();

    let index = 1;

    // Fungsi untuk menambah inputan territory
    $('#add-territory').click(function() {
        $('#territory-list').append(`
            <div class="territory-item">
                <input type="text" class="form-control mb-2" name="territory[${index}][kode_territory]" placeholder="Kode Territory" required>
                <input type="text" class="form-control mb-2" name="territory[${index}][nama_territory]" placeholder="Nama Territory" required>
            </div>
        `);
        index++;
    });
});
</script>

</body>
</html>
