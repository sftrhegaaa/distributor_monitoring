<?php

namespace App\Controllers;

use App\Models\RegionModel;
use App\Models\DistributorModel;
use App\Models\TerritoryModel;

class DistributorController extends BaseController
{
    protected $regionModel;
    protected $distributorModel;
    protected $territoryModel;

    public function __construct()
    {
        $this->regionModel = new RegionModel();
        $this->distributorModel = new DistributorModel();
        $this->territoryModel = new TerritoryModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $regionModel = new RegionModel();

        $regions = $regionModel->findAll();
        return view('distributor/table', ['regions' => $regions]);
    }

    public function show()
    {
        $distributors['distributors'] = $this->distributorModel->findAll();
        return view('distributor/index', ['distributors' => $distributors]);

    }
    // public function index()
    // {
    //     $distributorModel = new DistributorModel();
    //     $territoryModel = new TerritoryModel();
    //     $regionModel = new RegionModel();

    //     $regions = $regionModel->findAll();
    //     $regionFilter = $this->request->getVar('region_filter');

    //     // Build query dengan join
    //     $builder = $distributorModel
    //         ->select('distributors.*, regions.nama_region, regions.area')
    //         ->join('regions', 'regions.kode_region = distributors.kode_region', 'left');

    //     // Jika ada filter, tambahkan where
    //     if (!empty($regionFilter)) {
    //         $builder->where('distributors.kode_region', $regionFilter);
    //     }

    //     $distributors = $builder->findAll();

    //     // Ambil territory masing-masing distributor
    //     foreach ($distributors as &$d) {
    //         $d['territories'] = $territoryModel
    //             ->where('kode_distributor', $d['kode_distributor'])
    //             ->findAll();
    //     }

    //     // AJAX response (jika datanya untuk datatables atau dynamic filter)
    //     if ($this->request->isAJAX()) {
    //         return $this->response->setJSON(['distributors' => $distributors]);
    //     }

    //     // View
    //     return view('distributor/index', [
    //         'distributors' => $distributors,
    //         'regions' => $regions,
    //     ]);
    // }

    public function create()
    {
        $data['regions'] = $this->regionModel->findAll();
        return view('distributor/form', $data);
    }

    public function store()
    {
        $distributorData = [
            'kode_distributor' => $this->request->getPost('kode_distributor'),
            'nama_distributor' => $this->request->getPost('nama_distributor'),
            'kode_region' => $this->request->getPost('kode_region'),
            'nama_owner' => $this->request->getPost('nama_owner'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $territories = $this->request->getPost('territory');

        $this->distributorModel->insert($distributorData);
        foreach ($territories as $terr) {
            $this->territoryModel->insert([
                'kode_territory' => $terr['kode_territory'],
                'nama_territory' => $terr['nama_territory'],
                'kode_distributor' => $distributorData['kode_distributor']
            ]);
        }


        return redirect()->to('/')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $distributorModel = new DistributorModel();
        $territoryModel = new TerritoryModel();
        $regionModel = new RegionModel();

        $distributor = $distributorModel->find($id);
        $territories = $territoryModel->where('kode_distributor', $id)->findAll();
        $regions = $regionModel->findAll();

        return view('distributor/edit', [
            'distributor' => $distributor,
            'territories' => $territories,
            'regions' => $regions,
        ]);
    }
    public function update($id)
    {
        $distributorModel = new DistributorModel();
        $territoryModel = new TerritoryModel();

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_distributor' => 'required',
            'kode_region' => 'required',
            'nama_owner' => 'required',
            'alamat' => 'required',
        ]);


        // Update distributor
        $distributorData = [
            'kode_distributor' => $id,
            'nama_distributor' => $this->request->getPost('nama_distributor'),
            'kode_region' => $this->request->getPost('kode_region'),
            'nama_owner' => $this->request->getPost('nama_owner'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        // Lakukan update data distributor
        $distributorModel->update($id, $distributorData);

        // Menghapus data territory lama dan insert data territory baru
        $territoryModel->where('kode_distributor', $id)->delete();

        $territories = $this->request->getPost('territory');
        if ($territories) {
            foreach ($territories as $t) {
                $territoryModel->insert([
                    'kode_territory' => $t['kode_territory'],
                    'nama_territory' => $t['nama_territory'],
                    'kode_distributor' => $id,
                ]);
            }
        }

        // Redirect ke halaman distributor dengan pesan sukses
        return redirect()->to('/')->with('success', 'Data distributor berhasil diperbarui!');
    }

    public function delete($id)
    {
        $distributorModel = new DistributorModel();
        $territoryModel = new TerritoryModel();

        // Hapus terlebih dahulu data territory terkait
        $territoryModel->where('kode_distributor', $id)->delete();

        // Hapus data distributor
        $distributorModel->delete($id);

        return redirect()->to('/')->with('success', 'Distributor berhasil dihapus.');
    }

    // AJAX response for datatables
    public function getData()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $builder = $db->table('distributors')
            ->select('distributors.kode_distributor,distributors.nama_distributor, distributors.alamat, regions.nama_region, regions.area')
            ->join('regions', 'regions.kode_region = distributors.kode_region', 'left');

        //  Filter by Region
        $regionFilter = $request->getGet('region_filter');
        if (!empty($regionFilter)) {
            $builder->where('regions.kode_region', $regionFilter);
        }
        

        // 🔍 Search
        $searchArray = $request->getGet('search');
        $searchValue = is_array($searchArray) && isset($searchArray['value']) ? $searchArray['value'] : '';
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('distributors.nama_distributor', $searchValue)
                ->orLike('distributors.alamat', $searchValue)
                ->orLike('regions.nama_region', $searchValue)
                ->groupEnd();
        }
        $searchArray = $request->getGet('search');
        $searchValue = is_array($searchArray) && isset($searchArray['value']) ? $searchArray['value'] : '';
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('distributors.nama_distributor', $searchValue)
                ->orLike('distributors.alamat', $searchValue)
                ->orLike('regions.nama_region', $searchValue)
                ->groupEnd();
        }
        // Order
        $order = $request->getGet('order');
        $columns = ['regions.nama_region', 'distributors.nama_distributor', 'distributors.alamat', 'regions.area'];
        if ($order) {
            $builder->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $builder->orderBy('regions.nama_region', 'asc'); // default
        }

