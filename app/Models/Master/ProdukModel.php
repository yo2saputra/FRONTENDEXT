<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = "produk";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulDetailProduk", "judulDetailProdukWarna", "textDetailProdukTerkait", "userId"];
    protected $useTimestamps = true;

    public function getDetailProduk($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,produk.*")->join('user', 'user.id = produk.userId')->where(['produk.id' => $slug])->first();
    }
}
