<?php
// admin-dashboard.php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin.php');
    exit;
}

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Get admin user info
$admin_id = $_SESSION['admin_user_id'];
$admin_username = $_SESSION['admin_username'];

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Get statistics (you can add more queries as needed)
$stats = [];
if ($db) {
    try {
        // Example: Get total blog posts count
        // You'll need to adjust this based on your actual database structure
        $query = "SELECT COUNT(*) as total FROM posts WHERE status = 'published'";
        $stmt = $db->query($query);
        $stats['total_posts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
        
        // Add more statistics as needed...
        
    } catch(PDOException $e) {
        error_log("Stats error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tanaka Benson Munjanja</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #1abc9c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --gray: #7f8c8d;
            --sidebar-width: 250px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--primary);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            background-color: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 14px;
            opacity: 0.8;
        }
        
        .sidebar-nav ul {
            list-style: none;
            padding: 20px 0;
        }
        
        .sidebar-nav li {
            margin-bottom: 5px;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .sidebar-nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-nav a.active {
            background-color: var(--accent);
            border-left: 4px solid white;
        }
        
        .sidebar-nav i {
            width: 24px;
            margin-right: 10px;
            font-size: 18px;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        
        .top-bar {
            background-color: white;
            border-radius: 10px;
            padding: 15px 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title h1 {
            color: var(--primary);
            font-size: 24px;
        }
        
        .page-title p {
            color: var(--gray);
            font-size: 14px;
        }
        
        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .logout-btn:hover {
            background-color: #c0392b;
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }
        
        .card-icon.posts { background-color: #3498db; }
        .card-icon.views { background-color: #2ecc71; }
        .card-icon.comments { background-color: #9b59b6; }
        .card-icon.users { background-color: #e74c3c; }
        
        .card h3 {
            color: var(--gray);
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card-value {
            font-size: 32px;
            font-weight: bold;
            color: var(--primary);
            margin: 10px 0;
        }
        
        .card-trend {
            font-size: 14px;
            color: #2ecc71;
        }
        
        .card-trend.negative {
            color: #e74c3c;
        }
        
        /* Recent Activity */
        .recent-activity {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            color: var(--primary);
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent);
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--secondary);
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-content p {
            margin-bottom: 5px;
            color: var(--primary);
        }
        
        .activity-time {
            font-size: 12px;
            color: var(--gray);
        }
        
        /* Quick Actions */
        .quick-actions {
            margin-top: 30px;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .action-btn {
            background-color: white;
            border: 2px solid var(--light);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: var(--primary);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .action-btn:hover {
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.1);
        }
        
        .action-btn i {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--secondary);
        }
        
        .action-btn h4 {
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .action-btn p {
            font-size: 12px;
            color: var(--gray);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                font-size: 24px;
                color: var(--primary);
                cursor: pointer;
            }
        }
        
        .mobile-menu-btn {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>TBM Admin</h2>
            <p>Tanaka Benson Munjanja</p>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li><a href="admin-dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin-posts.php"><i class="fas fa-newspaper"></i> Blog Posts</a></li>
                <li><a href="admin-categories.php"><i class="fas fa-tags"></i> Categories</a></li>
                <li><a href="admin-comments.php"><i class="fas fa-comments"></i> Comments</a></li>
                <li><a href="admin-gallery.php"><i class="fas fa-images"></i> Gallery</a></li>
                <li><a href="admin-settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="admin-users.php"><i class="fas fa-users"></i> Users</a></li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($admin_username, 0, 1)); ?>
                </div>
                <div>
                    <div style="font-weight: bold;"><?php echo htmlspecialchars($admin_username); ?></div>
                    <div style="font-size: 12px; opacity: 0.8;">Administrator</div>
                </div>
            </div>
        </div>
    </aside>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="page-title">
                <h1>Dashboard</h1>
                <p>Welcome back, <?php echo htmlspecialchars($admin_username); ?>!</p>
            </div>
            
            <a href="?logout=1" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <div class="card-header">
                    <h3>Total Posts</h3>
                    <div class="card-icon posts">
                        <i class="fas fa-newspaper"></i>
                    </div>
                </div>
                <div class="card-value"><?php echo $stats['total_posts'] ?? '0'; ?></div>
                <div class="card-trend">+12% from last month</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Total Views</h3>
                    <div class="card-icon views">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="card-value">2,847</div>
                <div class="card-trend">+23% from last month</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Comments</h3>
                    <div class="card-icon comments">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="card-value">48</div>
                <div class="card-trend">+5 new today</div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3>Active Users</h3>
                    <div class="card-icon users">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="card-value">1</div>
                <div class="card-trend">You are online</div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2 class="section-title">Recent Activity</h2>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="activity-content">
                        <p>You logged in to the admin panel</p>
                        <div class="activity-time">Just now</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="activity-content">
                        <p>Post "Introduction to DevOps" was updated</p>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-comment"></i>
                    </div>
                    <div class="activity-content">
                        <p>New comment on "Azure Best Practices"</p>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="activity-content">
                        <p>New user registered on the website</p>
                        <div class="activity-time">Yesterday</div>
                    </div>
                </li>
            </ul>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2 class="section-title">Quick Actions</h2>
            <div class="action-buttons">
                <a href="admin-posts.php?action=create" class="action-btn">
                    <i class="fas fa-plus-circle"></i>
                    <h4>Create New Post</h4>
                    <p>Write a new blog article</p>
                </a>
                <a href="admin-gallery.php?action=upload" class="action-btn">
                    <i class="fas fa-upload"></i>
                    <h4>Upload Image</h4>
                    <p>Add to gallery</p>
                </a>
                <a href="admin-comments.php" class="action-btn">
                    <i class="fas fa-comment-dots"></i>
                    <h4>Moderate Comments</h4>
                    <p>Review new comments</p>
                </a>
                <a href="admin-settings.php" class="action-btn">
                    <i class="fas fa-cog"></i>
                    <h4>Site Settings</h4>
                    <p>Update configuration</p>
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.getElementById('mobileMenuBtn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuBtn.contains(event.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>