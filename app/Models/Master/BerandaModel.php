<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class BerandaModel extends Model
{
    protected $table = "beranda";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulProduk", "judulProdukWarna", "textProduk", "judulBlog", "judulBlogWarna", "textBlog", "userId"];
    protected $useTimestamps = true;

    public function getBeranda($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,beranda.*")->join('user', 'user.id = beranda.userId')->where(['beranda.id' => $slug])->first();
    }

    public function getBerandaSelected($card)
    {
        return $this->select("user.username,beranda.*")->join('user', 'user.id = beranda.userId')->orderBy('beranda.id', 'desc')->findAll($card);
    }
}
