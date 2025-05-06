<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<h4>Tambah Distributor</h4>

<form id="formDistributor">
  <div class="mb-2">
    <label>Nama Distributor</label>
    <input type="text" name="nama_distributor" class="form-control" required>
  </div>

  <div class="mb-2">
    <label>Region</label>
    <select name="kode_region" id="selectRegion" class="form-control" required></select>
  </div>

  <div class="mb-2">
    <label>Nama Owner</label>
    <input type="text" name="nama_owner" class="form-control" required>
  </div>

  <div class="mb-2">
    <label>Alamat</label>
    <input type="text" name="alamat" class="form-control" required>
  </div>

  <hr>

  <label>Territory</label>
  <div id="territoryContainer">
    <div class="row mb-2 territory-group">
      <div class="col">
        <input type="text" name="territories[0][kode_territory]" class="form-control" placeholder="Kode Territory" required>
      </div>
      <div class="col">
        <input type="text" name="territories[0][nama_territory]" class="form-control" placeholder="Nama Territory" required>
      </div>
      <div class="col-auto">
        <button type="button" class="btn btn-danger btnRemove">×</button>
      </div>
    </div>
  </div>

  <button type="button" class="btn btn-secondary mb-3" id="addTerritory">+ Tambah Territory</button>

  <button type="submit" class="btn btn-primary">Simpan</button>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function () {
  let index = 1;

  $('#selectRegion').select2({
    placeholder: 'Pilih Region',
    ajax: {
      url: '/region/select2',
      dataType: 'json',
      processResults: data => ({
        results: data.map(r => ({ id: r.kode_region, text: r.nama_region }))
      })
    }
  });

  $('#addTerritory').click(function () {
    $('#territoryContainer').append(`
      <div class="row mb-2 territory-group">
        <div class="col">
          <input type="text" name="territories[${index}][kode_territory]" class="form-control" placeholder="Kode Territory" required>
        </div>
        <div class="col">
          <input type="text" name="territories[${index}][nama_territory]" class="form-control" placeholder="Nama Territory" required>
        </div>
        <div class="col-auto">
          <button type="button" class="btn btn-danger btnRemove">×</button>
        </div>
      </div>
    `);
    index++;
  });

  $(document).on('click', '.btnRemove', function () {
    $(this).closest('.territory-group').remove();
  });

  $('#formDistributor').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: '/distributor/create',
      method: 'POST',
      data: $(this).serialize(),
      success: res => {
        alert('Data berhasil disimpan');
        this.reset();
        $('#selectRegion').val(null).trigger('change');
        $('#territoryContainer').html('');
        index = 1;
      }
    });
  });
});
</script>
<?= $this->endSection() ?>
