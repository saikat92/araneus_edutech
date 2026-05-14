<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\TestimonialModel;

class TestimonialController extends Controller {
    private TestimonialModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new TestimonialModel(); }

    public function index(): void {
        $t=$this->model->findAll('created_at DESC');
        $this->view('admin/testimonials/index',['testimonials'=>$t,'title'=>'Testimonials']);
    }
    public function create(): void { $this->view('admin/testimonials/form',['title'=>'Add Testimonial','testimonial'=>null]); }
    public function store(): void {
        $this->model->create([
            'client_name'     => trim($this->post('client_name')),
            'client_position' => trim($this->post('client_position')),
            'company'         => trim($this->post('company')),
            'testimonial'     => trim($this->post('testimonial')),
            'rating'          => (int)$this->post('rating',5),
            'testimonial_date'=> $this->post('testimonial_date',date('Y-m-d')),
            'is_featured'     => (int)$this->post('is_featured',0),
            'status'          => $this->post('status','published'),
        ]);
        $this->setFlash('success','Testimonial added.'); $this->redirect('/admin/testimonials');
    }
    public function edit(string $id): void {
        $testimonial=$this->model->findById((int)$id);
        $this->view('admin/testimonials/form',compact('testimonial')+['title'=>'Edit Testimonial']);
    }
    public function update(string $id): void {
        $this->model->update((int)$id,[
            'client_name'     => trim($this->post('client_name')),
            'client_position' => trim($this->post('client_position')),
            'company'         => trim($this->post('company')),
            'testimonial'     => trim($this->post('testimonial')),
            'rating'          => (int)$this->post('rating',5),
            'is_featured'     => (int)$this->post('is_featured',0),
            'status'          => $this->post('status','published'),
        ]);
        $this->setFlash('success','Testimonial updated.'); $this->redirect('/admin/testimonials');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id); $this->setFlash('success','Deleted.'); $this->redirect('/admin/testimonials');
    }
}
