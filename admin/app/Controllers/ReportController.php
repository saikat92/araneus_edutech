<?php
namespace App\Controllers;
use App\Core\Controller;

class ReportController extends Controller {
    public function __construct() { $this->requireAuth(); }

    public function index(): void {
        $db=\App\Core\Database::getInstance();
        $revenue_monthly=$db->fetchAll("SELECT DATE_FORMAT(invoice_date,'%b %Y') as month, SUM(total_amount) as total FROM invoices WHERE status='paid' GROUP BY YEAR(invoice_date),MONTH(invoice_date) ORDER BY invoice_date DESC LIMIT 12");
        $enrollments_by_course=$db->fetchAll("SELECT c.title, COUNT(e.id) as count FROM enrollments e JOIN courses c ON c.id=e.course_id GROUP BY c.id ORDER BY count DESC");
        $students_by_status=$db->fetchAll("SELECT status, COUNT(*) as count FROM students GROUP BY status");
        $submissions_by_grade=$db->fetchAll("SELECT grade, COUNT(*) as count FROM submissions WHERE grade IS NOT NULL GROUP BY grade ORDER BY grade");
        $top_clients=$db->fetchAll("SELECT c.client_name, COUNT(i.id) as invoice_count, SUM(i.total_amount) as total FROM invoices i JOIN clients c ON c.id=i.client_id WHERE i.status='paid' GROUP BY c.id ORDER BY total DESC LIMIT 5");
        $this->view('admin/reports/index', compact('revenue_monthly','enrollments_by_course','students_by_status','submissions_by_grade','top_clients')+['title'=>'Reports & Analytics']);
    }

    public function export(): void {
        $type=$this->get('type','students');
        $db=\App\Core\Database::getInstance();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$type.'_'.date('Ymd').'.csv"');
        $out=fopen('php://output','w');
        if ($type==='students') {
            fputcsv($out,['ID','Candidate ID','Name','Email','Phone','Status','Created']);
            foreach ($db->fetchAll("SELECT id,candidate_id,full_name,email,phone,status,created_at FROM students ORDER BY full_name") as $r) fputcsv($out,$r);
        } elseif ($type==='invoices') {
            fputcsv($out,['Invoice#','Client','Date','Total','Status']);
            foreach ($db->fetchAll("SELECT i.invoice_number,c.client_name,i.invoice_date,i.total_amount,i.status FROM invoices i JOIN clients c ON c.id=i.client_id ORDER BY i.created_at DESC") as $r) fputcsv($out,$r);
        } elseif ($type==='enrollments') {
            fputcsv($out,['Student','Course','Date','Status','Grade']);
            foreach ($db->fetchAll("SELECT s.full_name,c.title,e.enrollment_date,e.status,e.grade FROM enrollments e JOIN students s ON s.id=e.student_id JOIN courses c ON c.id=e.course_id ORDER BY e.created_at DESC") as $r) fputcsv($out,$r);
        }
        fclose($out); exit;
    }
}
