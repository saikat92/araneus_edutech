<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\UserModel;

class AuthController extends Controller {
    private UserModel $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function setup(): void {
        if ($this->model->adminExists()) {
            $this->setFlash('info', 'Admin already registered. Please login.');
            $this->redirect('/login');
        }
        $this->view('auth/setup', ['title' => 'Setup Admin Account']);
    }

    public function setupPost(): void {
        if ($this->model->adminExists()) {
            $this->redirect('/login');
        }
        $data = [
            'full_name'     => trim($this->post('full_name')),
            'username'      => trim($this->post('username')),
            'email'         => trim($this->post('email')),
            'password_hash' => password_hash($this->post('password'), PASSWORD_BCRYPT),
            'role'          => 'admin',
            'status'        => 'active',
        ];
        $errors = [];
        if (strlen($data['full_name']) < 2) $errors[] = 'Full name required.';
        if (strlen($data['username']) < 3)  $errors[] = 'Username must be at least 3 chars.';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email required.';
        if (strlen($this->post('password')) < 6) $errors[] = 'Password must be at least 6 chars.';
        if ($this->post('password') !== $this->post('confirm_password')) $errors[] = 'Passwords do not match.';

        if ($errors) {
            $this->view('auth/setup', ['title'=>'Setup Admin', 'errors'=>$errors, 'old'=>$_POST]);
            return;
        }
        $this->model->create($data);
        $this->setFlash('success', 'Admin account created! Please login.');
        $this->redirect('/login');
    }

    public function login(): void {
        if (!empty($_SESSION['user_id'])) $this->redirect('/admin/dashboard');
        if (!$this->model->adminExists()) $this->redirect('/setup');
        $this->view('auth/login', ['title' => 'Admin Login']);
    }

    public function loginPost(): void {
        $username = trim($this->post('username'));
        $password = $this->post('password');
        $user = $this->model->findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash']) || $user['status'] !== 'active') {
            $this->view('auth/login', ['title'=>'Admin Login', 'error'=>'Invalid credentials or inactive account.', 'old'=>['username'=>$username]]);
            return;
        }
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['full_name'];
        $_SESSION['user_role']  = $user['role'];
        $_SESSION['username']   = $user['username'];
        $this->model->updateLastLogin($user['id']);
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/login');
    }
}
