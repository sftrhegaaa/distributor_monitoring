<!DOCTYPE html>
<html>
<head>
    <title>Master Distributor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Master Distributor</h3>

    <table id="distributorTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Region</th>
                <th>Nama Distributor</th>
                <th>Alamat</th>
                <th>Area</th>
            </tr>
        </thead>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    
$(document).ready(function() {
    $('#distributorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?= base_url("distributor/datatbale") ?>',
        type: 'GET',
        columns: [
            { data: 'nama_region', name: 'regions.nama_region' },
            { data: 'nama_distributor', name: 'distributors.nama_distributor' },
            { data: 'alamat', name: 'distributors.alamat' },
            { data: 'area', name: 'regions.area' }
        ],
        // order: [[0, 'asc']],
        $(document).ready(function() {
    // $('#distributor-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     ajax: {
    //         url: "<?= base_url('distributor/datatable') ?>",
    //         type: "GET"
    //     }
    // });
});
        // Error handling
        error: function(xhr, error, code) {
            console.log('Error: ' + error);
            alert('Terjadi kesalahan saat memuat data!');
        }
    });
});

</script>
</body>
</html>
