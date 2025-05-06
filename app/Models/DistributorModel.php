<?php

namespace App\Models;

use CodeIgniter\Model;

class DistributorModel extends Model
{
    protected $table = 'distributors'; // Nama tabel di database
    protected $primaryKey = 'kode_distributor'; // Kolom primary key
    protected $allowedFields = ['kode_distributor', 'nama_distributor', 'kode_region', 'nama_owner', 'alamat']; // Kolom yang boleh diinsert
}
