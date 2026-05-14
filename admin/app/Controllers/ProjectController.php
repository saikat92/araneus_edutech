<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\ProjectModel;

class ProjectController extends Controller {
    private ProjectModel $model;

    public function __construct() {
        $this->requireAuth();
        $this->model = new ProjectModel();
    }

    // GET /admin/projects
    public function index(): void {
        $projects = $this->model->findAll('sort_order ASC, id ASC');
        $this->view('admin/projects/index', [
            'title'    => 'Projects',
            'projects' => $projects,
        ]);
    }

    // GET /admin/projects/create
    public function create(): void {
        $this->view('admin/projects/form', [
            'title'   => 'New Project',
            'project' => null,
        ]);
    }

    // POST /admin/projects/create
    public function store(): void {
        $this->model->create($this->buildData());
        $this->setFlash('success', 'Project created successfully.');
        $this->redirect('/admin/projects');
    }

    // GET /admin/projects/{id}/edit
    public function edit(string $id): void {
        $project = $this->model->findById((int)$id);
        $this->view('admin/projects/form', [
            'title'   => 'Edit Project',
            'project' => $project,
        ]);
    }

    // POST /admin/projects/{id}/edit
    public function update(string $id): void {
        $this->model->update((int)$id, $this->buildData());
        $this->setFlash('success', 'Project updated successfully.');
        $this->redirect('/admin/projects');
    }

    // POST /admin/projects/{id}/delete
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success', 'Project deleted.');
        $this->redirect('/admin/projects');
    }

    // ── Private helper: build data array from POST ─────────────
    private function buildData(): array {
        // Build media JSON from the repeatable media rows
        $mediaTypes  = $_POST['media_type']  ?? [];
        $mediaUrls   = $_POST['media_url']   ?? [];
        $mediaLabels = $_POST['media_label'] ?? [];
        $mediaArr = [];
        foreach ($mediaTypes as $k => $type) {
            $url   = trim($mediaUrls[$k]   ?? '');
            $label = trim($mediaLabels[$k] ?? '');
            if ($url || $label) {
                $mediaArr[] = [
                    'type'  => in_array($type, ['link','video','image']) ? $type : 'link',
                    'url'   => $url,
                    'label' => $label,
                ];
            }
        }

        return [
            'title'       => trim($this->post('title')),
            'category'    => trim($this->post('category')),
            'description' => trim($this->post('description')),
            'tags'        => trim($this->post('tags')),
            'image_url'   => trim($this->post('image_url')),
            'color'       => trim($this->post('color') ?: '#ff4000'),
            'media'       => $mediaArr ? json_encode($mediaArr) : null,
            'sort_order'  => (int)$this->post('sort_order', 0),
            'status'      => $this->post('status', 'published'),
        ];
    }
}
