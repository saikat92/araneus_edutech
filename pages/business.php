<?php
$page_title = "Business Solutions";
require_once '../includes/header.php';
?>

<style>
.biz-hero { background:linear-gradient(135deg,rgba(26,26,46,.93) 0%,rgba(10,36,66,.9) 100%), url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1400&q=80') center/cover; padding:calc(var(--nav-height) + 70px) 0 80px; color:#fff; }
.sol-grid-card { background:#fff; border-radius:16px; padding:28px; box-shadow:var(--shadow-sm); height:100%; transition:var(--transition); border-bottom:3px solid transparent; }
.sol-grid-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-md); border-bottom-color:var(--primary-color); }
.sol-icon-circle { width:58px; height:58px; border-radius:14px; background:rgba(255,64,0,.08); display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
.sol-icon-circle i { font-size:22px; color:var(--primary-color); }
.sol-features { list-style:none; padding:0; margin:0; }
.sol-features li { font-size:.83rem; padding:5px 0; border-bottom:1px solid #f0f0f0; display:flex; gap:8px; }
.sol-features li:last-child { border:none; }
.sol-features li i { color:var(--secondary-color); margin-top:2px; flex-shrink:0; }
.tech-pill { display:inline-flex; flex-direction:column; align-items:center; padding:18px 14px; background:#fff; border-radius:12px; box-shadow:var(--shadow-sm); transition:var(--transition); min-width:90px; }
.tech-pill:hover { transform:translateY(-4px); box-shadow:var(--shadow-md); color:var(--primary-color); }
.tech-pill i { font-size:28px; color:var(--primary-color); margin-bottom:8px; }
.tech-pill span { font-size:.72rem; font-weight:600; text-align:center; color:#555; }
.process-step { text-align:center; padding:28px 20px; }
.step-circle { width:60px; height:60px; border-radius:50%; background:rgba(255,255,255,.2); border:2px solid rgba(255,255,255,.4); display:flex; align-items:center; justify-content:center; font-size:1.4rem; font-weight:800; margin:0 auto 16px; }
</style>

<!-- Hero -->
<section class="biz-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3">Business Solutions</span>
                <h1 class="display-4 fw-bold mb-4">Transform Your Business with Technology</h1>
                <p class="lead opacity-75 mb-5">Comprehensive software, ERP, CRM, and digital solutions tailored to your specific business needs — from SMEs to enterprises.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="#solutions"  class="btn btn-primary btn-lg">Explore Solutions</a>
                    <a href="contact.php" class="btn btn-secondary btn-lg">Free Consultation</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <div class="row g-3">
                    <?php foreach ([
                        ['fas fa-users-cog','CRM Solutions','Salesforce implementation'],
                        ['fas fa-server',  'ERP Systems',  'Oracle E-Business Suite'],
                        ['fas fa-file-invoice','GST & E-Invoice','Compliance made easy'],
                        ['fas fa-paint-brush','Design Studio','Branding & animation'],
                    ] as [$icon,$title,$sub]): ?>
                    <div class="col-6">
                        <div class="p-3 rounded-3" style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.12);backdrop-filter:blur(6px);">
                            <i class="<?=$icon?> fa-2x mb-2" style="color:var(--secondary-color);"></i>
                            <div class="fw-bold small text-white"><?=$title?></div>
                            <div class="opacity-65 small" style="font-size:.75rem;"><?=$sub?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solutions grid -->
<section class="section-padding" id="solutions">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Business Solutions</h2>
            <p class="text-muted">End-to-end technology services to streamline, scale, and succeed</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                ['fas fa-users-cog','CRM – Salesforce','crm',
                    'Implement and customise Salesforce CRM to manage customer relationships, automate sales pipelines, and drive revenue growth.',
                    ['Salesforce Sales Cloud','Salesforce Service Cloud','Custom CRM Workflows','Lead & Opportunity Management','CRM Training & Adoption']],
                ['fas fa-server','ERP Solutions','erp',
                    'Oracle E-Business Suite and custom ERP implementations to unify finance, HR, procurement, and operations on one platform.',
                    ['Oracle E-Business Suite','Financial Management','HR & Payroll Modules','Inventory & Procurement','ERP Migration & Upgrade']],
                ['fas fa-file-invoice-dollar','GST & E-Invoicing','gst',
                    'End-to-end GST compliance, e-invoicing setup, and return filing solutions aligned with Indian tax regulations.',
                    ['GST Registration & Filing','E-Invoice Integration','GST Reconciliation','TDS & TCS Compliance','GST Audit Support']],
                ['fas fa-laptop-code','Custom Software','software',
                    'Bespoke web and mobile application development tailored to your business workflows and growth objectives.',
                    ['Web App Development','Mobile Apps (iOS & Android)','API Integrations','Database Design','Software Maintenance']],
                ['fas fa-paint-brush','Animation & Design','design',
                    'Professional graphic design, animation, and branding services that make your business look as good as it performs.',
                    ['Brand Identity Design','2D/3D Animation','Marketing Collaterals','UI/UX Design','Social Media Creatives']],
                ['fas fa-exchange-alt','Transition & Support','support',
                    'Smooth technology transitions, system integrations, and round-the-clock post-deployment support.',
                    ['System Integration','Legacy Migration','24/7 Technical Support','User Training Sessions','SLA-based Maintenance']],
            ] as [$icon,$title,$id,$desc,$features]): ?>
            <div class="col-lg-4 col-md-6">
                <div class="sol-grid-card" id="<?=$id?>">
                    <div class="sol-icon-circle"><i class="<?=$icon?>"></i></div>
                    <h5 class="fw-bold mb-2"><?=$title?></h5>
                    <p class="text-muted small mb-3"><?=$desc?></p>
                    <ul class="sol-features">
                        <?php foreach ($features as $f): ?>
                        <li><i class="fas fa-angle-right"></i><?=$f?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="contact.php" class="btn btn-outline-primary btn-sm mt-3 w-100">Get a Quote</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Tech stack -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Technologies We Work With</h2>
            <p class="text-muted">Our team is proficient in the platforms that power modern businesses</p>
        </div>
        <div class="d-flex flex-wrap gap-3 justify-content-center">
            <?php foreach ([
                ['fab fa-salesforce','Salesforce'],
                ['fas fa-database',  'Oracle'],
                ['fab fa-php',       'PHP'],
                ['fab fa-js-square', 'JavaScript'],
                ['fab fa-react',     'React'],
                ['fab fa-node-js',   'Node.js'],
                ['fab fa-python',    'Python'],
                ['fas fa-mobile-alt','Mobile Apps'],
                ['fab fa-aws',       'AWS'],
                ['fas fa-cloud',     'Azure / GCP'],
                ['fab fa-docker',    'Docker'],
                ['fas fa-code-branch','Git / CI/CD'],
            ] as [$icon,$name]): ?>
            <div class="tech-pill">
                <i class="<?=$icon?>"></i>
                <span><?=$name?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Process -->
<section class="py-5 text-white" style="background:var(--gradient-color);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-white">Our Implementation Process</h2>
            <p class="opacity-75">A structured approach ensuring successful, on-time project delivery</p>
        </div>
        <div class="row g-4">
            <?php foreach ([
                [1,'Discovery &amp; Analysis',  'Understanding your business requirements, challenges, and objectives through detailed consultations.'],
                [2,'Solution Design',           'Creating a customized solution architecture and implementation plan tailored to your needs.'],
                [3,'Development &amp; Deploy',  'Building and deploying the solution with regular updates and quality assurance testing.'],
                [4,'Support &amp; Optimise',    'Providing ongoing support, maintenance, and optimisation to ensure continued performance.'],
            ] as [$n,$title,$desc]): ?>
            <div class="col-lg-3 col-md-6">
                <div class="process-step">
                    <div class="step-circle"><?=$n?></div>
                    <h5 class="fw-bold mb-2"><?=$title?></h5>
                    <p class="opacity-75 small mb-0"><?=$desc?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2">Ready to Transform Your Business?</h2>
                <p class="lead text-muted mb-3">Let's discuss how we can streamline your operations and drive growth.</p>
                <div class="d-flex align-items-center gap-3">
                    <div style="width:46px;height:46px;border-radius:12px;background:rgba(255,64,0,.1);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-phone" style="color:var(--primary-color);"></i>
                    </div>
                    <div>
                        <div class="small text-muted">Call us directly</div>
                        <a href="tel:<?=preg_replace('/[^0-9+]/','',SITE_PHONE)?>" class="h5 mb-0 text-dark fw-bold"><?=SITE_PHONE?></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="contact.php" class="btn btn-primary btn-lg px-5">
                    Schedule Consultation <i class="fas fa-calendar-alt ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
