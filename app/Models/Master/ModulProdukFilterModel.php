<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class ModulProdukFilterModel extends Model
{
    protected $table = "modul_produk_filter";
    protected $primaryKey = "id";
    protected $allowedFields = ["filter", "userId"];
    protected $useTimestamps = true;

    public function getProdukFilterModul($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,modul_produk_filter.*")->join('user', 'user.id = modul_produk_filter.userId')->where(['modul_produk_filter.id' => $slug])->first();
    }
}
