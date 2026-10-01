<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class TestimoniModel extends Model
{
    protected $table = "testimoni";
    protected $primaryKey = "id";
    protected $allowedFields = ["namaBuyer", "gambarBuyer", "isiTestimoni", "pekerjaanBuyer", "userId"];
    protected $useTimestamps = true;

    public function getTestimoni($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,testimoni.*")->join('user', 'user.id = testimoni.userId')->where(['testimoni.id' => $id])->first();
    }
}
