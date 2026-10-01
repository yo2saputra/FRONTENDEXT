<?php

namespace App\Controllers;

// use App\Models\BlogModel;
// use App\Models\CustomerModel;

class Setting extends BaseController
{
    protected $blogModel, $customerModel;
    public function __construct()
    {
        // $this->blogModel = new BlogModel();
        // $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Blog | PT. DELTA FOOD DISTRIBUSI',
            // 'blog' => $this->blogModel->findAll(),
            // 'customer' => $this->customerModel->findAll()
        ];

        return view('blog', $data);
    }

    public function detail($id = false)
    {
        $data = [
            'title' => 'Detail Blog | PT. DELTA FOOD DISTRIBUSI',
            // 'blog' => $this->blogModel->find($id),
            // 'customer' => $this->customerModel->findAll()
        ];

        return view('blog_detail', $data);
    }
}
