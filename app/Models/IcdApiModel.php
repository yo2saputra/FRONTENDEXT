<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\RawSql;


class IcdApiModel extends Model
{
    protected $table = "icds";
    // protected $primaryKey = "id";
    // protected $allowedFields = ["judulDetailProduk", "judulDetailProdukWarna", "textDetailProdukTerkait", "userId"];
    // protected $useTimestamps = true;

    // public function getDetailProduk($slug = false)
    // {
    //     if ($slug == false) {
    //         return $this->findAll();
    //     }
    //     return $this->select("user.username,produk.*")->join('user', 'user.id = produk.userId')->where(['produk.id' => $slug])->first();
    // }

    public function insertValue($table, $data)
    {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return true;
    }

    public function updateValue($table, $where, $data)
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->update($data);
        return true;
    }

    public function deleteValue($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        $builder->delete();
        return true;
    }

    // public function selectRecord($table, $where = array())
    // {
    //     $builder = $this->db->table($table);
    //     $builder->select("kode_item,nama_item,satuan,ppn,kategori,CONCAT((SELECT param_valu FROM tcontrol_parameter WHERE param_nm = 'image_path'),image_path) AS image_path", false);
    //     $builder->where($where);
    //     $result = $builder->get();
    //     return $result->getResult();
    // }

    public function selectRecord($table, $where = array())
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        $result = $builder->get();
        return $result->getResult();
    }

    // public function selectRow($table, $where = array())
    // {
    //     $builder = $this->db->table($table);
    //     $builder->select("kode_item,nama_item,satuan,ppn,kategori,CONCAT((SELECT param_valu FROM tcontrol_parameter WHERE param_nm = 'image_path'),image_path) AS image_path", false);
    //     $builder->where($where);
    //     $result = $builder->get();
    //     return $result->getRow();
    // }


    public function selectRow($table, $where = array())
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        $result = $builder->get();
        return $result->getRow();
    }

    public function searchData($searchTerm, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $builder = $this->table($this->table)
            ->like('name_id', $searchTerm)
            ->limit($pageSize, $offset);

        return [
            'results' => $builder->get()->getResult(),
            'pagination' => [
                'more' => true // Atur ini berdasarkan logika paginasi Anda
            ]
        ];
    }

    // public function searchDataIdn($searchTerm)
    // {
    //     $builder = $this->table($this->table)
    //         ->like('name_id', $searchTerm);
    //         $result = $builder->get();
    //     return [
    //         // 'results' => $builder->get()->getResult(),
    //         // 'pagination' => [
    //         //     'more' => true // Atur ini berdasarkan logika paginasi Anda
    //         // ]
    //         // Generate array with filtered records  
    //         $usersData = array(); 
    //         if($result->getNumRows > 0){  
    //             while($row = $result->fetch_assoc()){  
    //                 $data['id'] = $row['id'];  
    //                 $data['text'] = $row['name'];  
    //                 array_push($usersData, $data);  
    //             }  
    //         }  

    //         // Return results as json encoded array  
    //         echo json_encode($usersData);  
    //     ];
    // }

    public function searchDataIdn($searchTerm)
    {
        // Gunakan Query Builder untuk membangun query pencarian
        // $builder = $this->table($this->table)
        // ->like('code', $searchTerm)
        // ->like('name_en', $searchTerm);
        // ->like('name_id', $searchTerm);
        // ->orderBy('name_id', 'ASC');

        // // $subquery = $this->table($this->table)->select("CONCAT($this->table.code, ' ',$this->table.name_en , ' ',$this->table.name_id )");
        // $builder  = $this->table($this->table)
        //     ->select('code')
        //     ->select('name_en')
        //     ->select('name_id')
        //     ->select("CONCAT($this->table.code, ' ',$this->table.name_en , ' ',$this->table.name_id ) AS 'icd'", FALSE)
        //     // ->selectSubquery($subquery, 'icd');
        //     ->like('icd', $searchTerm, 'both');
        // // ->like('text', $searchTerm);

        // $result = $builder->get()->getResultArray();

        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM (SELECT code,name_en,name_id,CONCAT($this->table.code, ' ',$this->table.name_en , ' ',$this->table.name_id ) AS icd FROM $this->table) AS subquery WHERE subquery.icd LIKE '%$searchTerm%'");
        $result = $query->getResultArray();

        return $result;
    }
}
