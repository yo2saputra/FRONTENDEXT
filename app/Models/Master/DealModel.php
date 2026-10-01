<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class DealModel extends Model
{
    protected $table = "deal";
    protected $primaryKey = "id";
    protected $allowedFields = ["judul", "judulDeal", "judulDealWarna", "textDeal", "discDeal", "discDealDetail", "kode_item", "statusDeal", "userId"];
    protected $useTimestamps = true;

    public function getDeal($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,deal.*")->join('user', 'user.id = deal.userId')->where(['deal.id' => $id])->first();
    }
}
