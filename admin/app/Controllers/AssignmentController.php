<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{AssignmentModel, CourseModel};

class AssignmentController extends Controller {
    private AssignmentModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new AssignmentModel(); }

    public function index(): void {
        $page=max(1,(int)$this->get('page',1)); $limit=20; $offset=($page-1)*$limit;
        $assignments = $this->model->getWithCourse($limit,$offset);
        $total = $this->model->count(); $pages=ceil($total/$limit);
        $this->view('admin/assignments/index', compact('assignments','total','pages','page') + ['title'=>'Assignments']);
    }
    public function create(): void {
        $courses = (new CourseModel())->getActive();
        $this->view('admin/assignments/form', ['title'=>'New Assignment','assignment'=>null,'courses'=>$courses]);
    }
    public function store(): void {
        $this->model->create([
            'course_id'   => (int)$this->post('course_id'),
            'title'       => trim($this->post('title')),
            'description' => trim($this->post('description')),
            'due_date'    => $this->post('due_date') ?: null,
        ]);
        $this->setFlash('success','Assignment created.'); $this->redirect('/admin/assignments');
    }
    public function edit(string $id): void {
        $assignment = $this->model->findById((int)$id);
        $courses    = (new CourseModel())->getActive();
        $this->view('admin/assignments/form', compact('assignment','courses') + ['title'=>'Edit Assignment']);
    }
    public function update(string $id): void {
        $this->model->update((int)$id, [
            'course_id'   => (int)$this->post('course_id'),
            'title'       => trim($this->post('title')),
            'description' => trim($this->post('description')),
            'due_date'    => $this->post('due_date') ?: null,
        ]);
        $this->setFlash('success','Assignment updated.'); $this->redirect('/admin/assignments');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Assignment deleted.'); $this->redirect('/admin/assignments');
    }
}
