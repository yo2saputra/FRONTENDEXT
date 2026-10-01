<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    public function getAll($table)
    {
        return $this->db->table($table)->get()->getResult();
    }

    public function getByParent($table, $parentColumn, $parentId, $length)
    {
        return $this->db->table($table)
            ->where("LEFT($parentColumn, $length)", $parentId)
            ->get()
            ->getResult();
    }
}
