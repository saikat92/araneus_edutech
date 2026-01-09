<?php
$page_title = "Business Solutions";
require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2015&q=80');">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">Business Solutions</h1>
                <p class="lead mb-4">Comprehensive technology solutions to streamline operations, enhance productivity, and drive growth for businesses of all sizes.</p>
                <a href="#solutions" class="btn btn-primary btn-lg me-3">Explore Solutions</a>
                <a href="../contact.php" class="btn btn-outline-light btn-lg">Schedule Consultation</a>
            </div>
        </div>
    </div>
</section>

<!-- Overview Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h2 class="h1 mb-4">Transform Your Business with Technology</h2>
                <p class="lead mb-4">In today's digital landscape, leveraging the right technology solutions is crucial for business success. We provide comprehensive software, application, and digital solutions tailored to your specific business needs.</p>
                <p>From CRM implementation to custom software development, our team of experts ensures seamless integration and maximum ROI for your technology investments.</p>
                <a href="../contact.php" class="btn btn-primary mt-3 px-4">Get Free Consultation</a>
            </div>
            <div class="col-lg-6">
                <div class="business-overview-img">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="img-box">
                                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="CRM Solutions" class="img-fluid rounded">
                                <div class="img-overlay">
                                    <h5>CRM Solutions</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="img-box">
                                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="ERP Systems" class="img-fluid rounded">
                                <div class="img-overlay">
                                    <h5>ERP Systems</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="img-box">
                                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Custom Software" class="img-fluid rounded">
                                <div class="img-overlay">
                                    <h5>Custom Software</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="img-box">
                                <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Graphic Design" class="img-fluid rounded">
                                <div class="img-overlay">
                                    <h5>Graphic Design</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Solutions Grid -->
