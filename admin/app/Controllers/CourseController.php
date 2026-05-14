<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\CourseModel;

class CourseController extends Controller {
    private CourseModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new CourseModel(); }

    public function index(): void {
        $courses = $this->model->findAll('title ASC');
        $this->view('admin/courses/index', compact('courses') + ['title'=>'Courses']);
    }
    public function create(): void {
        $this->view('admin/courses/form', ['title'=>'Add Course','course'=>null]);
    }
    public function store(): void {
        $this->model->create($this->getCourseData());
        $this->setFlash('success','Course added.'); $this->redirect('/admin/courses');
    }
    public function edit(string $id): void {
        $course = $this->model->findById((int)$id);
        $this->view('admin/courses/form', ['title'=>'Edit Course','course'=>$course]);
    }
    public function update(string $id): void {
        $this->model->update((int)$id, $this->getCourseData());
        $this->setFlash('success','Course updated.'); $this->redirect('/admin/courses');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Course deleted.'); $this->redirect('/admin/courses');
    }
    private function getCourseData(): array {
        return [
            'title'             => trim($this->post('title')),
            'description'       => trim($this->post('description')),
            'duration'          => trim($this->post('duration')),
            'mode'              => $this->post('mode','Online'),
            'fee'               => (float)$this->post('fee',0),
            'category'          => trim($this->post('category')),
            'instructor'        => trim($this->post('instructor')),
            'certification_type'=> trim($this->post('certification_type')),
            'tools_provided'    => trim($this->post('tools_provided')),
            'program_format'    => trim($this->post('program_format')),
            'is_active'         => (int)$this->post('is_active',1),
        ];
    }
}
