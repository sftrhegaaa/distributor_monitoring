<?php

namespace App\Models;

use CodeIgniter\Model;

class RegionModel extends Model
{
    protected $table = 'regions'; // Nama tabel di database
    protected $primaryKey = 'kode_region'; // Kolom primary key
    protected $allowedFields = ['kode_region', 'nama_region', 'area']; // Kolom yang boleh diinsert
}
