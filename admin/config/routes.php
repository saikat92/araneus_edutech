<?php
// Auth
$router->get('/setup',          'AuthController@setup');
$router->post('/setup',         'AuthController@setupPost');
$router->get('/login',          'AuthController@login');
$router->post('/login',         'AuthController@loginPost');
$router->get('/logout',         'AuthController@logout');

// Dashboard
$router->get('/',                'DashboardController@index');
$router->get('/admin/dashboard', 'DashboardController@index');

// Students
$router->get('/admin/students',              'StudentController@index');
$router->get('/admin/students/create',       'StudentController@create');
$router->post('/admin/students/create',      'StudentController@store');
$router->get('/admin/students/{id}',         'StudentController@show');
$router->get('/admin/students/{id}/edit',    'StudentController@edit');
$router->post('/admin/students/{id}/edit',   'StudentController@update');
$router->post('/admin/students/{id}/delete', 'StudentController@delete');
$router->post('/admin/students/{id}/status', 'StudentController@toggleStatus');

// Courses
$router->get('/admin/courses',              'CourseController@index');
$router->get('/admin/courses/create',       'CourseController@create');
$router->post('/admin/courses/create',      'CourseController@store');
$router->get('/admin/courses/{id}/edit',    'CourseController@edit');
$router->post('/admin/courses/{id}/edit',   'CourseController@update');
$router->post('/admin/courses/{id}/delete', 'CourseController@delete');

// Enrollments
$router->get('/admin/enrollments',              'EnrollmentController@index');
$router->get('/admin/enrollments/create',       'EnrollmentController@create');
$router->post('/admin/enrollments/create',      'EnrollmentController@store');
$router->get('/admin/enrollments/{id}/edit',    'EnrollmentController@edit');
$router->post('/admin/enrollments/{id}/edit',   'EnrollmentController@update');
$router->post('/admin/enrollments/{id}/delete', 'EnrollmentController@delete');

// Assignments
$router->get('/admin/assignments',              'AssignmentController@index');
$router->get('/admin/assignments/create',       'AssignmentController@create');
$router->post('/admin/assignments/create',      'AssignmentController@store');
$router->get('/admin/assignments/{id}/edit',    'AssignmentController@edit');
$router->post('/admin/assignments/{id}/edit',   'AssignmentController@update');
$router->post('/admin/assignments/{id}/delete', 'AssignmentController@delete');

// Submissions
$router->get('/admin/submissions',             'SubmissionController@index');
$router->get('/admin/submissions/{id}',        'SubmissionController@show');
$router->post('/admin/submissions/{id}/grade', 'SubmissionController@grade');

// Clients
$router->get('/admin/clients',              'ClientController@index');
$router->get('/admin/clients/create',       'ClientController@create');
$router->post('/admin/clients/create',      'ClientController@store');
$router->get('/admin/clients/{id}',         'ClientController@show');
$router->get('/admin/clients/{id}/edit',    'ClientController@edit');
$router->post('/admin/clients/{id}/edit',   'ClientController@update');
$router->post('/admin/clients/{id}/delete', 'ClientController@delete');

// Invoices
$router->get('/admin/invoices',              'InvoiceController@index');
$router->get('/admin/invoices/create',       'InvoiceController@create');
$router->post('/admin/invoices/create',      'InvoiceController@store');
$router->get('/admin/invoices/{id}',         'InvoiceController@show');
$router->get('/admin/invoices/{id}/edit',    'InvoiceController@edit');
$router->post('/admin/invoices/{id}/edit',   'InvoiceController@update');
$router->post('/admin/invoices/{id}/delete', 'InvoiceController@delete');
$router->post('/admin/invoices/{id}/status', 'InvoiceController@updateStatus');

// Payments
$router->get('/admin/payments',         'PaymentController@index');
$router->get('/admin/payments/create',  'PaymentController@create');
$router->post('/admin/payments/create', 'PaymentController@store');

// Accounts Ledger
$router->get('/admin/accounts',             'AccountController@index');
$router->get('/admin/accounts/{id}/ledger', 'AccountController@ledger');

