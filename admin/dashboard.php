<?php
session_start();
require '../db.php';

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at ASC");
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.btn-ghost {
  padding: 12px;
  border-radius: 10px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  border: 1px solid #fff;
  transition: 0.3s;
}

.btn-ghost:hover {
  background: rgba(255,255,255,0.15);
  transform: translateY(-2px);
}
/* Table Container */
table {
    width: 100%;
    margin-top: 1.5rem;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0px 6px 20px rgba(0,0,0,0.1);
    animation: fadeIn 0.8s ease;
}

/* Table Header */
table th {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: #fff;
    padding: 14px;
    text-align: center;
    font-size: 15px;
    letter-spacing: 0.5px;
}


/* Table Rows */
table td {
    padding: 12px 2px;
    text-align: center;
    border-bottom: 1px solid #eee;
    font-size: 14px;
    color: #444;
    
}

.cols {
    display: flex;
    justify-content: space-evenly;
    align-items: center;
}

/* Row Hover Effect */
table tr {
    transition: background 0.3s ease, transform 0.2s ease;
    
}
table tr:hover {
    background: #f9f9ff;
    transform: scale(1.01);
}

/* Action Links -> Styled as Buttons */
table td a {
    text-decoration: none;
    padding: 6px 12px;
    margin: 0 6px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
}

table td a:first-child {
    background: #667eea;
    color: #fff;
    
}
table td a:first-child:hover {
    background: #4c5bd4;
}

table td a:last-child {
    background: #e53e3e;
    color: #fff;
}
table td a:last-child:hover {
    background: #c53030;
}


/* Fade-in Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>
</head>
<body>
<header class="site-header">
<div class="container nav-row">
    <div class="brand">
        <a href="#home" class="brand-link">
          <div class="logo">
            <div class="logo-top">
              <span class="logo-v">V</span>
              <span class="logo-ina">ina</span>
            </div>
            <div class="logo-sub">Web Developer</div>
          </div>
        </a>
    </div>
       <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
      
    <div class="nav-actions">
       <a href="../logout.php" class="btn-ghost">Logout</a>
    </div>
</div>
</header>

<section class="hero" style="padding:0;">
    <div class="container hero-grid">
        <div>
            <h1 class="hero-title" >Welcome to <span>My Projects</span></h1>
        </div>
    </div>
</section>

<div class="container section">
    <a href="add_project.php" class="btn-outline btn-animate">+ Add New Project</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php foreach($projects as $p): ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo $p['title']; ?></td>
            <td><?php echo ucfirst($p['category']); ?></td>
            <td class="cols">
                <a href="edit_project.php?id=<?php echo $p['id']; ?>">Edit</a>
                <a href="delete_project.php?id=<?php echo $p['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
