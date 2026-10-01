<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = "blog";
    protected $primaryKey = "id";
    protected $allowedFields = ["judulBlog", "isiBlog", "slugBlog", "gambarBlog", "statusBlog", "userId", "created_at", "updated_at"];
    protected $useTimestamps = true;

    public function getBlog($slug = false)
    {
        if ($slug == false) {
            return $this->findAll();
        }
        return $this->select("user.username,blog.*")->join('user', 'user.id = blog.userId')->where(['slugBlog' => $slug])->first();
    }

    public function getBlogSelected($card)
    {
        return $this->select("user.username,blog.*")->join('user', 'user.id = blog.userId')->orderBy('blog.id', 'desc')->findAll($card);
    }
}
