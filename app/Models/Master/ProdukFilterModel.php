<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class ProdukFilterModel extends Model
{
    protected $table = "produk_filter";
    protected $primaryKey = "id";
    protected $allowedFields = ["filter", "userId"];
    protected $useTimestamps = true;

    public function getProdukFilter($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,produk_filter.*")->join('user', 'user.id = produk_filter.userId')->where(['produk_filter.id' => $id])->first();
    }
}
