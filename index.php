<?php
// index.php
session_start();
require_once 'models/Blog.php';

// Initialize blog object if the models directory exists
try {
    if (file_exists('models/Blog.php')) {
        $blog = new Blog();
        $categories = $blog->getAllCategories();
        $recent_posts = $blog->getRecentPosts(5);
    } else {
        // Create dummy data if models don't exist yet
        $categories = [];
        $recent_posts = [];
        $blog = null;
    }
} catch (Exception $e) {
    // Handle error gracefully
    error_log("Blog initialization error: " . $e->getMessage());
    $categories = [];
    $recent_posts = [];
    $blog = null;
}

// Get current page from URL
$current_page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Handle blog page requests
if ($current_page === 'blog') {
    $posts = $blog ? $blog->getAllPosts(10) : [];
} elseif ($current_page === 'blog-post' && isset($_GET['slug']) && $blog) {
    $post = $blog->getPostBySlug($_GET['slug']);
    if ($post) {
        $blog->incrementViews($post['id']);
        $comments = $blog->getComments($post['id']);
    }
} elseif ($current_page === 'blog-category' && isset($_GET['category']) && $blog) {
    $posts = $blog->getPostsByCategory($_GET['category']);
    $current_category = $_GET['category'];
} elseif ($current_page === 'blog-search' && isset($_GET['q']) && $blog) {
    $search_results = $blog->searchPosts($_GET['q']);
    $search_query = $_GET['q'];
}
?>
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
        
        nav ul li a.active {
            color: var(--accent);
            font-weight: 600;
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
        
        /* Blog Styles */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .blog-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
        }
        
        .blog-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }
        
        .blog-content {
            padding: 1.5rem;
        }
        
        .blog-title {
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }
        
        .blog-meta {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
        }
        
        .blog-excerpt {
            color: #555;
            margin-bottom: 1rem;
        }
        
        .blog-categories {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .category-tag {
            background-color: var(--secondary);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            text-decoration: none;
        }
        
        .category-tag:hover {
            background-color: var(--primary);
        }
        
        .blog-sidebar {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
        }
        
        .sidebar-title {
            color: var(--primary);
            border-bottom: 2px solid var(--accent);
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .blog-post-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .blog-post-content h2, 
        .blog-post-content h3, 
        .blog-post-content h4 {
            color: var(--primary);
            margin: 1.5rem 0 1rem 0;
        }
        
        .blog-post-content p {
            margin-bottom: 1rem;
        }
        
        .blog-post-content ul, 
        .blog-post-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .comments-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }
        
        .comment {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .comment-author {
            font-weight: bold;
            color: var(--primary);
        }
        
        .comment-date {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .search-form {
            display: flex;
            margin-bottom: 2rem;
        }
        
        .search-input {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
        }
        
        .search-button {
            background-color: var(--secondary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        
        .search-button:hover {
            background-color: var(--primary);
        }
        
        /* Quick Links */
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .quick-link-card {
            flex: 1;
            min-width: 200px;
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            border-top: 4px solid var(--secondary);
        }
        
        .quick-link-card.accent {
            border-top-color: var(--accent);
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
            
            .quick-links {
                flex-direction: column;
            }
        }
        
        @media (max-width: 576px) {
            .hero {
                padding: 2rem 0;
            }
            
            .hero h1 {
                font-size: 1.6rem;
            }
            
            .skills-grid, .certs-grid, .edu-cards, .blog-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-info {
                flex-direction: column;
                gap: 1.5rem;
            }
            
            .hobbies {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="container header-container">
            <a href="?page=home" class="logo">TBM<span>.</span></a>
            <div class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </div>
            <nav id="mainNav">
                <ul>
                    <li><a href="?page=home" class="<?php echo $current_page == 'home' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="?page=skills" class="<?php echo $current_page == 'skills' ? 'active' : ''; ?>">Skills</a></li>
                    <li><a href="?page=experience" class="<?php echo $current_page == 'experience' ? 'active' : ''; ?>">Experience</a></li>
                    <li><a href="?page=certifications" class="<?php echo $current_page == 'certifications' ? 'active' : ''; ?>">Certifications</a></li>
                    <li><a href="?page=education" class="<?php echo $current_page == 'education' ? 'active' : ''; ?>">Education</a></li>
                    <li><a href="?page=blog" class="<?php echo $current_page == 'blog' ? 'active' : ''; ?>">Blog</a></li>
                    <li><a href="?page=gallery" class="<?php echo $current_page == 'gallery' ? 'active' : ''; ?>">Gallery</a></li>
                    <li><a href="?page=contact" class="<?php echo $current_page == 'contact' ? 'active' : ''; ?>">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        <?php if ($current_page === 'blog'): ?>
            <!-- Blog Page -->
            <div class="section">
                <h2 class="section-title">Blog</h2>
                <p>Thoughts on DevOps, Cloud Computing, Security, and Technology</p>
                
                <!-- Search Form -->
                <form method="GET" action="" class="search-form">
                    <input type="hidden" name="page" value="blog-search">
                    <input type="text" name="q" class="search-input" placeholder="Search blog posts..." value="<?php echo isset($search_query) ? htmlspecialchars($search_query) : ''; ?>">
                    <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
                </form>
                
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                    <!-- Main Content -->
                    <div>
                        <?php if (isset($search_results)): ?>
                            <h3>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h3>
                            <?php if (!empty($search_results)): ?>
                                <div class="blog-grid">
                                    <?php foreach ($search_results as $post): ?>
                                        <div class="blog-card">
                                            <?php if (!empty($post['featured_image'])): ?>
                                                <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-image">
                                            <?php endif; ?>
                                            <div class="blog-content">
                                                <h3 class="blog-title">
                                                    <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" style="color: var(--primary); text-decoration: none;">
                                                        <?php echo htmlspecialchars($post['title']); ?>
                                                    </a>
                                                </h3>
                                                <div class="blog-meta">
                                                    <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                                                    <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
                                                </div>
                                                <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                                <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" style="color: var(--secondary); font-weight: 600; text-decoration: none;">Read More →</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p>No posts found matching your search.</p>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="blog-grid">
                                <?php foreach ($posts as $post): ?>
                                    <div class="blog-card">
                                        <?php if (!empty($post['featured_image'])): ?>
                                            <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-image">
                                        <?php endif; ?>
                                        <div class="blog-content">
                                            <h3 class="blog-title">
                                                <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" style="color: var(--primary); text-decoration: none;">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h3>
                                            <div class="blog-meta">
                                                <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                                                <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
                                            </div>
                                            <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                            <?php if (!empty($post['categories'])): ?>
                                                <div class="blog-categories">
                                                    <?php 
                                                    $category_list = explode(', ', $post['categories']);
                                                    foreach ($category_list as $category): ?>
                                                        <a href="?page=blog-category&category=<?php echo urlencode(strtolower(str_replace(' ', '-', $category))); ?>" class="category-tag">
                                                            <?php echo htmlspecialchars($category); ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Sidebar -->
                    <div>
                        <div class="blog-sidebar">
                            <h3 class="sidebar-title">Categories</h3>
                            <ul style="list-style: none; padding: 0;">
                                <?php foreach ($categories as $category): ?>
                                    <li style="margin-bottom: 0.8rem;">
                                        <a href="?page=blog-category&category=<?php echo urlencode($category['slug']); ?>" 
                                           style="color: var(--primary); text-decoration: none; display: flex; justify-content: space-between;">
                                            <span><?php echo htmlspecialchars($category['name']); ?></span>
                                            <span style="background-color: var(--secondary); color: white; padding: 0.1rem 0.5rem; border-radius: 10px; font-size: 0.8rem;">
                                                <?php echo $category['post_count']; ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <div class="blog-sidebar">
                            <h3 class="sidebar-title">Recent Posts</h3>
                            <ul style="list-style: none; padding: 0;">
                                <?php foreach ($recent_posts as $recent_post): ?>
                                    <li style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                                        <a href="?page=blog-post&slug=<?php echo urlencode($recent_post['slug']); ?>" 
                                           style="color: var(--primary); text-decoration: none; font-weight: 600; display: block; margin-bottom: 0.3rem;">
                                            <?php echo htmlspecialchars($recent_post['title']); ?>
                                        </a>
                                        <span style="color: var(--gray); font-size: 0.9rem;">
                                            <?php echo date('M d, Y', strtotime($recent_post['created_at'])); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php elseif ($current_page === 'blog-post' && isset($post)): ?>
            <!-- Single Blog Post -->
            <div class="section">
                <article>
                    <h1 class="section-title" style="border-bottom: none; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($post['title']); ?></h1>
                    <div style="color: var(--gray); margin-bottom: 2rem; display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <span><i class="far fa-calendar"></i> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                        <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
                        <?php if (!empty($post['categories'])): ?>
                            <span><i class="fas fa-tags"></i> 
                                <?php 
                                $category_list = explode(', ', $post['categories']);
                                foreach ($category_list as $index => $category):
                                    echo htmlspecialchars($category);
                                    if ($index < count($category_list) - 1) echo ', ';
                                endforeach;
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($post['featured_image'])): ?>
                        <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="width: 100%; height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 2rem;">
                    <?php endif; ?>
                    
                    <div class="blog-post-content">
                        <?php echo $post['content']; ?>
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="comments-section">
                        <h3 class="section-title">Comments</h3>
                        
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <div class="comment-author"><?php echo htmlspecialchars($comment['author_name']); ?></div>
                                    <div class="comment-date"><?php echo date('F j, Y', strtotime($comment['created_at'])); ?></div>
                                    <p style="margin-top: 1rem;"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments yet. Be the first to comment!</p>
                        <?php endif; ?>
                    </div>
                </article>
            </div>
            
        <?php elseif ($current_page === 'blog-category' && isset($current_category)): ?>
            <!-- Category Page -->
            <div class="section">
                <h2 class="section-title">Category: <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $current_category))); ?></h2>
                
                <?php if (!empty($posts)): ?>
                    <div class="blog-grid">
                        <?php foreach ($posts as $post): ?>
                            <div class="blog-card">
                                <?php if (!empty($post['featured_image'])): ?>
                                    <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-image">
                                <?php endif; ?>
                                <div class="blog-content">
                                    <h3 class="blog-title">
                                        <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" style="color: var(--primary); text-decoration: none;">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h3>
                                    <div class="blog-meta">
                                        <span><i class="far fa-calendar"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
                                        <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> views</span>
                                    </div>
                                    <p class="blog-excerpt"><?php echo htmlspecialchars($post['excerpt']); ?></p>
                                    <a href="?page=blog-post&slug=<?php echo urlencode($post['slug']); ?>" style="color: var(--secondary); font-weight: 600; text-decoration: none;">Read More →</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No posts found in this category.</p>
                <?php endif; ?>
            </div>
            
        <?php else: ?>
            <!-- Original Content Pages -->
            <?php 
            // Include content based on page
            switch ($current_page) {
                case 'home':
                    includeContent('home');
                    break;
                case 'skills':
                    includeContent('skills');
                    break;
                case 'experience':
                    includeContent('experience');
                    break;
                case 'certifications':
                    includeContent('certifications');
                    break;
                case 'education':
                    includeContent('education');
                    break;
                case 'gallery':
                    includeContent('gallery');
                    break;
                case 'contact':
                    includeContent('contact');
                    break;
                default:
                    includeContent('home');
                    break;
            }
            ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <h3>Tanaka Benson Munjanja</h3>
            <p>DevOps Support Engineer / Systems Engineer</p>
            <div class="social-links">
                <a href="https://www.linkedin.com/in/tanaka-munjanja-a724001a1/" target="_blank"><i class="fab fa-linkedin"></i></a>
                <a href="https://github.com/Benson117" target="_blank"><i class="fab fa-github"></i></a>
                <a href="mailto:bensommunjanja@gmail.com"><i class="fas fa-envelope"></i></a>
            </div>
            <p class="copyright">© <?php echo date('Y'); ?> Tanaka Benson Munjanja. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navigation functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Menu toggle for mobile
            const menuToggle = document.getElementById('menuToggle');
            const mainNav = document.getElementById('mainNav');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    mainNav.classList.toggle('active');
                });
            }
            
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
            if (certsGrid) {
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
            }
            
            // Populate gallery
            const galleryImages = [
                { url: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Cloud Computing Infrastructure" },
                { url: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Network Security" },
                { url: "https://images.unsplash.com/photo-1555949963-aa79dcee981c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Data Center Operations" },
                { url: "https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "Azure Cloud Services" },
                { url: "https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80", caption: "DevOps Pipeline" }
            ];
            
            const galleryGrid = document.querySelector('.gallery-grid');
            if (galleryGrid) {
                galleryImages.forEach(img => {
                    const galleryItem = document.createElement('div');
                    galleryItem.className = 'gallery-item';
                    galleryItem.innerHTML = `
                        <img src="${img.url}" alt="${img.caption}">
                        <div class="gallery-caption">${img.caption}</div>
                    `;
                    galleryGrid.appendChild(galleryItem);
                });
            }
        });
    </script>
</body>
</html>
<?php
// Function to include page content
function includeContent($page) {
    switch ($page) {
        case 'home':
            ?>
            <section id="home">
                <div class="hero">
                    <h1>Tanaka Benson Munjanja</h1>
                    <h2>DevOps Support Engineer / Systems Engineer</h2>
                    <p>Expert in endpoint management, cloud computing, and incident management to ensure reliable system performance. Skilled in Microsoft 365, Azure, and Dynamics 365 CRM configuration and support, driving operational efficiency and security compliance.</p>
                    <div style="margin-top: 2rem;">
                        <a href="?page=contact" style="background-color: var(--accent); color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none; display: inline-block; margin-right: 1rem;">Contact Me</a>
                        <a href="?page=experience" style="background-color: transparent; color: white; padding: 0.8rem 2rem; border-radius: 5px; text-decoration: none; display: inline-block; border: 2px solid white;">View Experience</a>
                    </div>
                </div>
                
                <div class="section">
                    <h2 class="section-title">Professional Summary</h2>
                    <p>DevOps Support Engineer & Systems Engineer with expertise in endpoint management, cloud computing, and incident management to ensure reliable system performance. Skilled in Microsoft 365, Azure, and Dynamics 365 CRM configuration and support, driving operational efficiency and security compliance. Focused on leveraging technical and leadership skills to enhance infrastructure resilience and support scalable growth.</p>
                </div>
                
                <div class="section">
                    <h2 class="section-title">Quick Links</h2>
                    <div class="quick-links">
                        <div class="quick-link-card">
                            <h3 style="color: var(--primary); margin-bottom: 1rem;">
                                <i class="fas fa-code" style="color: var(--secondary); margin-right: 0.5rem;"></i> Technical Skills
                            </h3>
                            <p>Explore my technical expertise in cloud computing, administration, security compliance, and more.</p>
                            <a href="?page=skills" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Skills →</a>
                        </div>
                        
                        <div class="quick-link-card accent">
                            <h3 style="color: var(--primary); margin-bottom: 1rem;">
                                <i class="fas fa-briefcase" style="color: var(--secondary); margin-right: 0.5rem;"></i> Work Experience
                            </h3>
                            <p>Review my professional journey with companies like Blugrass Digital, Sompisi IT Solutions, and more.</p>
                            <a href="?page=experience" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Experience →</a>
                        </div>
                        
                        <div class="quick-link-card">
                            <h3 style="color: var(--primary); margin-bottom: 1rem;">
                                <i class="fas fa-certificate" style="color: var(--secondary); margin-right: 0.5rem;"></i> Certifications
                            </h3>
                            <p>Browse my professional certifications from Microsoft, Google, CompTIA, and other institutions.</p>
                            <a href="?page=certifications" style="color: var(--secondary); text-decoration: none; font-weight: 600; display: inline-block; margin-top: 1rem;">View Certifications →</a>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            break;
            
        case 'skills':
            ?>
            <section id="skills">
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
            <?php
            break;
            
        case 'experience':
            ?>
            <section id="experience">
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
            <?php
            break;
            
        case 'certifications':
            ?>
            <section id="certifications">
                <div class="section">
                    <h2 class="section-title">Certifications</h2>
                    <div class="certs-grid">
                        <!-- Certifications populated by JavaScript -->
                    </div>
                </div>
            </section>
            <?php
            break;
            
        case 'education':
            ?>
            <section id="education">
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
            <?php
            break;
            
        case 'gallery':
            ?>
            <section id="gallery">
                <div class="section">
                    <h2 class="section-title">Technology & Work Gallery</h2>
                    <p>Images related to my professional field, cloud computing, DevOps, and IT infrastructure.</p>
                    <div class="gallery-grid">
                        <!-- Gallery populated by JavaScript -->
                    </div>
                </div>
            </section>
            <?php
            break;
            
        case 'contact':
            ?>
            <section id="contact">
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
            <?php
            break;
    }
}
?>