<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\BlogModel;

class BlogController extends Controller {
    private BlogModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new BlogModel(); }

    public function index(): void {
        $blogs=$this->model->findAll('created_at DESC');
        $this->view('admin/blogs/index', compact('blogs')+['title'=>'Blogs']);
    }
    public function create(): void { $this->view('admin/blogs/form',['title'=>'New Blog Post','blog'=>null]); }
    public function store(): void {
        $slug=$this->makeSlug($this->post('title'));
        $this->model->create([
            'title'          => trim($this->post('title')),
            'slug'           => $slug,
            'excerpt'        => trim($this->post('excerpt')),
            'content'        => $this->post('content'),
            'author'         => trim($this->post('author')),
            'category'       => trim($this->post('category')),
            'status'         => $this->post('status','draft'),
            'published_date' => $this->post('status')==='published' ? date('Y-m-d') : null,
        ]);
        $this->setFlash('success','Blog post saved.'); $this->redirect('/admin/blogs');
    }
    public function edit(string $id): void {
        $blog=$this->model->findById((int)$id);
        $this->view('admin/blogs/form',compact('blog')+['title'=>'Edit Blog']);
    }
    public function update(string $id): void {
        $data=[
            'title'    => trim($this->post('title')),
            'excerpt'  => trim($this->post('excerpt')),
            'content'  => $this->post('content'),
            'author'   => trim($this->post('author')),
            'category' => trim($this->post('category')),
            'status'   => $this->post('status','draft'),
        ];
        if ($this->post('status')==='published') $data['published_date']=date('Y-m-d');
        $this->model->update((int)$id,$data);
        $this->setFlash('success','Blog updated.'); $this->redirect('/admin/blogs');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Blog deleted.'); $this->redirect('/admin/blogs');
    }
    private function makeSlug(string $text): string {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/','-',$text),'-'));
    }
}
