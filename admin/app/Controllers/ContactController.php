<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\ContactModel;

class ContactController extends Controller {
    private ContactModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new ContactModel(); }

    public function index(): void {
        $contacts=$this->model->findAll('submission_date DESC');
        $this->view('admin/contacts/index',compact('contacts')+['title'=>'Contact Submissions']);
    }
    public function show(string $id): void {
        $contact=$this->model->findById((int)$id);
        if ($contact['status']==='new') $this->model->update((int)$id,['status'=>'read']);
        $this->view('admin/contacts/show',compact('contact')+['title'=>'Contact Message']);
    }
    public function updateStatus(string $id): void {
        $this->model->update((int)$id,['status'=>$this->post('status','read')]);
        $this->redirectBack();
    }
}
