<?php
// comments.php
session_start();
require_once 'models/Blog.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $author_name = $_POST['author_name'] ?? '';
    $author_email = $_POST['author_email'] ?? '';
    $content = $_POST['content'] ?? '';
    
    if ($post_id && $author_name && $author_email && $content) {
        $blog = new Blog();
        $success = $blog->addComment($post_id, $author_name, $author_email, $content);
        
        if ($success) {
            $_SESSION['message'] = 'Thank you for your comment! It will be reviewed before appearing.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'There was an error submitting your comment. Please try again.';
            $_SESSION['message_type'] = 'error';
        }
        
        // Get post slug to redirect back to it
        $post = $blog->getPostById($post_id);
        if ($post) {
            header('Location: index.php?page=blog-post&slug=' . urlencode($post['slug']));
        } else {
            header('Location: index.php?page=blog');
        }
        exit();
    }
}

// If not a POST request, redirect to blog
header('Location: index.php?page=blog');
exit();
?>