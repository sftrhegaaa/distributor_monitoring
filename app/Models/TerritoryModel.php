<?php

namespace App\Models;

use CodeIgniter\Model;

class TerritoryModel extends Model
{
    protected $table = 'territories'; // Nama tabel di database
    protected $primaryKey = 'kode_territory'; // Kolom primary key
    protected $allowedFields = ['kode_territory', 'nama_territory', 'kode_distributor']; // Kolom yang boleh diinsert
}
