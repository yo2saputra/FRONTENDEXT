<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class BudidayaModel extends Model
{
    protected $table = "budidaya";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulBudidaya", "judulBudidayaWarna", "textBudidaya", "isiBudidaya", "userId"];
    protected $useTimestamps = true;

    public function getBudidaya($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,budidaya.*")->join('user', 'user.id = budidaya.userId')->where(['budidaya.id' => $id])->first();
    }
}
