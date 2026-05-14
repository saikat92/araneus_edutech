<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\{StudentModel, CourseModel, EnrollmentModel, ClientModel, InvoiceModel, SubmissionModel, ContactModel};

class DashboardController extends Controller {
    public function index(): void {
        $this->requireAuth();
        $db = \App\Core\Database::getInstance();

        $stats = [
            'total_students'     => (new StudentModel())->count(),
            'active_students'    => (new StudentModel())->countWhere("status='active'"),
            'total_courses'      => (new CourseModel())->count(),
            'total_enrollments'  => (new EnrollmentModel())->count(),
            'total_clients'      => (new ClientModel())->count(),
            'pending_invoices'   => (new InvoiceModel())->countWhere("status IN ('draft','sent','overdue')"),
            'pending_grading'    => (new SubmissionModel())->countPending(),
            'new_contacts'       => (new ContactModel())->countWhere("status='new'"),
            'total_revenue'      => (new InvoiceModel())->totalRevenue(),
        ];

        $recent_students    = $db->fetchAll("SELECT * FROM students ORDER BY created_at DESC LIMIT 5");
        $recent_submissions = $db->fetchAll(
            "SELECT sub.*, s.full_name, a.title as assignment_title 
             FROM submissions sub JOIN students s ON s.id=sub.student_id 
             JOIN assignments a ON a.id=sub.assignment_id
             ORDER BY sub.submitted_at DESC LIMIT 5");
        $enrollment_chart   = $db->fetchAll(
            "SELECT DATE_FORMAT(created_at,'%b %Y') as month, COUNT(*) as total 
             FROM enrollments GROUP BY YEAR(created_at), MONTH(created_at) 
             ORDER BY created_at DESC LIMIT 6");

        $this->view('admin/dashboard/index', compact('stats','recent_students','recent_submissions','enrollment_chart') + ['title'=>'Dashboard']);
    }
}
