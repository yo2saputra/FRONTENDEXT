<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class ResepModel extends Model
{
    protected $table = "resep";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulResep", "isiResep", "slugResep", "gambarResep", "prosesResep", "kategoriResep", "statusResep", "userId", "created_at", "updated_at"];
    protected $useTimestamps = true;

    public function getResep($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,resep.*")->join('user', 'user.id = resep.userId')->where(['slugResep' => $slug])->first();
    }

    public function getResepSelected($card)
    {
        return $this->select("user.username,resep.*")->join('user', 'user.id = resep.userId')->orderBy('resep.id', 'desc')->findAll($card);
    }
}
