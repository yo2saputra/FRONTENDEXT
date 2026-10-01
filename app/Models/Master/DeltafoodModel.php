<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class DeltafoodModel extends Model
{
    protected $table = "deltafood";
    protected $primaryKey = "id";
    protected $allowedFields = ["linkVideoModulDeltafood", "judulDeltafood", "judulDeltafoodWarna", "textDeltafood", "judulModulDeltafood", "judulModulDeltafoodWarna", "gambarDeltafood", "textModulDeltafood", "gambarModulDeltafood", "textFooterDeltafood", "userId"];
    protected $useTimestamps = true;

    public function getDeltafood($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,deltafood.*")->join('user', 'user.id = deltafood.userId')->where(['deltafood.id' => $id])->first();
    }

    public function getModulDeltafood($id = false)
    {
        if ($id == false) {
            return $this->select("user.username,deltafood.linkVideoModulDeltafood,deltafood.judulModulDeltafood,deltafood.judulModulDeltafoodWarna,deltafood.textModulDeltafood,deltafood.gambarModulDeltafood")->findAll();
        }
        return $this->select("user.username,deltafood.linkVideoModulDeltafood,deltafood.judulModulDeltafood,,deltafood.judulModulDeltafoodWarna,deltafood.textModulDeltafood,deltafood.gambarModulDeltafood")->join('user', 'user.id = deltafood.userId')->where(['deltafood.id' => $id])->first();
    }

    public function getTextFooterDeltafood()
    {
        return $this->select('textFooterDeltafood')->findAll();
    }
}
