<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class DistribusiModel extends Model
{
    protected $table = "distribusi";
    protected $primaryKey = "id";
    protected $allowedFields = ["namaDistribusi", "gambarDistribusi", "keteranganDistribusi", "userId"];
    protected $useTimestamps = true;

    public function getDistribusi($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,distribusi.*")->join('user', 'user.id = distribusi.userId')->where(['distribusi.id' => $id])->first();
    }
}
