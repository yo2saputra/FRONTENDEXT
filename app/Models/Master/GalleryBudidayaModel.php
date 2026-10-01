<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class GalleryBudidayaModel extends Model
{
    protected $table = "gallery_budidaya";
    protected $primaryKey = "id";
    protected $allowedFields = ["gambarGalleryBudidaya", "textGalleryBudidaya", "budidayaId", "userId"];
    protected $useTimestamps = true;

    public function getGalleryBudidaya($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,gallery_budidaya.*")->join('user', 'user.id = gallery_budidaya.userId')->where(['gallery_budidaya.id' => $id])->first();
    }
}