<section class="py-5 bg-light" id="solutions">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Business Solutions</h2>
            <p class="lead text-muted">Comprehensive technology solutions to optimize your business operations</p>
        </div>
        
        <div class="row g-4">
            <!-- CRM-Salesforce -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="crm">
                    <div class="solution-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4>CRM - Salesforce</h4>
                    <p>Comprehensive Salesforce CRM implementation, customization, and management to optimize customer relationships and drive sales growth.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Salesforce implementation & customization</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Sales cloud & service cloud setup</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Marketing automation integration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Ongoing support & maintenance</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
            
            <!-- ERP - Oracle E-Business Suite -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="erp">
                    <div class="solution-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h4>ERP - Oracle E-Business Suite</h4>
                    <p>End-to-end Oracle E-Business Suite implementation and optimization to streamline business processes and improve operational efficiency.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Oracle ERP implementation</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Financial & supply chain management</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Human capital management</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Custom module development</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
            
            <!-- Transition, Integration, Upgrade & Support -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="transition">
                    <div class="solution-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h4>Transition, Integration, Upgrade & Support</h4>
                    <p>Seamless technology transitions, system integrations, software upgrades, and comprehensive support services for business continuity.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Legacy system modernization</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Third-party system integration</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Software upgrade services</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>24/7 technical support</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
            
            <!-- Enterprise Solution Selection -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="enterprise">
                    <div class="solution-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4>Enterprise Solution Selection Consulting</h4>
                    <p>Expert guidance in selecting the right enterprise solutions that align with your business goals, budget, and technical requirements.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>Requirement analysis & vendor evaluation</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Solution comparison & ROI analysis</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Implementation roadmap planning</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Total cost of ownership analysis</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
            
            <!-- GST Solution & E-Invoicing -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="gst">
                    <div class="solution-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h4>GST Solution & E-Invoicing</h4>
                    <p>Comprehensive GST compliance solutions and e-invoicing systems to ensure regulatory compliance and streamline financial operations.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>GST compliance software</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>E-invoicing system implementation</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Tax filing automation</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Integration with existing ERP/accounting systems</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
            
            <!-- Industry Animation & Graphic Designing -->
            <div class="col-lg-4 col-md-6">
                <div class="business-solution-card" id="animation">
                    <div class="solution-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h4>Industry Animation & Graphic Designing</h4>
                    <p>Creative animation and graphic design services to enhance your brand presence, marketing materials, and digital content.</p>
                    <ul class="solution-features">
                        <li><i class="fas fa-check-circle text-success me-2"></i>2D & 3D animation services</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Brand identity & logo design</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>Marketing collateral design</li>
                        <li><i class="fas fa-check-circle text-success me-2"></i>UI/UX design for applications</li>
                    </ul>
                    <a href="../contact.php" class="btn btn-outline-primary btn-sm">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technology Stack -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Technology Expertise</h2>
            <p class="lead text-muted">We work with a wide range of modern technologies to deliver robust solutions</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fab fa-salesforce fa-3x"></i>
                    </div>
                    <h5>Salesforce</h5>
                    <p class="small">CRM Solutions</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fas fa-database fa-3x"></i>
                    </div>
                    <h5>Oracle</h5>
                    <p class="small">ERP & Database</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fab fa-php fa-3x"></i>
                    </div>
                    <h5>PHP</h5>
                    <p class="small">Web Development</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fab fa-js-square fa-3x"></i>
                    </div>
                    <h5>JavaScript</h5>
                    <p class="small">Frontend Development</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fab fa-react fa-3x"></i>
                    </div>
                    <h5>React</h5>
                    <p class="small">Frontend Framework</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fab fa-node-js fa-3x"></i>
                    </div>
                    <h5>Node.js</h5>
                    <p class="small">Backend Development</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fas fa-mobile-alt fa-3x"></i>
                    </div>
                    <h5>Mobile Apps</h5>
                    <p class="small">iOS & Android</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="tech-card text-center">
                    <div class="tech-icon">
                        <i class="fas fa-cloud fa-3x"></i>
                    </div>
                    <h5>Cloud</h5>
                    <p class="small">AWS, Azure, GCP</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-white">Our Implementation Process</h2>
            <p class="lead">A structured approach to ensure successful project delivery</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number">1</div>
                    <h4 class="mt-3 mb-3">Discovery & Analysis</h4>
                    <p>Understanding your business requirements, challenges, and objectives through detailed consultations.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number">2</div>
                    <h4 class="mt-3 mb-3">Solution Design</h4>
                    <p>Creating a customized solution architecture and implementation plan tailored to your needs.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number">3</div>
                    <h4 class="mt-3 mb-3">Development & Implementation</h4>
                    <p>Building and deploying the solution with regular updates and quality assurance testing.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="process-step text-center">
                    <div class="step-number">4</div>
                    <h4 class="mt-3 mb-3">Support & Optimization</h4>
                    <p>Providing ongoing support, maintenance, and optimization to ensure continued performance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="h1 mb-3">Ready to Transform Your Business?</h2>
                <p class="lead mb-4">Let's discuss how our business solutions can help streamline your operations, reduce costs, and drive growth.</p>
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <i class="fas fa-phone fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Call us directly</h5>
                        <p class="h4 mb-0">+91 98765 43210</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="../contact.php" class="btn btn-primary btn-lg px-5">Schedule Consultation <i class="fas fa-calendar-alt ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for this page -->
<style>
    .business-overview-img .img-box {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }
    
    .business-overview-img .img-box img {
        transition: transform 0.5s ease;
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .business-overview-img .img-box:hover img {
        transform: scale(1.05);
    }
    
    .img-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
        color: white;
        padding: 20px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    
    .business-solution-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: transform 0.3s ease;
    }
    
    .business-solution-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
    }
    
    .solution-icon {
        width: 70px;
        height: 70px;
        background-color: rgba(255, 69, 0, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    .solution-icon i {
        font-size: 30px;
        color: #FF4500;
    }
    
    .business-solution-card h4 {
        color: #333;
        margin-bottom: 15px;
    }
    
    .solution-features {
        list-style: none;
        padding-left: 0;
        margin-bottom: 20px;
    }
    
    .solution-features li {
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .tech-card {
        padding: 25px 15px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }
    
    .tech-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .tech-icon {
        margin-bottom: 15px;
        color: #FF4500;
    }
    
    .process-step {
        padding: 20px;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .business-overview-img .img-box img {
            height: 150px;
        }
        
        .business-solution-card {
            padding: 20px;
        }
    }
</style>

<?php require_once 'includes/footer.php'; ?>