<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class KontakModel extends Model
{
    protected $table = "kontak";
    protected $primaryKey = "id";
    protected $allowedFields = ["email", "alamat", "textKontak", "jamOperational", "kontak", "map", "userId"];
    protected $useTimestamps = true;

    public function getKontak($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,kontak.*")->join('user', 'user.id = kontak.userId')->where(['kontak.id' => $slug])->first();
    }
}
