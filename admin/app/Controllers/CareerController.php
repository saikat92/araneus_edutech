<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\CareerModel;

class CareerController extends Controller {
    private CareerModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new CareerModel(); }

    // ── Applications ──────────────────────────────────────────────────────────

    public function index(): void {
        $status = $this->get('status', '');
        $db     = \App\Core\Database::getInstance();
        $params = [];
        $where  = '1=1';
        if ($status) { $where = 'status=?'; $params[] = $status; }
        $careers = $db->fetchAll(
            "SELECT * FROM career_applications WHERE $where ORDER BY application_date DESC",
            $params
        );
        $this->view('admin/careers/index', compact('careers', 'status') + ['title' => 'Career Applications']);
    }

    public function show(string $id): void {
        $career = $this->model->findById((int)$id);
        if (!$career) { $this->setFlash('danger', 'Not found.'); $this->redirect('/admin/careers'); }
        $this->view('admin/careers/show', compact('career') + [
            'title' => $career['first_name'] . ' ' . $career['last_name']
        ]);
    }

    public function updateStatus(string $id): void {
        $this->model->update((int)$id, [
            'status' => $this->post('status'),
            'notes'  => trim($this->post('notes', '')),
        ]);
        $this->setFlash('success', 'Status updated.');
        $this->redirect('/admin/careers/' . $id);
    }

    public function deleteApplication(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success', 'Application deleted.');
        $this->redirect('/admin/careers');
    }

    // ── Job Openings ──────────────────────────────────────────────────────────

    public function jobs(): void {
        $db   = \App\Core\Database::getInstance();
        $jobs = $db->fetchAll("SELECT * FROM job_openings ORDER BY created_at DESC");
        $this->view('admin/careers/jobs', compact('jobs') + ['title' => 'Job Openings']);
    }

    public function createJob(): void {
        $this->view('admin/careers/job_form', ['title' => 'Post New Job', 'job' => null]);
    }

    public function storeJob(): void {
        \App\Core\Database::getInstance()->insert('job_openings', $this->getJobData());
        $this->setFlash('success', 'Job posted successfully.');
        $this->redirect('/admin/careers/jobs');
    }

    public function editJob(string $id): void {
        $job = \App\Core\Database::getInstance()->fetch(
            "SELECT * FROM job_openings WHERE id=?", [(int)$id]
        );
        if (!$job) { $this->setFlash('danger', 'Job not found.'); $this->redirect('/admin/careers/jobs'); }
        $this->view('admin/careers/job_form', compact('job') + ['title' => 'Edit Job Posting']);
    }

    public function updateJob(string $id): void {
        \App\Core\Database::getInstance()->update(
            'job_openings', $this->getJobData(), 'id=?', [(int)$id]
        );
        $this->setFlash('success', 'Job updated.');
        $this->redirect('/admin/careers/jobs');
    }

    public function deleteJob(string $id): void {
        \App\Core\Database::getInstance()->delete('job_openings', 'id=?', [(int)$id]);
        $this->setFlash('success', 'Job deleted.');
        $this->redirect('/admin/careers/jobs');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function getJobData(): array {
        return [
            'title'                => trim($this->post('title')),
            'department'           => trim($this->post('department')),
            'location'             => trim($this->post('location')),
            'employment_type'      => $this->post('employment_type', 'full-time'),
            'description'          => trim($this->post('description')),
            'requirements'         => trim($this->post('requirements')),
            'responsibilities'     => trim($this->post('responsibilities')),
            'benefits'             => trim($this->post('benefits')),
            'is_active'            => (int)$this->post('is_active', 1),
            'posted_date'          => $this->post('posted_date', date('Y-m-d')),
            'application_deadline' => $this->post('application_deadline') ?: null,
        ];
    }
}
