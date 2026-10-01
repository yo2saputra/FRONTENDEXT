<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $table = "mitra";
    protected $primaryKey = "id";
    protected $allowedFields = ["namaMitra", "logoMitra", "keteranganMitra", "kategoriMitra", "userId"];
    protected $useTimestamps = true;

    public function getMitra($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,mitra.*")->join('user', 'user.id = mitra.userId')->where(['mitra.id' => $id])->first();
    }
}