        // Paging
        $start = $request->getGet('start');
        $length = $request->getGet('length');
        $builder->limit($length, $start);

        $data = $builder->get()->getResultArray();

        // Total records
        $total = $db->table('distributors')->countAll();

        // Filtered records
        $filteredTotal = $builder->countAllResults(false); // count without LIMIT

        // Format output
        $result = [];
        foreach ($data as $row) {
            $label = strtolower($row['area']) === 'east' ?
                '<span class="badge bg-primary">East</span>' :
                '<span class="badge bg-success">West</span>';
                $kode = $row['kode_distributor'];
                $baseUrl = base_url();
                
                $aksi = <<<HTML
                    <a class="btn btn-info btn-sm btn-detail" data-kode-distributor="{$kode}" onclick="modelDetail(this)">Detail</a>
                    <a href="{$baseUrl}distributor/edit/{$kode}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{$baseUrl}distributor/delete/{$kode}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                HTML;
            
            $result[] = [
                esc($row['nama_region']),
                esc($row['nama_distributor']),
                esc($row['alamat']),
                $label,
                $aksi,
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $total,
            'recordsFiltered' => count($result),
            'data' => $result,
        ]);
    }

    public function datatable()
    {
        $request = service('request');
        $db = \Config\Database::connect();
        $builder = $db->table('distributors');
        $builder->select('distributors.nama_distributor, distributors.alamat, regions.nama_region, regions.area');
        $builder->join('regions', 'regions.kode_region = distributors.kode_region', 'left');

        // Ordering
        $orderColumnIndex = $request->getGet('order')[0]['column'] ?? 0;
        $orderColumn = ['nama_region', 'nama_distributor', 'alamat', 'area'][$orderColumnIndex] ?? 'nama_region';
        $orderDir = $request->getGet('order')[0]['dir'] ?? 'asc';
        $builder->orderBy($orderColumn, $orderDir);

        // Searching
        $searchArray = $request->getGet('search');
        $searchValue = is_array($searchArray) && isset($searchArray['value']) ? $searchArray['value'] : '';
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('distributors.nama_distributor', $searchValue)
                ->orLike('distributors.alamat', $searchValue)
                ->orLike('regions.nama_region', $searchValue)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false); // keep builder state
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;
        $builder->limit($length, $start);
        $data = $builder->get()->getResultArray();

        $json = [
            'draw' => intval($request->getGet('draw')),
            'recordsTotal' => $builder->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data' => [],
        ];

        foreach ($data as $row) {
            $label = $row['area'] === 'east'
                ? '<span class="badge bg-primary">East</span>'
                : '<span class="badge bg-success">West</span>';

            $json['data'][] = [
                esc($row['nama_region']),
                esc($row['nama_distributor']),
                esc($row['alamat']),
                $label
            ];
        }


        return $this->response->setJSON($json);
    }


    public function DetailDitsributor()
    {
        $kodeDistributor = $this->request->getGet('kode_distributor');
        if (empty($kodeDistributor)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Kode distributor tidak boleh kosong.'
            ]);
        }

        // Ambil data distributor
        $distributor = $this->distributorModel
            ->select('distributors.kode_distributor, distributors.nama_distributor, distributors.alamat, distributors.nama_owner, regions.kode_region, regions.nama_region, regions.area')
            ->join('regions', 'regions.kode_region = distributors.kode_region', 'left')
            ->where('distributors.kode_distributor', $kodeDistributor)
            ->first();

        if (!$distributor) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Distributor tidak ditemukan.'
            ]);
        }

        // Ambil data territories terkait
        $territories = $this->territoryModel
            ->where('kode_distributor', $kodeDistributor)
            ->findAll();

        // Format response
        $response = [
            'status' => 'success',
            'data' => [
                'kode_distributor' => $distributor['kode_distributor'],
                'nama_distributor' => $distributor['nama_distributor'],
                'alamat' => $distributor['alamat'],
                'nama_owner' => $distributor['nama_owner'],
                'kode_region' => $distributor['kode_region'],
                'nama_region' => $distributor['nama_region'],
                'area' => $distributor['area'],
                'territories' => array_map(function ($territory) {
                    return [
                        'kode_territory' => $territory['kode_territory'],
                        'nama_territory' => $territory['nama_territory']
                    ];
                }, $territories)
            ]
        ];

        return $this->response->setJSON($response);
    }


}
