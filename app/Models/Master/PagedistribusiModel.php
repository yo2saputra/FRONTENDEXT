<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class PagedistribusiModel extends Model
{
    protected $table = "pagedistribusi";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulDistribusi", "judulDistribusiWarna", "textDistribusi", "judulCabang", "judulCabangWarna", "textCabang", "userId"];
    protected $useTimestamps = true;

    public function getPagedistribusi($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,pagedistribusi.*")->join('user', 'user.id = pagedistribusi.userId')->where(['pagedistribusi.id' => $slug])->first();
    }

    public function getPagedistribusiSelected($card)
    {
        return $this->select("user.username,pagedistribusi.*")->join('user', 'user.id = pagedistribusi.userId')->orderBy('pagedistribusi.id', 'desc')->findAll($card);
    }
}
