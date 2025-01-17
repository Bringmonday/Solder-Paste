<?php

namespace App\Controllers;


use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class User extends Controller
{
    protected $UserModel;
    
    public function __construct()
    {
        $this->UserModel = new UserModel();
        helper('form');
        
    }

    public function admnwarehouseDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data['total_incoming'] = $userModel->getTotalIncoming();
        $data['sections'] = [
            [
                'title' => 'Conditioning',
                'total' => $userModel->getTotalConditioning(),
                'items' => $userModel->getTotalConditioningWithStatus()
            ],
            [
                'title' => 'Mixing',
                'total' => $userModel->getTotalMixing(),
                'items' => $userModel->getTotalMixingWithStatus()
            ],
            [
                'title' => 'Handover',
                'total' => $userModel->getTotalHandover(),
                'items' => $userModel->getTotalHandoverWithStatus()
            ],
            [
                'title' => 'Open',
                'total' => $userModel->getTotalUsing(),
                'items' => $userModel->getTotalUsingWithStatus()
            ],
            [
                'title' => 'Scrap',
                'total' => $userModel->getTotalScrap(),
                'items' => $userModel->getTotalScrapWithStatus()
            ]
        ];

        $data['solder_paste_data_wrhs'] = $userModel->getSolderPasteData();

        if (!empty($data['solder_paste_data_wrhs'])) {
            foreach ($data['solder_paste_data_wrhs'] as &$row) {
                $row['status_wrhs'] = $this->determineStatus($row);
                }
        } else {
            $data['solder_paste_data_wrhs'] = [];
        }
        $data['pageTitle'] = 'Admin Warehouse Dashboard';

        return view('admnwarehouse/dashboardwrhs', $data);
    }

    public function admnproduksiDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data['total_incoming'] = $userModel->getTotalIncoming();
        $data['sections'] = [
            [
                'title' => 'Conditioning',
                'total' => $userModel->getTotalConditioning(),
                'items' => $userModel->getTotalConditioningWithStatus()
            ],
            [
                'title' => 'Mixing',
                'total' => $userModel->getTotalMixing(),
                'items' => $userModel->getTotalMixingWithStatus()
            ],
            [
                'title' => 'Handover',
                'total' => $userModel->getTotalHandover(),
                'items' => $userModel->getTotalHandoverWithStatus()
            ],
            [
                'title' => 'Open',
                'total' => $userModel->getTotalUsing(),
                'items' => $userModel->getTotalUsingWithStatus()
            ],
            [
                'title' => 'Scrap',
                'total' => $userModel->getTotalScrap(),
                'items' => $userModel->getTotalScrapWithStatus()
            ]
        ];

        $data['solder_paste_data_prod'] = $userModel->getSolderPasteData();

        if (!empty($data['solder_paste_data_prod'])) {
            foreach ($data['solder_paste_data_prod'] as &$row) {
                $row['status_prod'] = $this->determineStatus($row);
                }
        } else {
            $data['solder_paste_data_prod'] = [];
        }
        $data['pageTitle'] = 'Admin Produksi Dashboard';

        return view('admnproduksi/dashboardprod', $data);
    }

    public function admnoffprodDashboard()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $data['total_incoming'] = $userModel->getTotalIncoming();
        $data['sections'] = [
            [
                'title' => 'Conditioning',
                'total' => $userModel->getTotalConditioning(),
                'items' => $userModel->getTotalConditioningWithStatus()
            ],
            [
                'title' => 'Mixing',
                'total' => $userModel->getTotalMixing(),
                'items' => $userModel->getTotalMixingWithStatus()
            ],
            [
                'title' => 'Handover',
                'total' => $userModel->getTotalHandover(),
                'items' => $userModel->getTotalHandoverWithStatus()
            ],
            [
                'title' => 'Open',
                'total' => $userModel->getTotalUsing(),
                'items' => $userModel->getTotalUsingWithStatus()
            ],
            [
                'title' => 'Scrap',
                'total' => $userModel->getTotalScrap(),
                'items' => $userModel->getTotalScrapWithStatus()
            ]
        ];

        $data['solder_paste_data_offprod'] = $userModel->getSolderPasteData();

        if (!empty($data['solder_paste_data_offprod'])) {
        foreach ($data['solder_paste_data_offprod'] as &$row) {
            $row['status_offprod'] = $this->determineStatus($row);
            }
        } else {
            $data['solder_paste_data_offprod'] = [];
        }
        $data['pageTitle'] = 'Admin Office Produksi Dashboard';

        return view('admnoffprod/dashboardoffprod', $data);
    }

    private function determineStatus($row) {
        if (!empty($row['scrap'])) {
            return 'Scrap';
        } elseif (!empty($row['returnsp'])) {
            return 'Return';
        } elseif (!empty($row['openusing'])) {
            return 'Open';
        } elseif (!empty($row['handover'])) {
            return 'Handover';
        } elseif (!empty($row['mixing'])) {
            return 'Mixing';
        } elseif (!empty($row['conditioning'])) {
            return 'Conditioning';
        } elseif (!empty($row['incoming'])) {
            return 'Incoming';
        } else {
            return 'Unknown';
        }
    }
    

    public function warehouse_form()
    {
        $userModel = new UserModel();
        $today_entries_wrhs = $userModel->get_today_solder_paste('ASC');

        $data['pageTitle'] = 'Warehouse Form';
        $data['today_entries_wrhs'] = $today_entries_wrhs;
        

        echo view('admnwarehouse/warehouse_form', $data);
    }

    public function offprod_form()
    {
        $userModel = new UserModel();
        $today_entries_offprod = $userModel->get_today_solder_paste_offprod('ASC');

        $data['pageTitle'] = 'Office Produksi Form';
        $data['today_entries_offprod'] = $today_entries_offprod;
        

        echo view('admnoffprod/offprod_form', $data);
    }

    public function scrap_to_return()
    {
        $userModel = new UserModel();
        $today_entries_scrap = $userModel->get_today_solder_scrap();

        $data['pageTitle'] = 'Scrap Return Form';
        $data['today_entries_scrap'] = $today_entries_scrap;

        echo view('admnwarehouse/scrap_to_return', $data);
    }

    public function scrap_to_return_offprod()
    {
        $userModel = new UserModel();
        $today_entries_scrap = $userModel->get_today_solder_scrap();

        $data['pageTitle'] = 'Scrap Return Form';
        $data['today_entries_scrap'] = $today_entries_scrap;

        echo view('admnoffprod/scrap_to_return_offprod', $data);
    }

    public function processing_form_warehouse()
    {
        $userModel = new UserModel();
        $today_entries_wrhs = $userModel->get_today_solder_paste();

        $data['pageTitle'] = 'Warehouse Form';
        $data['today_entries_wrhs'] = $today_entries_wrhs;

        echo view('admnwarehouse/processing_form_warehouse', $data);
    }

    public function xacti_aji()
    {
        $userModel = new UserModel();
        $today_entries_wrhs = $userModel->get_today_solder_paste_offxacti();

        $data['pageTitle'] = 'Solder Paste External';
        $data['today_entries_wrhs'] = $today_entries_wrhs;

        echo view('admnwarehouse/xacti_aji', $data);
    }

    public function xacti_aji_offprod()
    {
        $userModel = new UserModel();
        $today_entries_wrhs = $userModel->get_today_solder_paste_offxacti();

        $data['pageTitle'] = 'Solder Paste External';
        $data['today_entries_wrhs'] = $today_entries_wrhs;

        echo view('admnoffprod/xacti_aji_offprod', $data);
    }

    public function processing_form_produksi()
    {
        $userModel = new UserModel(); 
        $searchKey = $this->request->getGet('search_key'); 
        
        $today_entries_prod = $userModel->get_today_solder_paste_prod();
        $today_entries_open = $userModel->get_today_solder_paste_open();
        $today_entries_exp = $userModel->get_today_solder_paste_exp('DESC', $searchKey);
        

        $data = [
            'pageTitle' => 'Produksi Form',
            'today_entries_prod' => $today_entries_prod,
            'today_entries_open' => $today_entries_open,
            'today_entries_exp' => $today_entries_exp,
        ];

        return view('admnproduksi/processing_form_produksi', $data);
    }


    public function processing_form_offprod()
    {
        $userModel = new UserModel();
        $today_entries_offprod = $userModel->get_today_solder_paste_offprod();
        $today_entries_offopen = $userModel->get_today_solder_paste_offopen();
        $today_entries_exp = $userModel->get_today_solder_paste_exp();

        $data = [
            'pageTitle' => 'Produksi Form',
            'today_entries_offprod' => $today_entries_offprod,
            'today_entries_offopen' => $today_entries_offopen,
            'today_entries_exp' => $today_entries_exp,
        ];

        return view('admnoffprod/processing_form_offprod', $data);
    }

    public function return_form()
    {
        $userModel = new UserModel();
        $userModel->delete_old_entries();
        $today_entries_rtn = $userModel->get_today_return();

        $data['pageTitle'] = 'Return Form';
        $data['today_entries_rtn'] = $today_entries_rtn;

        echo view('admnwarehouse/return_form', $data);
    }

    public function returnprod_form()
    {
        $userModel = new UserModel();
        $userModel->delete_old_entries();
        $today_entries_rtn = $userModel->get_today_return();

        $data['pageTitle'] = 'Return Form';
        $data['today_entries_rtn'] = $today_entries_rtn;

        echo view('admnproduksi/returnprod_form', $data);
    }

    public function returnoffprod_form()
    {
        $userModel = new UserModel();
        $today_entries_rtn = $userModel->get_today_return();

        $data['pageTitle'] = 'Return Form';
        $data['today_entries_rtn'] = $today_entries_rtn;

        echo view('admnoffprod/returnoffprod_form', $data);
    }

    public function save_temp_data()
    {
        try {
            $requestData = $this->request->getJSON();
            $tempData = $requestData->tempData;

            if (!is_array($tempData)) {
                throw new \Exception('Invalid data format');
            }

            if (empty($tempData)) {
                throw new \Exception('No data to save');
            }

            $userModel = new UserModel();
            $existingData = [];

            foreach ($tempData as $entry) {
                if ($userModel->dataExists($entry->lot_number, $entry->id)) {
                    $existingData[] = [
                        'lot_number' => $entry->lot_number,
                        'id' => $entry->id
                    ];
                    continue;
                }

                date_default_timezone_set('Asia/Jakarta');
                $insertData = [
                    'lot_number' => $entry->lot_number,
                    'id' => $entry->id,
                    'incoming' => date('Y-m-d H:i:s')
                ];
                $userModel->insertData($insertData);
            }

            if (!empty($existingData)) {
                $response = [
                    'message' => 'Some data already exist.',
                    'existingData' => $existingData
                ];
                return $this->response->setStatusCode(400)->setJSON($response);
            }

            $response = ['message' => 'Data saved successfully.'];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $response = ['message' => 'Failed to save data: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }

    public function save_temp_dataoff()
    {
        try {
            $requestData = $this->request->getJSON();
            $tempData = $requestData->tempData;

            if (!is_array($tempData)) {
                throw new \Exception('Invalid data format');
            }

            if (empty($tempData)) {
                throw new \Exception('No data to save');
            }

            $userModel = new UserModel();
            $existingData = [];

            foreach ($tempData as $entry) {
                if ($userModel->dataExists($entry->lot_number, $entry->id)) {
                    $existingData[] = [
                        'lot_number' => $entry->lot_number,
                        'id' => $entry->id
                    ];
                    continue;
                }

                date_default_timezone_set('Asia/Jakarta');
                $insertData = [
                    'lot_number' => $entry->lot_number,
                    'id' => $entry->id,
                    'incoming' => date('Y-m-d H:i:s')
                ];
                $userModel->insertData($insertData);
            }

            if (!empty($existingData)) {
                $response = [
                    'message' => 'Some data already exist.',
                    'existingData' => $existingData
                ];
                return $this->response->setStatusCode(400)->setJSON($response);
            }

            $response = ['message' => 'Data saved successfully.'];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $response = ['message' => 'Failed to save data: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }

    public function check_duplicate()
    {
        try {
            $requestData = $this->request->getJSON();
            $entry = (array) $requestData;

            if (!isset($entry['lot_number']) && !isset($entry['id'])) {
                throw new \Exception('Invalid request');
            }

            $userModel = new UserModel();
            $query = $userModel->where('lot_number', $entry['lot_number'])
                            ->orWhere('id', $entry['id']);

            $isDuplicate = $query->countAllResults() > 0;

            $response = ['isDuplicate' => $isDuplicate];
            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $response = ['message' => 'Failed to check duplicates: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }

    public function save_timewarehouse_lot_number()
    {
        $request = service('request');
        $lot_number = $request->getPost('lot_number');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($lot_number && $column) {
            $userModel = new UserModel();
            $id = $userModel->get_id_from_lot_number($lot_number);

            if ($id !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;

                switch ($column) {
                    case 'conditioning':
                        if (!$userModel->get_incoming_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input data Conditioning.');
                        } elseif ($userModel->get_conditioning_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Conditioning sudah diinput sebelumnya.');
                        }
                        break;
                    case 'mixing':
                        $conditioningTimestamp = $userModel->get_conditioning_timestamp($id);
                        if (!$conditioningTimestamp) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Conditioning terlebih dahulu sebelum input data Mixing.');
                        } elseif ($userModel->get_mixing_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Mixing sudah diinput sebelumnya.');
                        } else {
                            $conditioningTime = strtotime($conditioningTimestamp);
                            $currentTime = strtotime($timestamp);
                            $timeDifferenceInMinutes = $currentTime - $conditioningTime;
                            if ($timeDifferenceInMinutes < 1) { //aktual 120menit = 2 jam
                                $valid = false;
                                session()->setFlashdata('error', 'Tolong tunggu minimal 2 jam setelah Conditioning diinput sebelum input data Mixing.');
                            }
                        }
                        break;
                    case 'handover':
                        if (!$userModel->get_mixing_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Mixing terlebih dahulu sebelum input data Handover.');
                        } elseif ($userModel->get_handover_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Handover sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        $valid = false;
                        session()->setFlashdata('error', 'Kolom tidak valid.');
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingprod($id, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        log_message('error', 'Gagal menyimpan ' . $column . ' untuk id ' . $id);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Lot Number tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnwarehouse/processing_form_warehouse');
    }

    // fungsi controller pendukung untuk fungsi pop up mixing
    // public function save_timewarehouse_search_key()
    // {
    //     $request = service('request');
    //     $search_key = $request->getPost('search_key');
    //     $column = $request->getPost('column');
    //     date_default_timezone_set('Asia/Jakarta');

    //     if ($search_key && $column) {
    //         $userModel = new UserModel();
    //         $search_key = $userModel->get_id_from_search_key($search_key);

    //         if ($search_key !== false) {
    //             $timestamp = date('Y-m-d H:i:s');
    //             $valid = true;
                
    //             switch ($column) {
    //                 case 'conditioning':
    //                     if (!$userModel->get_incoming_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input data Conditioning.');
    //                     } elseif ($userModel->get_conditioning_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Data Conditioning sudah diinput sebelumnya.');
    //                     }
    //                     break;
    //                 case 'mixing':
    //                     if (!$userModel->get_conditioning_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Tolong input data Conditioning terlebih dahulu sebelum input data Mixing.');
    //                     } elseif ($userModel->get_mixing_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Data Mixing sudah diinput sebelumnya.');
    //                     }
    //                     break;
    //                 case 'handover':
    //                     if (!$userModel->get_mixing_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Tolong input data Mixing terlebih dahulu sebelum input data Handover.');
    //                     } elseif ($userModel->get_handover_timestamp($search_key)) {
    //                         $valid = false;
    //                         session()->setFlashdata('error', 'Data Handover sudah diinput sebelumnya.');
    //                     }
    //                     break;
    //                 default:
    //                     break;
    //             }

    //             if ($valid) {
    //                 $data = [$column => $timestamp];
    //                 if ($userModel->update_processingsearch($search_key, $data)) {
    //                     session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
    //                 } else {
    //                     session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
    //                     logger('Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
    //                 }
    //             }
    //         } else {
    //             session()->setFlashdata('error', 'Search Key tidak ditemukan.');
    //         }
    //     } else {
    //         session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
    //     }

    //     return redirect()->to('admnwarehouse/processing_form_warehouse');
    // }

    public function save_timewarehouse_search_key()
    {
        $request = service('request');
        $search_key = $request->getPost('search_key');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($search_key && $column) {
            $userModel = new UserModel();
            $search_key = $userModel->get_id_from_search_key($search_key);

            if ($search_key !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;
                
                switch ($column) {
                    case 'conditioning':
                        if (!$userModel->get_incoming_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input data Conditioning.');
                        } elseif ($userModel->get_conditioning_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Conditioning sudah diinput sebelumnya.');
                        }
                        break;
                    case 'mixing':
                        $conditioningTimestamp = $userModel->get_conditioning_timestamp($search_key);
                        if (!$conditioningTimestamp) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Conditioning terlebih dahulu sebelum input data Mixing.');
                        } elseif ($userModel->get_mixing_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Mixing sudah diinput sebelumnya.');
                        } else {
                            $conditioningTime = strtotime($conditioningTimestamp);
                            $currentTime = time();
                            $diffInMinutes = ($currentTime - $conditioningTime) / 60;
    
                            if ($diffInMinutes <= 120) {
                                $valid = false;
                                session()->setFlashdata('error', 'Waktu Conditioning belum melewati batas minimum 2 jam. Proses Mixing tidak dapat dilanjutkan.');
                            }
                        }
                        break;
                    case 'handover':
                        if (!$userModel->get_mixing_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Mixing terlebih dahulu sebelum input data Handover.');
                        } elseif ($userModel->get_handover_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Handover sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingsearch($search_key, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        logger('Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Search Key tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnwarehouse/processing_form_warehouse');
    }

    public function save_timewarehouse_external()
    {
        $request = service('request');
        $search_key = $request->getPost('search_key');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($search_key && $column) {
            $userModel = new UserModel();
            $search_key = $userModel->get_id_from_search_key($search_key);

            if ($search_key !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;
                
                switch ($column) {  
                    case 'scrap':
                        if (!$userModel->get_incoming_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input Solder Paste To External.');
                        } elseif ($userModel->get_scrap_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingsearch($search_key, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        logger('Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Search Key tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnwarehouse/xacti_aji');
    }

    public function save_timeproduksi_lot_number()
    {
        $request = service('request');
        $lot_number = $request->getPost('lot_number');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($lot_number && $column) {
            $userModel = new UserModel();
            $id = $userModel->get_id_from_lot_number($lot_number);

            if ($id !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;

                switch ($column) {
                    case 'openusing':
                        if (!$userModel->get_handover_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Handover terlebih dahulu sebelum input data Using.');
                        } elseif ($userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Using sudah diinput sebelumnya.');
                        }
                        break;
                    case 'returnsp':
                        if ($userModel->get_return_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya.');
                        } else {
                            $existing_data = $userModel->get_solder_paste_by_lot_number($lot_number);

                            if ($existing_data) {
                                $userModel->update_lot_number($existing_data['id'], $lot_number, $timestamp);
                                $userModel->insert_new_solder_paste_row($lot_number, $existing_data, $timestamp);
                            }
                        }
                        break;
                    case 'scrap':
                        if (!$userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Scrap.');
                        } elseif ($userModel->get_scrap_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingprod($id, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        log_message('error', 'Gagal menyimpan ' . $column . ' untuk id ' . $id);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Lot Number tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnproduksi/processing_form_produksi');
    }

    public function save_timeproduksi_search_key()
    {
        $request = service('request');
        $search_key = $request->getPost('search_key');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($search_key && $column) {
            $userModel = new UserModel();
            $existing_data = $userModel->get_solder_paste_by_search_key($search_key);

            if ($existing_data) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;

                switch ($column) {
                    case 'openusing':
                        if (!$userModel->get_handover_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Handover terlebih dahulu sebelum input data Using.');
                        } elseif ($userModel->get_using_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Using sudah diinput sebelumnya.');
                        }
                        break;
                    case 'returnsp':
                        $openusing_timestamp = $userModel->get_using_timestamp($search_key);
        
                        if (!$openusing_timestamp) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Open terlebih dahulu sebelum input data Return.');
                        } elseif ($userModel->get_return_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya.');
                        } else {
                            $openusing_time = new \DateTime($openusing_timestamp);
                            $current_time = new \DateTime($timestamp);
                            $interval = $current_time->diff($openusing_time);

                            $total_minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                            if ($total_minutes >= 480) { // aktual waktu 8 jam = 480 menit
                            $valid = false;
                            session()->setFlashdata('error', 'Waktu input data Return sudah lewat dari batas waktu 8 jam.');
        
                            } else {
                                $lot_number = $existing_data['lot_number'];
                                $userModel->update_lot_number($existing_data['id'], $lot_number, $timestamp);
                                $userModel->insert_new_solder_paste_row($lot_number, $existing_data, $timestamp);
                            }
                        }
                        break;
                    case 'scrap':
                        if (!$userModel->get_using_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Scrap.');
                        } elseif ($userModel->get_scrap_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingsearch($search_key, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        log_message('error', 'Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Search Key tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnproduksi/processing_form_produksi');
    }

    public function save_timeproduksi_old()
    {
        $request = service('request');
        $lot_number = $request->getPost('lot_number');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($lot_number && $column) {
            $userModel = new UserModel();
            $id = $userModel->get_id_from_lot_number($lot_number);

            if ($id !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;

                switch ($column) {
                    case 'openusing':
                        if (!$userModel->get_handover_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Handover terlebih dahulu sebelum input data Using.');
                        } elseif ($userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Using sudah diinput sebelumnya.');
                        }
                        break;
                    case 'returnsp':
                        if (!$userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Return.');
                        } elseif ($userModel->get_return_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya.');
                        } elseif ($userModel->get_scrap_timestamp($id)) { 
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya, tidak bisa input Return.');
                        }
                        break;
                    case 'scrap':
                        if (!$userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Scrap.');
                        } elseif ($userModel->get_scrap_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        } elseif ($userModel->get_return_timestamp($id)) { 
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya, tidak bisa input Scrap.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingprod($id, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        log_message('error', 'Gagal menyimpan ' . $column . ' untuk id ' . $id);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Lot Number tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnproduksi/processing_form_produksi');
    }

    public function save_timeoffprod_lot_number()
    {
        $request = service('request');
        $lot_number = $request->getPost('lot_number');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($lot_number && $column) {
            $userModel = new UserModel();
            $id = $userModel->get_id_from_lot_number($lot_number);

            if ($id !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;

                switch ($column) {
                    case 'conditioning':
                        if (!$userModel->get_incoming_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input data Conditioning.');
                        } elseif ($userModel->get_conditioning_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Conditioning sudah diinput sebelumnya.');
                        }
                        break;
                    case 'mixing':
                        $conditioningTimestamp = $userModel->get_conditioning_timestamp($id);
                        if (!$conditioningTimestamp) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Conditioning terlebih dahulu sebelum input data Mixing.');
                        } elseif ($userModel->get_mixing_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Mixing sudah diinput sebelumnya.');
                        } else {
                            $conditioningTime = strtotime($conditioningTimestamp);
                            $currentTime = strtotime($timestamp);
                            $timeDifferenceInMinutes = $currentTime - $conditioningTime;
                            if ($timeDifferenceInMinutes < 1) { //aktual 120menit = 2 jam
                                $valid = false;
                                session()->setFlashdata('error', 'Tolong tunggu minimal 2 jam setelah Conditioning diinput sebelum input data Mixing.');
                            }
                        }
                        break;
                    case 'handover':
                        if (!$userModel->get_mixing_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Mixing terlebih dahulu sebelum input data Handover.');
                        } elseif ($userModel->get_handover_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Handover sudah diinput sebelumnya.');
                        }
                        break;
                    case 'openusing':
                        if (!$userModel->get_handover_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Handover terlebih dahulu sebelum input data Using.');
                        } elseif ($userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Using sudah diinput sebelumnya.');
                        }
                        break;
                    case 'returnsp':
                        if ($userModel->get_return_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya.');
                        } else {
                            $existing_data = $userModel->get_solder_paste_by_lot_number($lot_number);

                            if ($existing_data) {
                                $userModel->update_lot_number($existing_data['id'], $lot_number, $timestamp);
                                $userModel->insert_new_solder_paste_row($lot_number, $existing_data, $timestamp);
                            }
                        }
                        break;
                    case 'scrap':
                        if (!$userModel->get_using_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Scrap.');
                        } elseif ($userModel->get_scrap_timestamp($id)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingprod($id, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        log_message('error', 'Gagal menyimpan ' . $column . ' untuk id ' . $id);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Lot Number tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnoffprod/processing_form_offprod');
    }

    public function save_timeoffprod_search_key()
    {
    $request = service('request');
    $search_key = $request->getPost('search_key');
    $column = $request->getPost('column');
    date_default_timezone_set('Asia/Jakarta');

    if ($search_key && $column) {
        $userModel = new UserModel();
        $existing_data = $userModel->get_solder_paste_by_search_key($search_key);

        if ($existing_data) {
            $timestamp = date('Y-m-d H:i:s');
            $valid = true;

            switch ($column) {
                case 'conditioning':
                        if (!$userModel->get_incoming_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input data Conditioning.');
                        } elseif ($userModel->get_conditioning_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Conditioning sudah diinput sebelumnya.');
                        }
                        break;
                    case 'mixing':
                        if (!$userModel->get_conditioning_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Conditioning terlebih dahulu sebelum input data Mixing.');
                        } elseif ($userModel->get_mixing_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Mixing sudah diinput sebelumnya.');
                        }
                        break;
                    case 'handover':
                        if (!$userModel->get_mixing_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Mixing terlebih dahulu sebelum input data Handover.');
                        } elseif ($userModel->get_handover_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Handover sudah diinput sebelumnya.');
                        }
                        break;
                    case 'openusing':
                        if (!$userModel->get_handover_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Handover terlebih dahulu sebelum input data Using.');
                        } elseif ($userModel->get_using_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Using sudah diinput sebelumnya.');
                        }
                        break;
                    case 'returnsp':
                        $openusing_timestamp = $userModel->get_using_timestamp($search_key);
        
                        if (!$openusing_timestamp) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Open terlebih dahulu sebelum input data Return.');
                        } elseif ($userModel->get_return_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Return sudah diinput sebelumnya.');
                        } else {
                            $openusing_time = new \DateTime($openusing_timestamp);
                            $current_time = new \DateTime($timestamp);
                            $interval = $current_time->diff($openusing_time);

                            $total_minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                            if ($total_minutes >= 480) { // aktual waktu 8 jam = 480 menit
                            $valid = false;
                            session()->setFlashdata('error', 'Waktu input data Return sudah lewat dari batas waktu 8 jam.');
        
                            } else {
                                $lot_number = $existing_data['lot_number'];
                                $userModel->update_lot_number($existing_data['id'], $lot_number, $timestamp);
                                $userModel->insert_new_solder_paste_row($lot_number, $existing_data, $timestamp);
                            }
                        }
                        break;
                    case 'scrap':
                        if (!$userModel->get_using_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Using terlebih dahulu sebelum input data Scrap.');
                        } elseif ($userModel->get_scrap_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                default:
                    break;
            }

            if ($valid) {
                $data = [$column => $timestamp];
                if ($userModel->update_processingsearch($search_key, $data)) {
                    session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                } else {
                    session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                    log_message('error', 'Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
                }
            }
        } else {
            session()->setFlashdata('error', 'Search Key tidak ditemukan.');
        }
    } else {
        session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
    }

    return redirect()->to('admnoffprod/processing_form_offprod');
    }

    public function save_timeoffprod_external()
    {
        $request = service('request');
        $search_key = $request->getPost('search_key');
        $column = $request->getPost('column');
        date_default_timezone_set('Asia/Jakarta');

        if ($search_key && $column) {
            $userModel = new UserModel();
            $search_key = $userModel->get_id_from_search_key($search_key);

            if ($search_key !== false) {
                $timestamp = date('Y-m-d H:i:s');
                $valid = true;
                
                switch ($column) {  
                    case 'scrap':
                        if (!$userModel->get_incoming_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Tolong input data Incoming terlebih dahulu sebelum input Solder Paste To External.');
                        } elseif ($userModel->get_scrap_timestamp($search_key)) {
                            $valid = false;
                            session()->setFlashdata('error', 'Data Scrap sudah diinput sebelumnya.');
                        }
                        break;
                    default:
                        break;
                }

                if ($valid) {
                    $data = [$column => $timestamp];
                    if ($userModel->update_processingsearch($search_key, $data)) {
                        session()->setFlashdata('success', ucfirst($column) . ' berhasil untuk disimpan.');
                    } else {
                        session()->setFlashdata('error', 'Gagal menyimpan ' . $column . '.');
                        logger('Gagal menyimpan ' . $column . ' untuk search_key ' . $search_key);
                    }
                }
            } else {
                session()->setFlashdata('error', 'Search Key tidak ditemukan.');
            }
        } else {
            session()->setFlashdata('error', 'Harap isi semua field yang diperlukan.');
        }

        return redirect()->to('admnoffprod/xacti_aji_offprod');
    }

    public function save_timewarehouse_scrap_to_return()
    {
        $lot_number = $this->request->getPost('lot_number');
        $id = $this->request->getPost('id');

        if (empty($lot_number) || empty($id)) {
            return redirect()->back()->with('error', 'Lot number dan ID tidak bisa kosong.');
        }

        $UserModel = $this->UserModel;
    
        $existingEntry = $UserModel->where('lot_number', $lot_number)->where('id', $id)->first();

        if (!$existingEntry) {
            return redirect()->back()->with('error', 'Kombinasi Lot number dan ID tidak ditemukan.');
        }

        if (empty($existingEntry['scrap'])) {
            return redirect()->back()->with('error', 'Data kolom scrap belum diinput');
        }

        $timestamp = date('Y-m-d H:i:s');
        $UserModel->update_lot_number_scrap($existingEntry['id'], $existingEntry['lot_number'], $timestamp);
        $UserModel->insert_new_solder_paste_row_scrap($existingEntry['lot_number'], $existingEntry, $timestamp);

        return redirect()->back()->with('success', 'Solder paste scrap berhasil di return.');
    }

    public function save_timeoffprod_scrap_to_return()
    {
        $lot_number = $this->request->getPost('lot_number');
        $id = $this->request->getPost('id');

        if (empty($lot_number) || empty($id)) {
            return redirect()->back()->with('error', 'Lot number dan ID tidak bisa kosong.');
        }

        $UserModel = $this->UserModel;
    
        $existingEntry = $UserModel->where('lot_number', $lot_number)->where('id', $id)->first();

        if (!$existingEntry) {
            return redirect()->back()->with('error', 'Kombinasi Lot number dan ID tidak ditemukan.');
        }

        if (empty($existingEntry['scrap'])) {
            return redirect()->back()->with('error', 'Data kolom scrap belum diinput');
        }

        $timestamp = date('Y-m-d H:i:s');
        $UserModel->update_lot_number_scrap($existingEntry['id'], $existingEntry['lot_number'], $timestamp);
        $UserModel->insert_new_solder_paste_row_scrap($existingEntry['lot_number'], $existingEntry, $timestamp);

        return redirect()->back()->with('success', 'Solder paste scrap berhasil di return.');
    }


    public function check_timestamps()
    {
        $request = $this->request;
        $search_key = $request->getPost('search_key');
        $userModel = new UserModel();

        $response = [
            'conditioning' => !!$userModel->get_conditioning_timestamp($search_key),
            'mixing' => !!$userModel->get_mixing_timestamp($search_key),
            'handover' => !!$userModel->get_handover_timestamp($search_key)
        ];

        return $this->response->setJSON($response);
    }

    public function checkPendingNotifications()
    {
        date_default_timezone_set('Asia/Jakarta');
        $userModel = new UserModel();
        $notifications = $userModel->getPendingNotifications();
        return $this->response->setJSON($notifications);
    }

    public function checkOverdueNotifications()
    {
        date_default_timezone_set('Asia/Jakarta');
        $userModel = new UserModel();
        $notifications = $userModel->getOverdueNotifications();
        return $this->response->setJSON($notifications);
    }

    public function checkConditioningNotifications()
    {
        date_default_timezone_set('Asia/Jakarta');
        $userModel = new UserModel();
        $notifications = $userModel->getConditioningNotifications();
        return $this->response->setJSON($notifications);
    }

    public function search_keys_lot_number()
    {
        $userModel = new UserModel();
        $q = $this->request->getGet('q');
        $data = $userModel->get_search_lot_number($q);

        return $this->response->setJSON($data);
    }

    public function update_lot_number($id)
    {
        $userModel = new UserModel();
        $lot_number = $this->request->getPost('lot_number');
        $id = $this->request->getPost('id');
        date_default_timezone_set('Asia/Jakarta');

        $existing_data = $userModel->get_solder_paste_by_lot_number($lot_number);

        if ($existing_data) {
            $userModel->update_lot_number($existing_data['id'], $lot_number);
            $userModel->insert_new_solder_paste_row($existing_data);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Lot Number updated successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Lot Number not found.']);
        }     
    }

    public function display_return_data()
    {
        $userModel = new UserModel();
        $data['today_entries_rtn'] = $userModel->get_today_return();

        return view('return_table', $data);
    }

    public function getNotifications()
    {
        $model = new UserModel(); 
        $oneMinuteAgo = date('Y-m-d H:i:s', strtotime('-1 minutes'));

        $notifications = $model ->where('CONVERT(date, conditioning)', date('Y-m-d')) 
                                ->where('mixing IS NULL')
                                ->where('handover IS NULL')
                                ->where('openusing IS NULL')
                                ->where('returnsp IS NULL')
                                ->where('scrap IS NULL')
                                ->where('conditioning <=', $oneMinuteAgo)
                                ->findAll();

        return $this->response->setJSON($notifications);
    }


    public function getNotificationsProd()
    {
        $model = new UserModel(); 
        $oneMinuteAgo = date('Y-m-d H:i:s', strtotime('-1 minutes'));

        $notifications = $model ->where('CONVERT(date, openusing)', date('Y-m-d')) 
                                ->where('returnsp IS NULL')
                                ->where('scrap IS NULL')
                                ->where('openusing <=', $oneMinuteAgo)
                                ->findAll();

        return $this->response->setJSON($notifications);
    }

    public function getNotificationsOffProd()
    {
        $model = new UserModel();
        $oneMinuteAgo = date('Y-m-d H:i:s', strtotime('-1 minute'));
        
        $notifications = $model->groupStart()
                               ->where('CONVERT(date, conditioning)', date('Y-m-d')) 
                               ->where('mixing IS NULL')
                               ->where('handover IS NULL')
                               ->where('openusing IS NULL')
                               ->where('conditioning <=', $oneMinuteAgo)
                               ->groupEnd()
                               ->orGroupStart()
                               ->where('CONVERT(date, openusing)', date('Y-m-d')) 
                               ->where('returnsp IS NULL')
                               ->where('scrap IS NULL')
                               ->where('openusing <=', $oneMinuteAgo)
                               ->groupEnd()
                               ->findAll();
        
        return $this->response->setJSON($notifications);
    }

    public function received()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $lot_number = $request->getPost('lot_number');
        
        if ($id && $lot_number) {
            $userModel = new UserModel();
            $timestamp = date('Y-m-d H:i:s');
            
            if ($userModel->update_incoming($id, $timestamp)) {
                session()->setFlashdata('success', 'Solder Paste Return Diterima.');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui data Incoming.');
            }
        } else {    
            session()->setFlashdata('error', 'Data tidak lengkap.');
        }
        
        return redirect()->to('admnwarehouse/return_form');
    }

    public function received_prod()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $lot_number = $request->getPost('lot_number');
        
        if ($id && $lot_number) {
            $userModel = new UserModel();
            $timestamp = date('Y-m-d H:i:s');
            
            if ($userModel->update_incoming_prod($id, $timestamp)) {
                session()->setFlashdata('success', 'Solder Paste Return Diterima.');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui data Incoming.');
            }
        } else {    
            session()->setFlashdata('error', 'Data tidak lengkap.');
        }
        
        return redirect()->to('admnoffprod/returnprod_form');
    }

    public function receivedoffprod()
    {
        $request = service('request');
        $id = $request->getPost('id');
        $lot_number = $request->getPost('lot_number');
        
        if ($id && $lot_number) {
            $userModel = new UserModel();
            $timestamp = date('Y-m-d H:i:s');
            
            if ($userModel->update_incoming($id, $timestamp)) {
                session()->setFlashdata('success', 'Solder Paste Return Diterima.');
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui data Incoming.');
            }
        } else {    
            session()->setFlashdata('error', 'Data tidak lengkap.');
        }
        
        return redirect()->to('admnoffprod/returnoffprod_form');
    }


    public function export_to_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Lot Number');

        $userModel = new UserModel();
        $data = $userModel->get_today_return();

        $row = 2;
        foreach ($data as $entry) {
            $sheet->setCellValue('A' . $row, $entry['id']);
            $sheet->setCellValue('B' . $row, $entry['lot_number']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        $filePath = WRITEPATH . 'exports/Return_Data_' . date('Ymd_His') . '.xlsx';
        
        if (!is_dir(WRITEPATH . 'exports')) {
            mkdir(WRITEPATH . 'exports', 0777, true);
        }

        try {
            $writer->save($filePath);
            return $this->response->download($filePath, null)->setFileName('Return_Data_' . date('Ymd_His') . '.xlsx');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function search_key()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function search_key_ext()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_ext($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function search_key_scrprtn()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_scrprtn($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }
    public function search_key_incoming()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_inc($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function search_key_prod()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_prod($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function search_key_offprod()
    {
        $request = service('request');
        $searchTerm = $request->getGet('term');

        if ($searchTerm) {
            $userModel = new UserModel();
            $results = $userModel->search_key_offprod($searchTerm);

            return $this->response->setJSON($results);
        }

        return $this->response->setJSON([]);
    }

    public function get_last_timestamp()
    {
        $request = $this->request;
        $search_key = $request->getPost('search_key');
        $userModel = new UserModel();
    
        $conditioningTimestamp = $userModel->get_conditioning_timestamp($search_key);
        $mixingValue = $userModel->get_mixing_value($search_key);
    
        if ($conditioningTimestamp !== false) {
            return $this->response->setJSON([
                'timestamp' => $conditioningTimestamp,
                'mixing' => $mixingValue 
            ]);
        } else {
            return $this->response->setJSON([
                'timestamp' => null,
                'mixing' => null 
            ]);
        }
    }

    public function check_data_exists()
    {
        try {
            $requestData = $this->request->getJSON();
            $lot_number = $requestData->lot_number;
            $id = $requestData->id;

            if (!$lot_number || !$id) {
                return $this->response->setStatusCode(400)->setJSON(['message' => 'Lot Number dan ID diperlukan']);
            }

            $userModel = new UserModel();
            $exists = $userModel->dataExists($lot_number, $id);

            return $this->response->setJSON(['exists' => $exists]);

        } catch (\Exception $e) {
            $response = ['message' => 'Gagal memeriksa data: ' . $e->getMessage()];
            return $this->response->setStatusCode(500)->setJSON($response);
        }
    }

    public function fetch_updated_solder_paste_exp()
    {
        $userModel = new UserModel(); 
        $today_entries_exp = $userModel->get_today_solder_paste_exp();

        return $this->response->setJSON($today_entries_exp);
    }



}
