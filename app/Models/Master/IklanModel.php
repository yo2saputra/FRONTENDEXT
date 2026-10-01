<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class IklanModel extends Model
{
    protected $table = "iklan";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulIklan", "judulIklanWarna", "discIklan", "textIklan", "gambarIklan", "statusIklan", "userId"];
    protected $useTimestamps = true;

    public function getIklan($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,iklan.*")->join('user', 'user.id = iklan.userId')->where(['iklan.id' => $id])->first();
    }
}
