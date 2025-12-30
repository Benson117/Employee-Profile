-- Create database
CREATE DATABASE portfolio_db;
USE portfolio_db;

-- Users table for blog (optional for admin)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt VARCHAR(500),
    author_id INT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    featured_image VARCHAR(500),
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Blog categories
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    description TEXT
);

-- Post-category relationship (many-to-many)
CREATE TABLE post_categories (
    post_id INT,
    category_id INT,
    PRIMARY KEY (post_id, category_id),
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Comments table
CREATE TABLE comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    post_id INT,
    author_name VARCHAR(100) NOT NULL,
    author_email VARCHAR(100),
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'spam') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES blog_posts(id) ON DELETE CASCADE
);

-- Insert default categories
INSERT INTO categories (name, slug, description) VALUES
('DevOps', 'devops', 'DevOps practices and tools'),
('Cloud Computing', 'cloud-computing', 'Azure, AWS, and other cloud platforms'),
('Security', 'security', 'Cybersecurity and compliance'),
('Career', 'career', 'Professional development'),
('Technology', 'technology', 'General technology topics');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, content, excerpt, status, featured_image) VALUES
('Getting Started with Azure DevOps', 'getting-started-with-azure-devops', '<h2>Introduction to Azure DevOps</h2><p>Azure DevOps provides developer services for teams to plan work, collaborate on code development, and build and deploy applications...</p>', 'A comprehensive guide to starting with Azure DevOps pipelines and CI/CD.', 'published', 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'),
('Best Practices for Cloud Security in 2024', 'cloud-security-best-practices-2024', '<h2>Securing Your Cloud Infrastructure</h2><p>With the increasing adoption of cloud services, security has become more critical than ever...</p>', 'Essential security practices for protecting your cloud environments.', 'published', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'),
('My Journey as a DevOps Engineer', 'devops-engineer-journey', '<h2>From IT Technician to DevOps</h2><p>My career transition from traditional IT support to DevOps engineering was challenging but rewarding...</p>', 'Sharing my personal journey and lessons learned in DevOps.', 'published', 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');

-- Associate posts with categories
INSERT INTO post_categories (post_id, category_id) VALUES
(1, 1), (1, 2),
(2, 2), (2, 3),
(3, 1), (3, 4);