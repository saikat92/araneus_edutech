<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{AssignmentModel, CourseModel};

class AssignmentController extends Controller {
    private AssignmentModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new AssignmentModel(); }

    public function index(): void {
        $limit  = max(10, min(100, (int)$this->get('limit', 25)));
        $page   = max(1, (int)$this->get('page', 1));
        $offset = ($page - 1) * $limit;

        $filters = [
            'course_id'  => $this->get('course_id', ''),
            'search'     => trim($this->get('search', '')),
            'due_filter' => $this->get('due_filter', ''),
            'sort'       => $this->get('sort', 'a.due_date'),
            'order'      => $this->get('order', 'asc'),
        ];

        $assignments = $this->model->getFiltered($limit, $offset, $filters);
        $total       = $this->model->countFiltered($filters);
        $pages       = (int)ceil($total / $limit);
        $stats       = $this->model->getStats();
        $courses     = (new CourseModel())->getActive();

        $this->view('admin/assignments/index', compact(
            'assignments', 'total', 'pages', 'page',
            'limit', 'offset', 'filters', 'stats', 'courses'
        ) + ['title' => 'Assignments']);
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
