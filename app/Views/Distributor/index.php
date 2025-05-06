<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Distributor</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link ke DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <style>
        .container {
            max-width: 1200px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center mb-4">Data Distributor</h2>
        <!-- Filter Region -->
        <div class="mb-3">
            <label for="region-filter" class="form-label">Filter by Region</label>
            <select id="region-filter" class="form-select" onchange="filterByRegion()">
                <option value="">-- Pilih Region --</option>
                <?php foreach ($regions as $region): ?>
                    <option value="<?= $region['kode_region'] ?>"><?= $region['nama_region'] ?> (<?= $region['area'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <h5 id="total-distributor">Jumlah Distributor: <?= count($distributors) ?></h5>

        <a href="<?= base_url('distributor/create/') ?>" class="btn btn-primary btn-sm">Add</a>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tabel Distributor -->
        <table id="distributor-table" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Distributor</th>
                    <!-- <th>Kode Region</th> -->
                    <th>Owner</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($distributors as $distributor): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $distributor['nama_distributor']; ?></td>
                        <!-- <td><?= $distributor['kode_region']; ?></td> -->
                        <td><?= $distributor['nama_owner']; ?></td>
                        <td><?= $distributor['alamat']; ?></td>
                        <td>


                            <a href="<?= base_url('distributor/edit/' . $distributor['kode_distributor']); ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('distributor/delete/' . $distributor['kode_distributor']); ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data?');">Delete</a>
                            <!-- Tombol Detail dengan Modal -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#detailModal<?= $distributor['kode_distributor']; ?>">
                                Detail
                            </button>
                            <!-- Modal Detail -->
                            <div class="modal fade" id="detailModal<?= $distributor['kode_distributor']; ?>" tabindex="-1"
                                aria-labelledby="modalLabel<?= $distributor['kode_distributor']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?= $distributor['kode_distributor']; ?>">
                                                Detail Distributor</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Kode Distributor:</strong> <?= $distributor['kode_distributor']; ?>
                                            </p>
                                            <p><strong>Nama Distributor:</strong> <?= $distributor['nama_distributor']; ?>
                                            </p>
                                            <p><strong>Region:</strong> <?= $distributor['kode_region']; ?></p>
                                            <p><strong>Nama Region:</strong> <?= $distributor['nama_region']; ?></p>
                                            <p><strong>Owner:</strong> <?= $distributor['nama_owner']; ?></p>
                                            <p><strong>Alamat:</strong> <?= $distributor['alamat']; ?></p>

                                            <?php if (!empty($distributor['territories'])): ?>
                                                <hr>
                                                <h6>Territory:</h6>
                                                <ul>
                                                    <?php foreach ($distributor['territories'] as $territory): ?>
                                                        <li><?= $territory['kode_territory']; ?> -
                                                            <?= $territory['nama_territory']; ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- JS DataTables & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- JS dependencies for buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script>
        // Setelah 5 detik, sembunyikan alert
        setTimeout(function () {
            $('#successAlert').alert('close'); // Menutup alert secara otomatis
        }, 5000); // 5 detik
    </script>
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTables
            $('#distributor-table').DataTable({
                "ordering": true, // Enable sorting
                "paging": true,   // Enable pagination
                "searching": true, // Enable search
                dom: 'Bfrtip', // Tambahkan dom untuk tombol
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Export ke Excel',
                        className: 'btn btn-success',
                        title: 'Data Distributor',
                        exportOptions: {
                            columns: ':not(:last-child)' // Ini akan mengecualikan kolom terakhir
                        }
                    }
                ]
            });
        });
        // Fungsi untuk mengupdate data distributor berdasarkan filter region
        function filterByRegion() {
            var regionFilter = $('#region-filter').val();

            $.ajax({
                url: "<?= base_url('distributor/index') ?>", // Endpoint untuk ambil data distributor
                type: "GET",
                data: { region_filter: regionFilter },
                dataType: "json", // Tambahkan ini agar jQuery tahu format yang dikembalikan

                success: function (response) {
                    var table = $('#distributor-table').DataTable();
                    table.clear().draw();

                    $.each(response.distributors, function (index, distributor) {
                        table.row.add([
                            index + 1,
                            distributor.nama_distributor,
                            distributor.kode_region,
                            distributor.nama_owner,
                            distributor.alamat,
                            '<a href="distributor/detail/' + distributor.kode_distributor + '" class="btn btn-info btn-sm">Detail</a> ' +
                            '<a href="distributor/edit/' + distributor.kode_distributor + '" class="btn btn-warning btn-sm">Edit</a> ' +
                            '<a href="distributor/delete/' + distributor.kode_distributor + '" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data?\');">Delete</a>'
                        ]).draw(false);

                        
                    });
                    $('#total-distributor').text('Jumlah Distributor: ' + response.distributors.length);
                }

            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>