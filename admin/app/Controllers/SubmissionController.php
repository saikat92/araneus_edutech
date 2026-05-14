<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\SubmissionModel;

class SubmissionController extends Controller {
    private SubmissionModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new SubmissionModel(); }

    public function index(): void {
        $page=max(1,(int)$this->get('page',1)); $limit=20; $offset=($page-1)*$limit;
        $submissions = $this->model->getWithDetails($limit,$offset);
        $total = $this->model->count(); $pages=ceil($total/$limit);
        $this->view('admin/submissions/index', compact('submissions','total','pages','page') + ['title'=>'Submissions']);
    }

    public function show(string $id): void {
        $submission = $this->model->findWithDetail((int)$id);
        if (!$submission) { $this->redirect('/admin/submissions'); }
        $this->view('admin/submissions/show', compact('submission') + ['title'=>'Submission Detail']);
    }

    public function grade(string $id): void {
        $this->model->update((int)$id, [
            'grade'    => trim($this->post('grade')),
            'feedback' => trim($this->post('feedback')),
        ]);
        $this->setFlash('success','Graded successfully.'); $this->redirect('/admin/submissions');
    }
}
