<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{EnrollmentModel, StudentModel, CourseModel};

class EnrollmentController extends Controller {
    private EnrollmentModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new EnrollmentModel(); }

    public function index(): void {
        $page = max(1,(int)$this->get('page',1)); $limit=15; $offset=($page-1)*$limit;
        $enrollments = $this->model->getWithDetails($limit,$offset);
        $total = $this->model->count(); $pages = ceil($total/$limit);
        $this->view('admin/enrollments/index', compact('enrollments','total','pages','page') + ['title'=>'Enrollments']);
    }
    public function create(): void {
        $students = (new StudentModel())->findAll('full_name');
        $courses  = (new CourseModel())->getActive();
        $this->view('admin/enrollments/form', ['title'=>'New Enrollment','enrollment'=>null,'students'=>$students,'courses'=>$courses]);
    }
    public function store(): void {
        $this->model->create([
            'student_id'      => (int)$this->post('student_id'),
            'course_id'       => (int)$this->post('course_id'),
            'enrollment_date' => $this->post('enrollment_date', date('Y-m-d')),
            'status'          => $this->post('status','enrolled'),
            'notes'           => trim($this->post('notes')),
        ]);
        $this->setFlash('success','Enrollment created.'); $this->redirect('/admin/enrollments');
    }
    public function edit(string $id): void {
        $enrollment = $this->model->findWithDetail((int)$id);
        $students   = (new StudentModel())->findAll('full_name');
        $courses    = (new CourseModel())->getActive();
        $this->view('admin/enrollments/form', compact('enrollment','students','courses') + ['title'=>'Edit Enrollment']);
    }
    public function update(string $id): void {
        $this->model->update((int)$id, [
            'status'          => $this->post('status'),
            'grade'           => trim($this->post('grade')),
            'completion_date' => $this->post('completion_date') ?: null,
            'notes'           => trim($this->post('notes')),
            'certificate_issued' => (int)$this->post('certificate_issued',0),
        ]);
        $this->setFlash('success','Enrollment updated.'); $this->redirect('/admin/enrollments');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Enrollment removed.'); $this->redirect('/admin/enrollments');
    }
}
