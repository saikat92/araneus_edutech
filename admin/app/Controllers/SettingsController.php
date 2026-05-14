<?php
namespace App\Controllers;
use App\Core\Controller;

class SettingsController extends Controller {
    public function __construct() { $this->requireAuth(); }

    public function index(): void {
        $db = \App\Core\Database::getInstance();
        $settings = $this->getSettings($db);
        $employees = $db->fetchAll("SELECT * FROM employees ORDER BY name");
        $this->view('admin/settings/index', compact('settings','employees') + ['title' => 'Company Settings']);
    }

    public function saveCompany(): void {
        $db = \App\Core\Database::getInstance();
        $fields = ['company_name','company_email','company_phone','company_address',
                   'company_city','company_state','company_pincode','company_gstin',
                   'company_pan','company_website','company_tagline','bank_name',
                   'bank_account','bank_ifsc','bank_branch'];
        foreach ($fields as $key) {
            $val = trim($this->post($key,''));
            $existing = $db->fetch("SELECT id FROM settings WHERE setting_key=?", [$key]);
            if ($existing) {
                $db->update('settings', ['setting_value'=>$val], 'setting_key=?', [$key]);
            } else {
                $db->insert('settings', ['setting_key'=>$key, 'setting_value'=>$val]);
            }
        }
        $this->setFlash('success','Company settings saved.');
        $this->redirect('/admin/settings');
    }

    public function storeEmployee(): void {
        $db = \App\Core\Database::getInstance();
        $db->insert('employees', [
            'name'       => trim($this->post('name')),
            'role'       => trim($this->post('role')),
            'type'       => $this->post('type','full-time'),
            'email'      => trim($this->post('email')),
            'phone'      => trim($this->post('phone')),
            'salary'     => (float)$this->post('salary',0),
            'join_date'  => $this->post('join_date', date('Y-m-d')),
            'status'     => $this->post('status','active'),
            'notes'      => trim($this->post('notes')),
        ]);
        $this->setFlash('success','Employee added.');
        $this->redirect('/admin/settings');
    }

    public function updateEmployee(string $id): void {
        $db = \App\Core\Database::getInstance();
        $db->update('employees', [
            'name'      => trim($this->post('name')),
            'role'      => trim($this->post('role')),
            'type'      => $this->post('type','full-time'),
            'email'     => trim($this->post('email')),
            'phone'     => trim($this->post('phone')),
            'salary'    => (float)$this->post('salary',0),
            'status'    => $this->post('status','active'),
            'notes'     => trim($this->post('notes')),
        ], 'id=?', [(int)$id]);
        $this->setFlash('success','Employee updated.');
        $this->redirect('/admin/settings');
    }

    public function deleteEmployee(string $id): void {
        \App\Core\Database::getInstance()->delete('employees','id=?',[(int)$id]);
        $this->setFlash('success','Employee removed.');
        $this->redirect('/admin/settings');
    }

    private function getSettings(\App\Core\Database $db): array {
        $rows = $db->fetchAll("SELECT setting_key, setting_value FROM settings");
        $out = [];
        foreach ($rows as $r) $out[$r['setting_key']] = $r['setting_value'];
        return $out;
    }
}