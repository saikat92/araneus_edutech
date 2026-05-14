<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\UserModel;

class UserController extends Controller {
    private UserModel $model;
    public function __construct() { $this->requireAuth(); $this->requireRole('admin'); $this->model = new UserModel(); }

    public function index(): void {
        $users=$this->model->findAll('full_name');
        $this->view('admin/users/index',compact('users')+['title'=>'Admin Users']);
    }
    public function create(): void { $this->view('admin/users/form',['title'=>'New User','user'=>null]); }
    public function store(): void {
        $this->model->create([
            'full_name'     => trim($this->post('full_name')),
            'username'      => trim($this->post('username')),
            'email'         => trim($this->post('email')),
            'password_hash' => password_hash($this->post('password','123456'),PASSWORD_BCRYPT),
            'role'          => $this->post('role','staff'),
            'status'        => $this->post('status','active'),
        ]);
        $this->setFlash('success','User created.'); $this->redirect('/admin/users');
    }
    public function edit(string $id): void {
        $user=$this->model->findById((int)$id);
        $this->view('admin/users/form',compact('user')+['title'=>'Edit User']);
    }
    public function update(string $id): void {
        $data=[
            'full_name' => trim($this->post('full_name')),
            'email'     => trim($this->post('email')),
            'role'      => $this->post('role','staff'),
            'status'    => $this->post('status','active'),
        ];
        if ($pw=$this->post('password')) $data['password_hash']=password_hash($pw,PASSWORD_BCRYPT);
        $this->model->update((int)$id,$data);
        $this->setFlash('success','User updated.'); $this->redirect('/admin/users');
    }
    public function delete(string $id): void {
        if ((int)$id===$_SESSION['user_id']) { $this->setFlash('danger','Cannot delete yourself.'); $this->redirect('/admin/users'); }
        $this->model->delete((int)$id);
        $this->setFlash('success','User deleted.'); $this->redirect('/admin/users');
    }
}
