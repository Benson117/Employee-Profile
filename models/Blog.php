<?php
// models/Blog.php
require_once 'config/database.php';

class Blog {
    private $conn;
    private $table_posts = 'blog_posts';
    private $table_categories = 'categories';
    private $table_post_categories = 'post_categories';
    private $table_comments = 'comments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Get all published blog posts
    public function getAllPosts($limit = 10, $offset = 0) {
        $query = "SELECT p.*, 
                  GROUP_CONCAT(c.name SEPARATOR ', ') as categories
                  FROM " . $this->table_posts . " p
                  LEFT JOIN " . $this->table_post_categories . " pc ON p.id = pc.post_id
                  LEFT JOIN " . $this->table_categories . " c ON pc.category_id = c.id
                  WHERE p.status = 'published'
                  GROUP BY p.id
                  ORDER BY p.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Get single post by slug
    public function getPostBySlug($slug) {
        $query = "SELECT p.*, 
                  GROUP_CONCAT(c.name SEPARATOR ', ') as categories,
                  GROUP_CONCAT(c.id SEPARATOR ',') as category_ids
                  FROM " . $this->table_posts . " p
                  LEFT JOIN " . $this->table_post_categories . " pc ON p.id = pc.post_id
                  LEFT JOIN " . $this->table_categories . " c ON pc.category_id = c.id
                  WHERE p.slug = :slug AND p.status = 'published'
                  GROUP BY p.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Get post by ID
    public function getPostById($id) {
        $query = "SELECT p.*, 
                  GROUP_CONCAT(c.name SEPARATOR ', ') as categories,
                  GROUP_CONCAT(c.id SEPARATOR ',') as category_ids
                  FROM " . $this->table_posts . " p
                  LEFT JOIN " . $this->table_post_categories . " pc ON p.id = pc.post_id
                  LEFT JOIN " . $this->table_categories . " c ON pc.category_id = c.id
                  WHERE p.id = :id
                  GROUP BY p.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Get posts by category
    public function getPostsByCategory($category_slug, $limit = 10) {
        $query = "SELECT p.*, 
                  GROUP_CONCAT(c.name SEPARATOR ', ') as categories
                  FROM " . $this->table_posts . " p
                  INNER JOIN " . $this->table_post_categories . " pc ON p.id = pc.post_id
                  INNER JOIN " . $this->table_categories . " c ON pc.category_id = c.id
                  WHERE p.status = 'published' 
                  AND c.slug = :category_slug
                  GROUP BY p.id
                  ORDER BY p.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_slug', $category_slug);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Get all categories
    public function getAllCategories() {
        $query = "SELECT c.*, 
                  COUNT(pc.post_id) as post_count
                  FROM " . $this->table_categories . " c
                  LEFT JOIN " . $this->table_post_categories . " pc ON c.id = pc.category_id
                  LEFT JOIN " . $this->table_posts . " p ON pc.post_id = p.id AND p.status = 'published'
                  GROUP BY c.id
                  ORDER BY c.name ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Get recent posts
    public function getRecentPosts($limit = 5) {
        $query = "SELECT id, title, slug, excerpt, created_at 
                  FROM " . $this->table_posts . "
                  WHERE status = 'published'
                  ORDER BY created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Increment post views
    public function incrementViews($post_id) {
        $query = "UPDATE " . $this->table_posts . "
                  SET views = views + 1
                  WHERE id = :post_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Get comments for a post
    public function getComments($post_id) {
        $query = "SELECT * FROM " . $this->table_comments . "
                  WHERE post_id = :post_id AND status = 'approved'
                  ORDER BY created_at ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Add a comment
    public function addComment($post_id, $author_name, $author_email, $content) {
        $query = "INSERT INTO " . $this->table_comments . "
                  (post_id, author_name, author_email, content, status)
                  VALUES (:post_id, :author_name, :author_email, :content, 'pending')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':author_name', $author_name);
        $stmt->bindParam(':author_email', $author_email);
        $stmt->bindParam(':content', $content);
        
        return $stmt->execute();
    }

  
    // ADMIN FUNCTIONS
    
    // Get all posts for admin
    public function getAllPostsAdmin($limit = 50, $offset = 0) {
        $query = "SELECT p.*, 
                  GROUP_CONCAT(c.name SEPARATOR ', ') as categories
                  FROM " . $this->table_posts . " p
                  LEFT JOIN " . $this->table_post_categories . " pc ON p.id = pc.post_id
                  LEFT JOIN " . $this->table_categories . " c ON pc.category_id = c.id
                  GROUP BY p.id
                  ORDER BY p.created_at DESC
                  LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Create new post
    public function createPost($title, $slug, $content, $excerpt, $featured_image = '', $status = 'draft', $categories = []) {
        $query = "INSERT INTO " . $this->table_posts . "
                  (title, slug, content, excerpt, featured_image, status)
                  VALUES (:title, :slug, :content, :excerpt, :featured_image, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':excerpt', $excerpt);
        $stmt->bindParam(':featured_image', $featured_image);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            $post_id = $this->conn->lastInsertId();
            
            // Add categories
            if (!empty($categories)) {
                $this->addPostCategories($post_id, $categories);
            }
            
            return $post_id;
        }
        
        return false;
    }

    // Update post
    public function updatePost($id, $title, $slug, $content, $excerpt, $featured_image = '', $status = 'draft', $categories = []) {
        $query = "UPDATE " . $this->table_posts . "
                  SET title = :title,
                      slug = :slug,
                      content = :content,
                      excerpt = :excerpt,
                      featured_image = :featured_image,
                      status = :status,
                      updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':excerpt', $excerpt);
        $stmt->bindParam(':featured_image', $featured_image);
        $stmt->bindParam(':status', $status);
        
        if ($stmt->execute()) {
            // Remove existing categories
            $this->removePostCategories($id);
            
            // Add new categories
            if (!empty($categories)) {
                $this->addPostCategories($id, $categories);
            }
            
            return true;
        }
        
        return false;
    }

    // Delete post
    public function deletePost($id) {
        $query = "DELETE FROM " . $this->table_posts . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Add post categories
    private function addPostCategories($post_id, $category_ids) {
        $query = "INSERT INTO " . $this->table_post_categories . " (post_id, category_id) VALUES ";
        $values = [];
        
        foreach ($category_ids as $category_id) {
            $values[] = "(:post_id, :category_id_" . $category_id . ")";
        }
        
        $query .= implode(', ', $values);
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        
        foreach ($category_ids as $category_id) {
            $stmt->bindParam(':category_id_' . $category_id, $category_id, PDO::PARAM_INT);
        }
        
        return $stmt->execute();
    }

    // Remove post categories
    private function removePostCategories($post_id) {
        $query = "DELETE FROM " . $this->table_post_categories . " WHERE post_id = :post_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Get all comments for admin
    public function getAllComments($limit = 50) {
        $query = "SELECT c.*, p.title as post_title 
                  FROM " . $this->table_comments . " c
                  LEFT JOIN " . $this->table_posts . " p ON c.post_id = p.id
                  ORDER BY c.created_at DESC
                  LIMIT :limit";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Update comment status
    public function updateCommentStatus($id, $status) {
        $query = "UPDATE " . $this->table_comments . "
                  SET status = :status
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }

    // Delete comment
    public function deleteComment($id) {
        $query = "DELETE FROM " . $this->table_comments . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>