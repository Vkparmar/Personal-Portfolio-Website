<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id=?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    die("Project not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['proj_desc']);
    $link = trim($_POST['link']);
    $category = trim($_POST['category']);

    $imagePath = $project['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $ext;
        $imagePath = '../uploads/' . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $stmt = $pdo->prepare("UPDATE projects SET title=?, proj_desc=?, link=?, category=?, image=? WHERE id=?");
    $stmt->execute([$title, $desc, $link, $category, $imagePath, $id]);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Project</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
/* 🌌 Animated Multi-Color Dark Gradient Form */
.project-form {
  max-width: 600px;
  margin: 2rem auto;
  padding: 30px;
  border-radius: 18px;
  background: linear-gradient(270deg, #0f2027, #203a43, #2c5364, #6a11cb, #2575fc, #ff6a00);
  background-size: 1200% 1200%;
  animation: gradientShift 15s ease infinite;
  backdrop-filter: blur(14px);
  box-shadow: 0 8px 32px rgba(0,0,0,0.7);
  display: flex;
  flex-direction: column;
  gap: 15px;
  border: 1px solid rgba(255,255,255,0.1);
  color: #fff;
}

/* Animate Background Gradient */
@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  25% { background-position: 50% 100%; }
  50% { background-position: 100% 50%; }
  75% { background-position: 50% 0%; }
  100% { background-position: 0% 50%; }
}

/* Inputs */
.project-form input,
.project-form textarea,
.project-form select {
  width: 100%;
  padding: 12px 15px;
  border-radius: 10px;
  border: none;
  outline: none;
  font-size: 15px;
  background: rgba(255,255,255,0.1);
  color: #fff;
  transition: all 0.3s ease;
}

.project-form input:focus,
.project-form textarea:focus,
.project-form select:focus {
  background: rgba(255,255,255,0.2);
  transform: scale(1.03);
  box-shadow: 0 0 12px rgba(0,255,200,0.6);
}

/* Labels */
.project-form label {
  font-weight: bold;
  color: #eee;
  margin-top: 5px;
  display: block;
}

/* Placeholder */
.project-form input::placeholder,
.project-form textarea::placeholder {
  color: #ccc;
}

/* Buttons */
.btn-primary {
  background: linear-gradient(90deg, #ff416c, #ff4b2b, #ff6a00, #f7971e);
  background-size: 300% 300%;
  border: none;
  padding: 12px;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.4s;
  color: #fff;
  animation: buttonShift 6s ease infinite;
}

.btn-primary:hover {
  transform: translateY(-3px) scale(1.03);
  box-shadow: 0 4px 16px rgba(255,100,100,0.6);
}

/* Button Gradient Animation */
@keyframes buttonShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

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
    <div class="nav-actions">
      <a href="../logout.php" class="btn-ghost">Logout</a>
    </div>
  </div>
</header>

<div class="container section">
  <section class="hero" style="padding:0;">
    <div class="container hero-grid">
      <div>
        <h1 class="hero-title">Edit <span>Project</span></h1>
      </div>
    </div>
  </section>

  <form method="post" enctype="multipart/form-data" class="project-form">
    <label>Title</label>
    <input type="text" name="title" value="<?php echo $project['title']; ?>" required>
    
    <label>Description</label>
    <textarea name="proj_desc" required><?php echo $project['proj_desc']; ?></textarea>
    
    <label>Link</label>
    <input type="text" name="link" value="<?php echo $project['link']; ?>">
    
    <label>Category</label>
    <select name="category">
        <option value="all" <?php if($project['category']=='all') echo 'selected'; ?>>All</option>
        <option value="frontend" <?php if($project['category']=='frontend') echo 'selected'; ?>>Frontend</option>
        <option value="pwa" <?php if($project['category']=='pwa') echo 'selected'; ?>>PWA</option>
        <option value="game" <?php if($project['category']=='game') echo 'selected'; ?>>Game</option>
    </select>
    
    <label>Image (optional)</label>
    <input type="file" name="image">

    <div style="margin-top: 1rem;">
      <button type="submit" class="btn-primary">Update Project</button>
      <a href="dashboard.php" class="btn-ghost">Back to Dashboard</a>
    </div>
  </form>
</div>
</body>
</html>
