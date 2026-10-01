<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user";
    protected $primaryKey = "id";
    protected $allowedFields = ["username", "email", "password", "role", "aktif"];
    protected $useTimestamps = true;

    public function getUser($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("*")->where(['user.id' => $id])->first();
    }
}
