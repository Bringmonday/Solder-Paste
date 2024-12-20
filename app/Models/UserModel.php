<?php 

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;

class UserModel extends Model
{
    protected $table = 'solder_paste_test';
    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = ['id', 'search_key', 'lot_number', 'incoming','conditioning', 'mixing', 'handover', 'openusing','returnsp', 'scrap'];

    public function getTotalIncoming()
    {
        return $this->where('incoming IS NOT NULL')
                    ->where('conditioning IS NULL')
                    ->countAllResults();
    }

    public function getTotalConditioning()
    {
        return $this->where('conditioning IS NOT NULL')
                    ->where('mixing IS NULL')
                    ->countAllResults();
    }

    public function getTotalMixing()
    {
        return $this->where('mixing IS NOT NULL')
                    ->where('handover IS NULL')
                    ->countAllResults();
    }

    public function getTotalHandover()
    {
        return $this->where('handover IS NOT NULL')
                    ->where('openusing IS NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->countAllResults();
    }

    public function getTotalUsing()
    {
        return $this->where('openusing IS NOT NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->countAllResults();
    }

    public function getTotalReturn()
    {
        return $this->where('returnsp IS NOT NULL')
                    ->countAllResults();
    }

    public function getTotalScrap()
    {
        return $this->where('scrap IS NOT NULL')
                    ->countAllResults();
    }

    public function getTotalConditioningWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('conditioning IS NOT NULL')
                    ->where('mixing IS NULL')
                    ->where('handover IS NULL')
                    ->where('openusing IS NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll(); 
    }

    public function getTotalMixingWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('mixing IS NOT NULL')
                    ->where('handover IS NULL')
                    ->where('openusing IS NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll(); 
    }

    public function getTotalHandoverWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('handover IS NOT NULL')
                    ->where('openusing IS NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll(); 
    }

    public function getTotalUsingWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('openusing IS NOT NULL')
                    ->where('returnsp IS NULL')
                    ->where('scrap IS NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll(); 
    }

    public function getTotalReturnWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('returnsp IS NOT NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll(); 
    }

    public function getTotalScrapWithStatus()
    {
        return $this->select('lot_number, id, COUNT(*) as total')
                    ->where('scrap IS NOT NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->groupBy('lot_number, id')
                    ->findAll();
    }

    public function getSolderPasteData()
    {
        return $this->where('lot_number NOT LIKE', 'RE%')
                    ->findAll();
    }

    public function insertData($data)
    {
        $data['search_key'] = $data['lot_number'] . $data['id'];  
        $this->db->table('solder_paste_test')->insert($data); 
    }

    public function updateSearchKey($lot_number, $id)
    {
        $search_key = $lot_number . $id;
        $this->set('search_key', $search_key)
            ->where('lot_number', $lot_number)
            ->where('id', $id)
            ->update();
    }
    
    public function searchKeyExists($search_key)
    {
        return $this->where('search_key', $search_key)
                    ->countAllResults() > 0;
    }

    public function update_processingprod($id, $data)
    {
        return $this->update($id, $data);
    }

    public function update_processingsearch($search_key, $data)
    {
        return $this->where('search_key', $search_key)->set($data)->update();
    }

    public function get_id_from_lot_number($lot_number)
    {
        $query = $this->select('id')
                      ->where('lot_number', $lot_number)
                      ->first();
        return ($query) ? $query['id'] : false;
    }

    public function get_id_from_search_key($search_key)
    {
        $query = $this->select('search_key')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['search_key'] : false;
    }

    public function get_incoming_timestamp($search_key)
    {
        $query = $this->select('incoming')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['incoming'] : false;
    }

    public function get_conditioning_timestamp($search_key)
    {
        $query = $this->select('conditioning')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['conditioning'] : false;
    }

    public function get_mixing_timestamp($search_key)
    {
        $query = $this->select('mixing')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['mixing'] : false;
    }

    public function get_handover_timestamp($search_key)
    {
        $query = $this->select('handover')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['handover'] : false;
    }

    public function get_using_timestamp($search_key)
    {
        $query = $this->select('openusing')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['openusing'] : false;
    }

    public function get_return_timestamp($search_key)
    {
        $query = $this->select('returnsp')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['returnsp'] : false;
    }

    public function get_scrap_timestamp($search_key)
    {
        $query = $this->select('scrap')
                      ->where('search_key', $search_key)
                      ->first();
        return ($query) ? $query['scrap'] : false;
    }

    public function get_today_entries_wrhs()
    {
        $today = date('Y-m-d');
        return $this->where('CAST(incoming AS DATE)', $today)->findAll();
    }

    public function getTodayEntriesRtn()
    {
        $builder = $this->table($this->table);
        $builder->where('CAST(returnsp AS DATE)', date('Y-m-d'));
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function get_today_solder_paste($order = 'DESC')
    {
        $db = Database::connect();
        $builder = $db->table($this->table);

        $timezone = 'Asia/Jakarta';
        $datetime = new \DateTime('now', new \DateTimeZone($timezone));

        $today_start = $datetime->format('Y-m-d 00:00:00');
        $today_end = $datetime->format('Y-m-d 23:59:59');

        $builder->where('incoming >=', $today_start)
                ->where('incoming <=', $today_end)
                ->orWhere('conditioning >=', $today_start)
                ->where('conditioning <=', $today_end)
                ->orWhere('mixing >=', $today_start)
                ->where('mixing <=', $today_end)
                ->orWhere('handover >=', $today_start)
                ->where('handover <=', $today_end)
                ->orderBy('incoming', $order);

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function get_today_solder_scrap($order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->groupStart()
                            ->where('returnsp >=', $today_start)
                            ->where('returnsp <=', $today_end)
                        ->groupEnd()
                        ->orWhere('lot_number LIKE', 'OLD%')
                        ->orderBy('returnsp', $order)
                        ->get();

        return $query->getResultArray();
    }


    public function get_today_solder_paste_prod($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->orWhere('returnsp >=', $today_start)
                        ->where('returnsp <=', $today_end) 
                        ->orWhere('scrap >=', $today_start)
                        ->where('scrap <=', $today_end)
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_open_old( $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');

        $query = $this->db->table('solder_paste_test')
                        ->where('openusing IS NOT NULL') 
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->get();

        return $query->getResultArray();
    }

    public function get_recent_solder_paste_open($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        
        // Reset tabel dalam 7 hari
        $seven_days_ago = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->where('openusing >=', $seven_days_ago)
                        ->where('openusing <=', $today_end)
                        ->where('openusing IS NOT NULL')
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_open($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('openusing IS NOT NULL') 
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_solder_paste_offprod($order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->groupStart()
                            ->where('incoming >=', $today_start)
                            ->where('incoming <=', $today_end)
                            ->orWhere('returnsp >=', $today_start)
                            ->where('returnsp <=', $today_end)
                            ->orWhere('conditioning >=', $today_start)
                            ->where('conditioning <=', $today_end)
                            ->orWhere('mixing >=', $today_start)
                            ->where('mixing <=', $today_end)
                            ->orWhere('handover >=', $today_start)
                            ->where('handover <=', $today_end)
                            ->orWhere('openusing >=', $today_start)
                            ->where('openusing <=', $today_end) 
                            ->orWhere('scrap >=', $today_start)
                            ->where('scrap <=', $today_end)
                        ->groupEnd()
                        ->where('lot_number NOT LIKE', 'OLD%') 
                        ->orderBy('incoming', $order)
                        ->get();

        return $query->getResultArray();
    }
    public function get_today_solder_paste_offxacti($order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->groupStart()
                            ->where('incoming >=', $today_start)
                            ->where('incoming <=', $today_end)
                            ->where('conditioning IS NULL') 
                            ->orWhere('scrap >=', $today_start)
                            ->where('scrap <=', $today_end)
                        ->groupEnd()
                        ->where('lot_number NOT LIKE', 'OLD%') 
                        ->orderBy('incoming', $order)
                        ->get();

        return $query->getResultArray();
    }


    public function get_today_solder_paste_offopen($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');

        $query = $this->db->table('solder_paste_test')
                        ->where('openusing >=', $today_start)
                        ->where('openusing <=', $today_end)
                        ->where('openusing IS NOT NULL') 
                        ->where('returnsp IS NULL')
                        ->where('scrap IS NULL')
                        ->orderBy('openusing', $order)
                        ->limit($limit)
                        ->get();

        return $query->getResultArray();
    }

    public function get_today_return_old($limit = 5)
    {
        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->limit($limit)
                    ->findAll();
    }
    
    public function get_today_return($limit = 5)
    {
        $startOfDay = date('Y-m-d') . ' 07:00:00';
        $endOfDay = date('Y-m-d') . ' 19:00:00';

        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number LIKE', 'OLD%')
                    ->where('returnsp >=', $startOfDay)
                    ->where('returnsp <=', $endOfDay)
                    ->where('DATEDIFF(day, returnsp, GETDATE()) <=', 1) 
                    ->orderBy('returnsp', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function get_all_returns()
    {
        return $this->where('returnsp IS NOT NULL')
                    ->where('lot_number LIKE', 'OLD%')
                    ->findAll();
    }

    public function delete_old_entries()
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $oneDayAgo = date('Y-m-d H:i:s', strtotime('-1 day'));
        $startOfDay = date('Y-m-d') . ' 07:00:00';
        $endOfDay = date('Y-m-d') . ' 19:00:00';

        $this->where('returnsp IS NOT NULL')
            ->where('returnsp <', $oneDayAgo) 
            ->orWhere('returnsp <', $startOfDay)
            ->orWhere('returnsp >', $endOfDay) 
            ->delete();
    }

    public function getPendingNotifications()
    {
    
        $currentDate = date('Y-m-d');

        $query = $this->db->query("
            SELECT id, lot_number, search_key, conditioning
            FROM {$this->table}
            WHERE conditioning IS NOT NULL
            AND CAST(conditioning AS DATE) = '$currentDate'  -- Membatasi hanya pada tanggal saat ini
            AND CONVERT(TIME, conditioning) BETWEEN '07:00:00' AND '19:00:00'
            AND DATEDIFF(MINUTE, conditioning, GETDATE()) >= 2 -- Aktual 120 menit = 2 jam
            AND mixing IS NULL
            AND handover IS NULL
            AND lot_number NOT LIKE 'RE%'
            ORDER BY conditioning DESC
        ");

        return $query->getResultArray();
    }

    public function getOverdueNotifications()
    {
        $currentDate = date('Y-m-d'); 

        $query = $this->db->query("
            SELECT id, lot_number, search_key, openusing
            FROM {$this->table}
            WHERE openusing IS NOT NULL
            AND CAST(openusing AS DATE) = '$currentDate'  -- Membatasi hanya pada tanggal saat ini
            AND CONVERT(TIME, openusing) BETWEEN '07:00:00' AND '19:00:00'
            AND DATEDIFF(MINUTE, openusing, GETDATE()) >= 2 -- aktual 480 menit = 8 jam
            AND returnsp IS NULL
            AND scrap IS NULL
            AND lot_number NOT LIKE 'RE%'
            ORDER BY openusing DESC
        "); 

        return $query->getResultArray();
    }

    
    public function getConditioningNotifications()
    {
        $currentDate = date('Y-m-d H:i:s');

        $query = $this->db->query("
            SELECT id, conditioning
            FROM {$this->table}
            WHERE conditioning IS NOT NULL
            AND DATEDIFF('$currentDate', conditioning) = 0
            AND TIME(conditioning) BETWEEN '07:00:00' AND '19:00:00'
            AND TIMESTAMPDIFF(MINUTE, conditioning, NOW()) >= 1
        ");

        return $query->getResultArray();
    }


    public function get_search_lot_number($keyword = '')
    {
        return $this->like('lot_number', $keyword)
                    ->where('lot_number NOT LIKE', 'RE%')
                    ->where('returnsp IS NOT NULL')
                    ->findAll();
    }

    public function get_solder_paste_by_lot_number($lot_number)
    {
        return $this->where('lot_number', $lot_number)->first();
    }

    public function get_solder_paste_by_search_key($search_key)
    {
        return $this->where('search_key', $search_key)->first();
    }

    public function get_solder_paste_by_scrap_to_return($search_key)
    {
        return $this->where('scrap')
                    ->where('search_key', $search_key)
                    ->first();
    }

    public function update_lot_number($id, $lot_number, $timestamp)
    {
        $data = [
            'returnsp' => $timestamp 
        ];

        return $this->where('id', $id)
                    ->where('lot_number', $lot_number)
                    ->set($data)
                    ->update();
    }

    public function update_lot_number_scrap($id, $lot_number, $timestamp)
    {
        $data = [
            'scrap' => $timestamp 
        ];

        return $this->where('id', $id)
                    ->where('lot_number', $lot_number)
                    ->set($data)
                    ->update();
    }

    public function insert_new_solder_paste_row_scrap($lot_number, $original_data, $timestamp)
    {
        $new_lot_number = 'OLD' . $lot_number;
        $new_search_key = $new_lot_number . $original_data['id'];

        $new_data = [
            'id' => $original_data['id'],
            'lot_number' => $new_lot_number,
            'search_key' => $new_search_key,
            'incoming' => null,
            'conditioning' => null,
            'mixing' => null,
            'handover' => null,
            'openusing' => null,
            'returnsp' => $timestamp,
            'scrap' => null
        ];

        return $this->insert($new_data);
    }


    public function update_lot_number_old($id, $lot_number)
    {
       
        $old_data = $this->find($id);

        $new_lot_number = 'RE' . $lot_number;

        $new_id = $old_data['id'] . '1';

        $new_search_key = $new_lot_number . $new_id;

        $data = [
            'lot_number' => $new_lot_number,
            'id' => $new_id,
            'search_key' => $new_search_key
        ];

        return $this->update($id, $data);
    }

    private function generate_new_id($old_id)
    {
        $new_id = $old_id . '1';
        while ($this->find($new_id)) {
            $new_id .= '1';
        }
        return $new_id;
    }

    public function insert_new_solder_paste_row($lot_number, $original_data, $timestamp)
    {
        $new_lot_number = 'OLD' . $lot_number;
        $new_search_key = $new_lot_number . $original_data['id'];

        $new_data = [
            'id' => $original_data['id'],
            'lot_number' => $new_lot_number,
            'search_key' => $new_search_key,
            'incoming' => null,
            'conditioning' => null,
            'mixing' => null,
            'handover' => null,
            'openusing' => null,
            'returnsp' => $timestamp,
            'scrap' => null
        ];

        return $this->insert($new_data);
    }
    
    public function insert_new_solder_paste_row_old($original_data)
    {
        $new_data = $original_data;

        $new_data['incoming'] = date('Y-m-d H:i:s');
        $new_data['conditioning'] = null;
        $new_data['mixing'] = null;
        $new_data['handover'] = null;
        $new_data['openusing'] = null;
        $new_data['returnsp'] = null;
        $new_data['scrap'] = null;

        return $this->insert($new_data);
    }

    public function update_incoming($id, $timestamp)
    {
        $data = [
            'incoming' => $timestamp
        ];

        return $this->update($id, $data);
    }

    public function update_incoming_prod($id, $timestamp)
    {
        $data = [
            'scrap' => $timestamp
        ];

        return $this->update($id, $data);
    }

    public function search_key($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->where('handover', NULL)
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function search_key_ext($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->where('conditioning', NULL)
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function search_key_inc($term)
    {
        return $this->select('DISTINCT(lot_number)', false)
                    ->like('lot_number', $term)
                    ->where('id IS NOT NULL')
                    ->where('lot_number IS NOT NULL')
                    ->findAll();
    }


    public function search_key_prod($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->where('handover IS NOT NULL')
                    ->groupStart()
                        ->where('returnsp', NULL)
                        ->where('scrap', NULL)
                        ->orWhere('lot_number LIKE', '%OLD%') 
                    ->groupEnd()
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function search_key_offprod($term)
    {
        return $this->select('lot_number, id')
                    ->like('id', $term)
                    ->groupStart()
                        ->where('returnsp', NULL)
                        ->where('scrap', NULL)
                        ->orWhere('lot_number LIKE', '%OLD%') 
                    ->groupEnd()
                    ->where('scrap', NULL)
                    ->findAll();
    }

    public function get_data_by_search_key_in_scrap($search_key)
    {
        try {
            return $this->where('scrap', $search_key)->first();
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return null;
        }
    }

    public function get_today_solder_paste_exp($limit = 5, $order = 'DESC')
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_start = date('Y-m-d 00:00:00');
        $today_end = date('Y-m-d 23:59:59');
        $two_days_ago = date('Y-m-d H:i:s', strtotime('-2 days'));
    
        $query = $this->db->table('solder_paste_test')
                        ->groupStart()
                            ->groupStart()
                                ->where('handover >=', $two_days_ago)
                                ->where('handover <=', $today_end)
                                ->where('handover IS NOT NULL')
                                ->orWhere('lot_number LIKE','%OLD%')
                                
                            ->groupEnd()
                            ->orGroupStart()
                                ->where('openusing >=', $two_days_ago)
                                ->where('openusing <=', $today_end)
                                ->where('openusing IS NOT NULL')
                                ->orWhere('lot_number LIKE','%OLD%')
                            ->groupEnd()
                        ->groupEnd()
                        ->where('returnsp IS NULL') 
                        ->where('scrap IS NULL')
                        ->orderBy('handover', $order)
                        ->limit($limit)
                        ->get();
    
        return $query->getResultArray();
    }    

    public function dataExists($lot_number, $id)
    {
        return $this->where('lot_number', $lot_number)
                    ->where('id', $id)
                    ->countAllResults() > 0;
    }  


}
