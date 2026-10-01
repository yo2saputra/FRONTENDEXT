<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class GalleryOperasionalModel extends Model
{
    protected $table = "gallery_operasional";
    protected $primaryKey = "id";
    protected $allowedFields = ["gambarGalleryOperasional", "textGalleryOperasional", "operasionalId", "userId"];
    protected $useTimestamps = true;

    public function getGalleryOperasional($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,gallery_operasional.*")->join('user', 'user.id = gallery_operasional.userId')->where(['gallery_operasional.id' => $id])->first();
    }
}
