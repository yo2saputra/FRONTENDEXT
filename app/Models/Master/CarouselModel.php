<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class CarouselModel extends Model
{
    protected $table = "carousel";
    protected $primaryKey = "id";
    protected $allowedFields = ["namaCarousel", "gambarCarousel", "userId"];
    protected $useTimestamps = true;

    public function getCarousel($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,carousel.*")->join('user', 'user.id = carousel.userId')->where(['carousel.id' => $id])->first();
    }
}