// Blogs
$router->get('/admin/blogs',              'BlogController@index');
$router->get('/admin/blogs/create',       'BlogController@create');
$router->post('/admin/blogs/create',      'BlogController@store');
$router->get('/admin/blogs/{id}/edit',    'BlogController@edit');
$router->post('/admin/blogs/{id}/edit',   'BlogController@update');
$router->post('/admin/blogs/{id}/delete', 'BlogController@delete');

// Events
$router->get('/admin/events',              'EventController@index');
$router->get('/admin/events/create',       'EventController@create');
$router->post('/admin/events/create',      'EventController@store');
$router->get('/admin/events/{id}/edit',    'EventController@edit');
$router->post('/admin/events/{id}/edit',   'EventController@update');
$router->post('/admin/events/{id}/delete', 'EventController@delete');

// ── Careers ───────────────────────────────────────────────────────────────────
// RULE: all static paths (/jobs, /jobs/create) MUST be registered BEFORE {id}
// routes, otherwise the router matches "jobs" as an ID.

$router->get('/admin/careers', 'CareerController@index');

// Job Openings — static sub-paths first
$router->get('/admin/careers/jobs',              'CareerController@jobs');
$router->get('/admin/careers/jobs/create',       'CareerController@createJob');
$router->post('/admin/careers/jobs/create',      'CareerController@storeJob');
$router->get('/admin/careers/jobs/{id}/edit',    'CareerController@editJob');
$router->post('/admin/careers/jobs/{id}/edit',   'CareerController@updateJob');
$router->post('/admin/careers/jobs/{id}/delete', 'CareerController@deleteJob');

// Applications — dynamic {id} routes after static ones
$router->get('/admin/careers/{id}',              'CareerController@show');
$router->post('/admin/careers/{id}/status',      'CareerController@updateStatus');
$router->post('/admin/careers/{id}/delete',      'CareerController@deleteApplication');

// Testimonials
$router->get('/admin/testimonials',              'TestimonialController@index');
$router->get('/admin/testimonials/create',       'TestimonialController@create');
$router->post('/admin/testimonials/create',      'TestimonialController@store');
$router->get('/admin/testimonials/{id}/edit',    'TestimonialController@edit');
$router->post('/admin/testimonials/{id}/edit',   'TestimonialController@update');
$router->post('/admin/testimonials/{id}/delete', 'TestimonialController@delete');

// Admin Users
$router->get('/admin/users',              'UserController@index');
$router->get('/admin/users/create',       'UserController@create');
$router->post('/admin/users/create',      'UserController@store');
$router->get('/admin/users/{id}/edit',    'UserController@edit');
$router->post('/admin/users/{id}/edit',   'UserController@update');
$router->post('/admin/users/{id}/delete', 'UserController@delete');

// Reports
$router->get('/admin/reports',        'ReportController@index');
$router->get('/admin/reports/export', 'ReportController@export');

// Contact Submissions
$router->get('/admin/contacts',              'ContactController@index');
$router->get('/admin/contacts/{id}',         'ContactController@show');
$router->post('/admin/contacts/{id}/status', 'ContactController@updateStatus');

// Company Settings
$router->get('/admin/settings',                        'SettingsController@index');
$router->post('/admin/settings/company',               'SettingsController@saveCompany');
$router->post('/admin/settings/employees/create',      'SettingsController@storeEmployee');
$router->post('/admin/settings/employees/{id}/edit',   'SettingsController@updateEmployee');
$router->post('/admin/settings/employees/{id}/delete', 'SettingsController@deleteEmployee');

// ── Certificates ──────────────────────────────────────────────────────────────
$router->get('/admin/certificates',              'CertificateController@index');
$router->get('/admin/certificates/create',       'CertificateController@create');
$router->post('/admin/certificates/create',      'CertificateController@store');
$router->get('/admin/certificates/{id}',         'CertificateController@show');
$router->get('/admin/certificates/{id}/print',   'CertificateController@print');
$router->post('/admin/certificates/{id}/revoke', 'CertificateController@revoke');
$router->post('/admin/certificates/{id}/delete', 'CertificateController@delete');