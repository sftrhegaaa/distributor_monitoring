<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Distributor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Distributor</h2>


    <!-- Menampilkan pesan error jika ada -->
    <?php if (session('error')): ?>
        <div class="alert alert-danger">
            <?= session('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('distributor/update/'.$distributor['kode_distributor']) ?>">
        <?= csrf_field() ?>

        <!-- Inputan untuk Nama Distributor -->
        <div class="mb-3">
            <label for="nama_distributor" class="form-label">Nama Distributor</label>
            <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" value="<?= esc($distributor['nama_distributor']) ?>" required>
        </div>

        <!-- Dropdown untuk Region -->
        <div class="mb-3">
            <label for="kode_region" class="form-label">Region</label>
            <select class="form-control" id="kode_region" name="kode_region" required>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['kode_region'] ?>" <?= ($distributor['kode_region'] == $region['kode_region']) ? 'selected' : '' ?>>
                        <?= $region['nama_region'] ?> (<?= $region['area'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Inputan untuk Nama Owner -->
        <div class="mb-3">
            <label for="nama_owner" class="form-label">Nama Owner</label>
            <input type="text" class="form-control" id="nama_owner" name="nama_owner" value="<?= esc($distributor['nama_owner']) ?>" required>
        </div>

        <!-- Inputan untuk Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= esc($distributor['alamat']) ?>" required>
        </div>

        <hr>
        <h4>Territory</h4>

        <!-- Menampilkan data territory jika ada -->
        <div id="territory-list">
            <?php foreach ($territories as $i => $territory): ?>
                <div class="row mb-2 territory-item">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="territory[<?= $i ?>][kode_territory]" value="<?= esc($territory['kode_territory']) ?>" placeholder="Kode Territory" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="territory[<?= $i ?>][nama_territory]" value="<?= esc($territory['nama_territory']) ?>" placeholder="Nama Territory" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-territory">Hapus</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" id="add-territory" class="btn btn-primary">Tambah Territory</button>

        <hr>

        <button type="submit" class="btn btn-success">Update Distributor</button>
    </form>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let index = <?= count($territories) ?>; // Set index sesuai jumlah data territory yang ada

        // Menambahkan field baru untuk territory
        $('#add-territory').click(function () {
            $('#territory-list').append(`
                <div class="row mb-2 territory-item">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="territory[${index}][kode_territory]" placeholder="Kode Territory" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="territory[${index}][nama_territory]" placeholder="Nama Territory" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-territory">Hapus</button>
                    </div>
                </div>
            `);
            index++;
        });

        // Menghapus field territory
        $(document).on('click', '.remove-territory', function () {
            $(this).closest('.territory-item').remove();
        });
    });
</script>

</body>
</html>
