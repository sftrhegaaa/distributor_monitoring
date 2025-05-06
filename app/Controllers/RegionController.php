<?php

namespace App\Controllers;

use App\Models\RegionModel;
use CodeIgniter\Controller;

class RegionController extends Controller
{
    public function select2()
    {
        $region = new RegionModel();
        $data = $region->findAll();

        $results = array_map(function ($r) {
            return [
                'id' => $r['kode_region'],
                'text' => $r['nama_region']
            ];
        }, $data);

        return $this->response->setJSON($results);
    }
}
