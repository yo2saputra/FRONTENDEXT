<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class OperasionalModel extends Model
{
    protected $table = "operasional";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulOperasional", "judulOperasionalWarna", "textOperasional", "isiOperasional", "userId"];
    protected $useTimestamps = true;

    public function getOperasional($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,operasional.*")->join('user', 'user.id = operasional.userId')->where(['operasional.id' => $id])->first();
    }
}
