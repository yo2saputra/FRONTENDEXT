<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Controllers\Mitra;

class Blog extends BaseController
{
    protected $blogModel, $mitra, $data;
    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->mitra = new Mitra();
        $this->data = [
            'template' => $this->getTemplateData()
        ];
    }

    public function index()
    {
        $this->data['title'] = 'Blog | PT. DELTA FOOD DISTRIBUSI';
        $this->data['blog'] = $this->blogModel->getBlog();
        $this->data['pager'] = $this->blogModel->pager;
        $this->data['mitras'] = $this->mitra->modulMitra();

        return view('blog', $this->data);
    }

    public function detail($id = false)
    {
        $this->data['title'] = 'Detail Blog | PT. DELTA FOOD DISTRIBUSI';
        $this->data['blog'] = $this->blogModel->getBlogDetail($id);
        $this->data['blogTerbaru'] = $this->blogTerbaru(5);
        $this->data['blogArsip'] = $this->blogArsip(5);
        //dd($this->data['blogArsip']);

        return view('blog_detail', $this->data);
    }

    public function modulBlog($card)
    {
        $this->data['blog'] = $this->blogModel->getBlogSelected($card);
        return $this->data['blog'];
    }

    public function blogTerbaru($baris)
    {
        $this->data['blogTerbaru'] = $this->blogModel->getBlogTerbaru($baris);
        return $this->data['blogTerbaru'];
    }

    public function blogArsip($baris)
    {
        $this->data['blogArsip'] = $this->blogModel->getBlogArsip($baris);
        return $this->data['blogArsip'];
    }

    public function arsip($tahun)
    {
        $this->data['title'] = 'Blog Arsip | PT. DELTA FOOD DISTRIBUSI';
        $this->data['blog'] = $this->blogModel->getBlogArsipTahun($tahun);
        $this->data['pager'] = $this->blogModel->pager;
        $this->data['mitras'] = $this->mitra->modulMitra();

        return view('blog', $this->data);
    }
}
