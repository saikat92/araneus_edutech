<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\ClientModel;

class ClientController extends Controller {
    private ClientModel $model;
    public function __construct() { $this->requireAuth(); $this->model = new ClientModel(); }

    public function index(): void {
        $q=$this->get('q',''); $page=max(1,(int)$this->get('page',1)); $limit=15; $offset=($page-1)*$limit;
        $clients=$this->model->search($q,$limit,$offset); $total=$this->model->count(); $pages=ceil($total/$limit);
        $this->view('admin/clients/index', compact('clients','total','pages','page','q')+['title'=>'Clients']);
    }
    public function show(string $id): void {
        $client=$this->model->findById((int)$id);
        $db=\App\Core\Database::getInstance();
        $invoices=$db->fetchAll("SELECT * FROM invoices WHERE client_id=? ORDER BY created_at DESC",[(int)$id]);
        $this->view('admin/clients/show', compact('client','invoices')+['title'=>$client['client_name']]);
    }
    public function create(): void { $this->view('admin/clients/form',['title'=>'Add Client','client'=>null]); }
    public function store(): void {
        $this->model->create($this->getData());
        $this->setFlash('success','Client added.'); $this->redirect('/admin/clients');
    }
    public function edit(string $id): void {
        $client=$this->model->findById((int)$id);
        $this->view('admin/clients/form',['title'=>'Edit Client','client'=>$client]);
    }
    public function update(string $id): void {
        $this->model->update((int)$id,$this->getData());
        $this->setFlash('success','Client updated.'); $this->redirect('/admin/clients');
    }
    public function delete(string $id): void {
        $this->model->delete((int)$id);
        $this->setFlash('success','Client deleted.'); $this->redirect('/admin/clients');
    }
    private function getData(): array {
        return [
            'client_name'    => trim($this->post('client_name')),
            'client_type'    => $this->post('client_type','company'),
            'contact_person' => trim($this->post('contact_person')),
            'email'          => trim($this->post('email')),
            'phone'          => trim($this->post('phone')),
            'address'        => trim($this->post('address')),
            'city'           => trim($this->post('city')),
            'state'          => trim($this->post('state')),
            'country'        => trim($this->post('country','India')),
            'gstin'          => trim($this->post('gstin')),
            'pan'            => trim($this->post('pan')),
            'status'         => $this->post('status','active'),
            'notes'          => trim($this->post('notes')),
        ];
    }
}
