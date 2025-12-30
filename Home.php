<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanaka Benson Munjanja | DevOps Engineer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #1abc9c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #7f8c8d;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header & Navigation */
        header {
            background-color: var(--primary);
            color: white;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
        }
        
        .logo span {
            color: var(--accent);
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 2rem;
        }
        
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        nav ul li a:hover {
            color: var(--accent);
        }
        
        .menu-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Main Content */
        main {
            margin-top: 80px;
            min-height: calc(100vh - 200px);
        }
        
        .page {
            display: none;
            animation: fadeIn 0.5s ease-in;
        }
        
        .page.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 4rem 0;
            border-radius: 10px;
            margin-bottom: 3rem;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
        }
        
        .hero h2 {
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 1.5rem;
            color: var(--light);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        
        /* Section Styling */
        .section {
            background-color: white;
            border-radius: 10px;
            padding: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: var(--shadow);
        }
        
        .section-title {
            color: var(--primary);
            border-bottom: 3px solid var(--accent);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            display: inline-block;
        }
        
        /* Skills Grid */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .skill-category {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid var(--secondary);
        }
        
        .skill-category h3 {
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .skill-list {
            list-style-type: none;
        }
        
        .skill-list li {
            margin-bottom: 0.8rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .skill-name {
            font-weight: 500;
        }
        
        .skill-level {
            font-size: 0.9rem;
            color: var(--gray);
            font-weight: 500;
        }
        
        /* Experience Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--secondary);
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.1rem;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--accent);
        }
        
        .timeline-date {
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        
        .timeline-role {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.3rem;
        }
        
        .timeline-company {
            color: var(--gray);
            margin-bottom: 0.5rem;
        }
        
        /* Certifications Grid */
        .certs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .cert-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            transition: transform 0.3s;
            border-top: 4px solid var(--accent);
        }
        
        .cert-card:hover {
            transform: translateY(-5px);
        }
        
        .cert-card h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .cert-card p {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        /* Education Cards */
        .edu-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .edu-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            border-left: 4px solid var(--secondary);
        }
        
        /* Contact Info */
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .contact-icon {
            background-color: var(--secondary);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        
        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        
        .gallery-item {
            border-radius: 8px;
            overflow: hidden;
            height: 200px;
            position: relative;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        
        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.8rem;
            font-size: 0.9rem;
        }
        
        /* Hobbies Section */
        .hobbies {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .hobby-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            flex: 1;
            min-width: 200px;
            text-align: center;
            border-top: 4px solid var(--accent);
        }
        
        .hobby-icon {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }
        
        /* Footer */
        footer {
            background-color: var(--primary);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
            text-align: center;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .social-links a {
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        
        .social-links a:hover {
            color: var(--accent);
        }
        
        .copyright {
            color: #bdc3c7;
            font-size: 0.9rem;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            nav {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: var(--primary);
                display: none;
                padding: 1rem 0;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }
            
            nav.active {
                display: block;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
            }
            
            nav ul li {
                margin: 0.8rem 0;
            }
            
            .hero {
                padding: 3rem 0;
            }
            
            .hero h1 {
                font-size: 1.8rem;
            }
            
            .hero h2 {
                font-size: 1.3rem;
            }
            
            .section {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .hero {
                padding: 2rem 0;
            }
            
            .hero h1 {
                font-size: 1.6rem;
            }
            
            .skills-grid, .certs-grid, .edu-cards {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container header-container">
            <a href="#" class="logo">TBM<span>.</span></a>
            <div class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
            <nav id="mainNav">
                <ul>
                    <li><a href="#" data-page="home" class="nav-link active">Home</a></li>
                    <li><a href="#" data-page="skills" class="nav-link">Skills</a></li>
                    <li><a href="#" data-page="experience" class="nav-link">Experience</a></li>
                    <li><a href="#" data-page="certifications" class="nav-link">Certifications</a></li>
                    <li><a href="#" data-page="education" class="nav-link">Education</a></li>
                    <li><a href="#" data-page="gallery" class="nav-link">Gallery</a></li>
                    <li><a href="#" data-page="contact" class="nav-link">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <!-- Home Page -->
        <section id="home" class="page active">
            <div class="hero">
                <h1>Tanaka Benson Munjanja</h1>
                <h2>DevOps Support Engineer / Systems Engineer</h2>
                <p>Expert in endpoint management, cloud computing, and incident management to ensure reliable system performance. Skilled in Microsoft 365, Azure, and Dynamics 365 CRM configuration and support, driving operational efficiency and security compliance.</p>
                <div style="margin-top: 2rem;">
                    <a href="#" data-page="contact" class="nav-link" style="background-color: var(--accent); color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none; display: inline-block; margin-right: 1rem;">Contact Me</a>
                    <a href="#" data-page="experience" class="nav-link" style="background-color: transparent; color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none; display: inline-block; border: 2px solid white;">View Experience</a>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">Professional Summary</h2>
                <p>DevOps Support Engineer & Systems Engineer with expertise in endpoint management, cloud computing, and incident management to ensure reliable system performance. Skilled in Microsoft 365, Azure, and Dynamics 365 CRM configuration and support, driving operational efficiency and security compliance. Focused on leveraging technical and leadership skills to enhance infrastructure resilience and support scalable growth.</p>
            </div>
            
            <div class="section">
                <h2 class="section-title">Quick Links</h2>
                <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 1.5rem;">
                    <div style="flex: 1; min-width: 200px; background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-top: 4px solid var(--secondary);">
                        <h3 style="color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-code" style="color: var(--secondary); margin-right: 0.5rem;"></i> Technical Skills</h3>
                        <p>Explore my technical expertise in cloud computing, administration, security compliance, and more.</p>
                        <a href="#" data-page="skills" class="nav-link" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Skills →</a>
                    </div>
                    
                    <div style="flex: 1; min-width: 200px; background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-top: 4px solid var(--accent);">
                        <h3 style="color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-briefcase" style="color: var(--secondary); margin-right: 0.5rem;"></i> Work Experience</h3>
                        <p>Review my professional journey with companies like Blugrass Digital, Sompisi IT Solutions, and more.</p>
                        <a href="#" data-page="experience" class="nav-link" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Experience →</a>
                    </div>
                    
                    <div style="flex: 1; min-width: 200px; background-color: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-top: 4px solid var(--secondary);">
                        <h3 style="color: var(--primary); margin-bottom: 1rem;"><i class="fas fa-certificate" style="color: var(--secondary); margin-right: 0.5rem;"></i> Certifications</h3>
                        <p>Browse my professional certifications from Microsoft, Google, CompTIA, and other institutions.</p>
                        <a href="#" data-page="certifications" class="nav-link" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Certifications →</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills Page -->
        <section id="skills" class="page">
            <div class="section">
                <h2 class="section-title">Technical & Professional Skills</h2>
                <div class="skills-grid">
                    <div class="skill-category">
                        <h3><i class="fas fa-cloud"></i> Cloud Computing</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">Azure, Microsoft 365</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">AWS, Google Cloud</span><span class="skill-level">Advanced</span></li>
                            <li><span class="skill-name">Azure App Services, Front Door, CDN</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Azure Virtual Networks, NSGs, Firewalls</span><span class="skill-level">Advanced</span></li>
                        </ul>
                    </div>
                    
                    <div class="skill-category">
                        <h3><i class="fas fa-shield-alt"></i> Security & Administration</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">Security Compliance</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Incident Management</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Email Security (SPF, DKIM, DMARC)</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Microsoft Entra ID, MFA, RBAC</span><span class="skill-level">Expert</span></li>
                        </ul>
                    </div>
                    
                    <div class="skill-category">
                        <h3><i class="fas fa-tools"></i> Technical Skills</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">Ticketing Systems (Dynamics 365, Jira)</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Endpoint Management (Intune)</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">CI/CD Pipelines (Azure DevOps)</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Network Configuration</span><span class="skill-level">Expert</span></li>
                        </ul>
                    </div>
                    
                    <div class="skill-category">
                        <h3><i class="fas fa-code"></i> Programming</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">C#, Java, Python</span><span class="skill-level">Intermediate</span></li>
                            <li><span class="skill-name">JavaScript, HTML/CSS</span><span class="skill-level">Intermediate</span></li>
                        </ul>
                    </div>
                    
                    <div class="skill-category">
                        <h3><i class="fas fa-users"></i> Professional Skills</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">Leadership</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Communication</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Problem-solving</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Time Management</span><span class="skill-level">Expert</span></li>
                        </ul>
                    </div>
                    
                    <div class="skill-category">
                        <h3><i class="fas fa-server"></i> Infrastructure</h3>
                        <ul class="skill-list">
                            <li><span class="skill-name">Infrastructure Monitoring</span><span class="skill-level">Expert</span></li>
                            <li><span class="skill-name">Computer Virtualization</span><span class="skill-level">Advanced</span></li>
                            <li><span class="skill-name">Web Hosting, Domain Management</span><span class="skill-level">Advanced</span></li>
                            <li><span class="skill-name">Hardware & Software Configuration</span><span class="skill-level">Expert</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience Page -->
        <section id="experience" class="page">
            <div class="section">
                <h2 class="section-title">Work Experience</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">Jul 2025 — Present</div>
                        <div class="timeline-role">DevOps Support Engineer</div>
                        <div class="timeline-company">Blugrass Digital | Cape Town, Johannesburg</div>
                        <ul>
                            <li>Managed Azure infrastructure including App Services, Front Door, CDN, VNets, and firewalls</li>
                            <li>Strengthen security with Entra ID, MFA, RBAC, and Endpoint Manager policies</li>
                            <li>Build and maintain CI/CD pipelines using Azure DevOps</li>
                            <li>Deployed and manage containerized applications with Docker & Kubernetes</li>
                        </ul>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">Jul 2024 — Jun 2025</div>
                        <div class="timeline-role">IT Manager / Head of IT Support</div>
                        <div class="timeline-company">Sompisi IT Solutions | Cape Town</div>
                        <ul>
                            <li>Delivered advanced support across Microsoft 365, Azure, domains, and networking</li>
                            <li>Improved security posture through MFA enforcement, Intune compliance, and VPN policies</li>
                            <li>Managed SharePoint sites, permissions, automations, and workflows</li>
                            <li>Reported KPIs and service metrics directly to executive leadership</li>
                        </ul>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">Aug 2023 — Jun 2024</div>
                        <div class="timeline-role">ICT Systems Engineer</div>
                        <div class="timeline-company">Global Micro Solutions | Rosebank, Johannesburg</div>
                        <ul>
                            <li>Performed email setups, migrations, DNS configuration, and domain transfers</li>
                            <li>Managed AD DS, Microsoft 365, licensing, and user access control</li>
                            <li>Provided remote support, resolving technical issues within SLA targets</li>
                            <li>Set up web hosting (WordPress, Joomla) and configured SSL certificates</li>
                        </ul>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">Jul 2022 — Jul 2023</div>
                        <div class="timeline-role">IT Technician</div>
                        <div class="timeline-company">Matrix Warehouse | Fourways, Johannesburg</div>
                        <ul>
                            <li>Supported desktops, laptops, routers, and Windows systems (hardware/software)</li>
                            <li>Managed AD DS, security groups, and user access policies</li>
                            <li>Installed and troubleshooted Microsoft 365, Kaspersky, and business applications for clients</li>
                            <li>Performed network testing and resolved connectivity faults for home and office users</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Certifications Page -->
        <section id="certifications" class="page">
            <div class="section">
                <h2 class="section-title">Certifications</h2>
                <div class="certs-grid">
                    <!-- Certifications will be populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Education Page -->
        <section id="education" class="page">
            <div class="section">
                <h2 class="section-title">Education</h2>
                <div class="edu-cards">
                    <div class="edu-card">
                        <h3>Bachelor of Science Honours in Computing</h3>
                        <p><strong>University of South Africa</strong></p>
                        <p>Pretoria, South Africa</p>
                        <p><em>Feb 2023 - May 2025</em></p>
                    </div>
                    
                    <div class="edu-card">
                        <h3>Bachelor of Science in Information Technology</h3>
                        <p><strong>Richfield Graduate Institute of Technology</strong></p>
                        <p>Johannesburg, South Africa</p>
                        <p><em>Feb 2018 - Aug 2021</em></p>
                    </div>
                    
                    <div class="edu-card">
                        <h3>Matric (Bachelor Pass)</h3>
                        <p><strong>Northview High School</strong></p>
                        <p>Johannesburg, South Africa</p>
                        <p><em>Jan 2013 - Dec 2017</em></p>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">Languages</h2>
                <div class="skills-grid">
                    <div class="skill-category">
                        <h3>English</h3>
                        <p><strong>Level:</strong> C1 - Advanced</p>
                    </div>
                    
                    <div class="skill-category">
                        <h3>IsiZulu</h3>
                        <p><strong>Level:</strong> B2 - Upper intermediate</p>
                    </div>
                    
                    <div class="skill-category">
                        <h3>Shona</h3>
                        <p><strong>Level:</strong> Native</p>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2 class="section-title">Hobbies & Interests</h2>
                <div class="hobbies">
                    <div class="hobby-item">
                        <div class="hobby-icon"><i class="fas fa-gamepad"></i></div>
                        <h3>Gaming</h3>
                        <p>Enjoy strategic and immersive gaming experiences</p>
                    </div>
                    
                    <div class="hobby-item">
                        <div class="hobby-icon"><i class="fas fa-desktop"></i></div>
                        <h3>PC Building</h3>
                        <p>Building custom computers and optimizing hardware</p>
                    </div>
                    
                    <div class="hobby-item">
                        <div class="hobby-icon"><i class="fas fa-fish"></i></div>
                        <h3>Fishing</h3>
                        <p>Relaxing outdoor activity for stress relief</p>
                    </div>
                    
                    <div class="hobby-item">
                        <div class="hobby-icon"><i class="fas fa-film"></i></div>
                        <h3>Movies</h3>
                        <p>Watching films across various genres</p>
                    </div>
                    
                    <div class="hobby-item">
                        <div class="hobby-icon"><i class="fas fa-running"></i></div>
                        <h3>Sports</h3>
                        <p>Following various sports events and activities</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Page -->
        <section id="gallery" class="page">
            <div class="section">
                <h2 class="section-title">Technology & Work Gallery</h2>
                <p>Images related to my professional field, cloud computing, DevOps, and IT infrastructure.</p>
                <div class="gallery-grid">
                    <!-- Gallery items will be populated by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Contact Page -->
        <section id="contact" class="page">
            <div class="section">
                <h2 class="section-title">Contact Information</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3>Location</h3>
                            <p>Johannesburg, South Africa</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3>Phone</h3>
                            <p>+27 61 953 8407</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3>Email</h3>
                            <p>bensommunjanja@gmail.com</p>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 2rem;">
                    <h3 class="section-title" style="border-bottom: none; margin-bottom: 1rem;">Connect with me</h3>
                    <p>Feel free to reach out for professional opportunities, collaboration, or to discuss technology trends.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h3>Tanaka Benson Munjanja</h3>
            <p>DevOps Support Engineer / Systems Engineer</p>
            <div class="social-links">
                <a href="https://www.linkedin.com/in/tanaka-munjanja-a724001a1/"><i class="fab fa-linkedin"></i></a>
                <a href="https://github.com/Benson117"><i class="fab fa-github"></i></a>
            <a href="mailto:bensommunjanja@gmail.com"><i class="fas fa-envelope"></i></a>
            </div>
            <p class="copyright">© 2023 Tanaka Benson Munjanja. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Menu toggle for mobile
            const menuToggle = document.getElementById('menuToggle');
            const mainNav = document.getElementById('mainNav');
            
            menuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('active');
            });
            
            // Page navigation
            const navLinks = document.querySelectorAll('.nav-link');
            const pages = document.querySelectorAll('.page');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get the target page ID
                    const targetPage = this.getAttribute('data-page');
                    
                    // Hide all pages
                    pages.forEach(page => {
                        page.classList.remove('active');
                    });
                    
                    // Show target page
                    document.getElementById(targetPage).classList.add('active');
                    
                    // Update active nav link
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Close mobile menu if open
                    if (window.innerWidth <= 768) {
                        mainNav.classList.remove('active');
                    }
                });
            });
            
            // Populate certifications
            const certifications = [
                { name: "Google Marketing Fundamentals", issuer: "Google", date: "Dec 2021" },
                { name: "Microsoft Azure Data Fundamentals [DP-900]", issuer: "Microsoft", date: "Sep 2021" },
                { name: "Microsoft Azure Fundamentals [AZ-900]", issuer: "Microsoft", date: "Dec 2021" },
                { name: "Microsoft AI Fundamentals [AI-900]", issuer: "Microsoft", date: "Sep 2021" },
                { name: "Security, Compliance, and Identity Fundamentals [SC-900]", issuer: "Microsoft", date: "Jan 2022" },
                { name: "OPSWAT Introduction to Critical Infrastructure Protection & Cyber Security", issuer: "OPSWAT", date: "Nov 2025" },
                { name: "CompTIA IT Fundamentals [FCO-U61] - ITF+", issuer: "CompTIA", date: "Jan 2020" },
                { name: "CompTIA A+ [220-1101 & 220-1102]", issuer: "CompTIA", date: "Jan 2021" },
                { name: "CompTIA Network+ [N10-008] - N+", issuer: "CompTIA", date: "Feb 2021" },
                { name: "cPanel Professional Certification Exam (CPP)", issuer: "cPanel", date: "Dec 2024" },
                { name: "cPanel Imunify360 Certification Exam", issuer: "cPanel", date: "Dec 2024" },
                { name: "AWS re/Start Graduate", issuer: "AWS", date: "Jun 2018" },
                { name: "Microsoft Applied Skills: Get started with Azure management tasks", issuer: "Microsoft", date: "Nov 2025" },
                { name: "Microsoft Applied Skills: Secure storage for Azure Files and Azure Blob Storage", issuer: "Microsoft", date: "Nov 2025" },
                { name: "Microsoft Applied Skills: Get started with identities and access using Microsoft Entra", issuer: "Microsoft", date: "Oct 2025" }
            ];
            
            const certsGrid = document.querySelector('.certs-grid');
            certifications.forEach(cert => {
                const certCard = document.createElement('div');
                certCard.className = 'cert-card';
                certCard.innerHTML = `
                    <h3>${cert.name}</h3>
                    <p><strong>Issuer:</strong> ${cert.issuer}</p>
                    <p><strong>Date:</strong> ${cert.date}</p>
                `;
                certsGrid.appendChild(certCard);
            });
            
            // Populate gallery with technology-related images
            const galleryImages = [
                { url: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Cloud Computing Infrastructure" },
                { url: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Network Security" },
                { url: "https://images.unsplash.com/photo-1555949963-aa79dcee981c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w-1200&q=80", caption: "Data Center Operations" },
                { url: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Azure Cloud Services" },
                { url: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Cybersecurity" },
                { url: "https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "DevOps Pipeline" }
            ];
            
            const galleryGrid = document.querySelector('.gallery-grid');
            galleryImages.forEach(img => {
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                galleryItem.innerHTML = `
                    <img src="${img.url}" alt="${img.caption}">
                    <div class="gallery-caption">${img.caption}</div>
                `;
                galleryGrid.appendChild(galleryItem);
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
