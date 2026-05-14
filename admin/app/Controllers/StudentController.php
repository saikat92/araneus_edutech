<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{StudentModel, EnrollmentModel, CourseModel};

class StudentController extends Controller {
    private StudentModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new StudentModel(); }

    public function index(): void {
        $search = $this->get('search', '');
        $status = $this->get('status', '');
        $page   = max(1, (int)$this->get('page', 1));
        $limit  = 15; $offset = ($page - 1) * $limit;
        $students = $this->model->searchAll($search, $status, $limit, $offset);
        $total    = $this->model->countSearch($search, $status);
        $pages    = ceil($total / $limit);
        $this->view('admin/students/index', compact('students','total','pages','page','search','status') + ['title'=>'Students']);
    }

    public function show(string $id): void {
        $student     = $this->model->findById((int)$id);
        if (!$student) { $this->setFlash('danger','Student not found'); $this->redirect('/admin/students'); }
        $enrollments = (new EnrollmentModel())->getByStudent((int)$id);
        $db          = \App\Core\Database::getInstance();
        $submissions = $db->fetchAll("SELECT sub.*, a.title as assignment_title FROM submissions sub JOIN assignments a ON a.id=sub.assignment_id WHERE sub.student_id=? ORDER BY submitted_at DESC", [(int)$id]);
        $attendance  = $db->fetchAll("SELECT att.*, c.title as course_title FROM attendance att JOIN courses c ON c.id=att.course_id WHERE att.student_id=?", [(int)$id]);
        $this->view('admin/students/show', compact('student','enrollments','submissions','attendance') + ['title'=>$student['full_name']]);
    }

    public function create(): void {
        $courses = (new CourseModel())->getActive();
        $this->view('admin/students/form', ['title'=>'Add Student','student'=>null,'courses'=>$courses,'action'=>'create']);
    }

    public function store(): void {
        $data = [
            'candidate_id'           => strtoupper(trim($this->post('candidate_id'))),
            'full_name'              => trim($this->post('full_name')),
            'email'                  => trim($this->post('email')),
            'phone'                  => trim($this->post('phone')),
            'father_name'            => trim($this->post('father_name')),
            'address'                => trim($this->post('address')),
            'highest_qualification'  => trim($this->post('highest_qualification')),
            'current_organization'   => trim($this->post('current_organization')),
            'github_link'            => trim($this->post('github_link')),
            'time_hours'             => (int)$this->post('time_hours', 0),
            'status'                 => $this->post('status', 'pending'),
            'password'               => password_hash($this->post('password', '123456'), PASSWORD_BCRYPT),
        ];
        $this->model->create($data);
        $this->setFlash('success', 'Student added successfully.');
        $this->redirect('/admin/students');
    }

    public function edit(string $id): void {
        $student = $this->model->findById((int)$id);
        if (!$student) { $this->redirect('/admin/students'); }
        $courses = (new CourseModel())->getActive();
        $this->view('admin/students/form', ['title'=>'Edit Student','student'=>$student,'courses'=>$courses,'action'=>'edit']);
    }

    public function update(string $id): void {
        $data = [
            'full_name'             => trim($this->post('full_name')),
            'email'                 => trim($this->post('email')),
            'phone'                 => trim($this->post('phone')),
            'father_name'           => trim($this->post('father_name')),
            'address'               => trim($this->post('address')),
            'highest_qualification' => trim($this->post('highest_qualification')),
            'current_organization'  => trim($this->post('current_organization')),
            'github_link'           => trim($this->post('github_link')),
            'time_hours'            => (int)$this->post('time_hours', 0),
            'status'                => $this->post('status', 'pending'),
        ];
        if ($pw = $this->post('password')) $data['password'] = password_hash($pw, PASSWORD_BCRYPT);
        $this->model->update((int)$id, $data);
        $this->setFlash('success', 'Student updated.');
        $this->redirect('/admin/students');
    }

    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success', 'Student deleted.');
        $this->redirect('/admin/students');
    }

    public function toggleStatus(string $id): void {
        $s = $this->model->findById((int)$id);
        if ($s) {
            $new = $s['status'] === 'active' ? 'inactive' : 'active';
            $this->model->update((int)$id, ['status' => $new]);
        }
        $this->redirectBack();
    }
}
