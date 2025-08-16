<?php
require 'db.php';

// Fetch all projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY id DESC");
$projects = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vina - Web Developer</title>

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Great+Vibes&family=Playfair+Display:wght@600;700&display=swap"
    rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
<!-- Header / Navigation -->
<header class="site-header">
    <div class="container nav-row">
        <div class="brand">
            <a href="index.php" class="brand-link">
                <div class="logo">
                    <div class="logo-top">
                        <span class="logo-v">V</span>
                        <span class="logo-ina">ina</span>
                    </div>
                    <div class="logo-sub">Web Developer</div>
                </div>
            </a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#skills">Skills</a></li>
                <li><a href="#projects">Projects</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- Hero Section -->
<section id="home" class="hero">
    <div class="container hero-grid">
        <div class="hero-left">
            <h1 class="hero-title">Hi I'm <span>Vina</span></h1>
            <b class="hero-title">Welcome to <span>My Portfolio</span></b>
            <p class="lead">I build responsive, accessible & modern web experiences using HTML, CSS, JavaScript, PHP and MySQL. Explore my projects, dynamically loaded from the database.</p>
            <br>
            <div class="hero-cta">
              <a href="#projects" class="btn-primary">View Projects</a>
              <a href="Veena_Resume.pdf" download class="cv-button btn-primary">Download CV</a>
              <a href="#contact" class="btn-ghost">Hire Me</a>
            </div>     
        </div>

        <div class="hero-right">
          <div class="profile-card" tabindex="0">
            <img src="profile.png" alt="Veena's Profile" srcset="" class="profile-img">
           <div class="profile-info">
            <h3>Vina</h3>
            <p>Web Developer</p>

            <div class="profile-links">
              <a href="https://github.com/Vkparmar" target="_blank" rel="noopener">GitHub</a>
              <a href="https://www.linkedin.com/in/parmar-vina-885a52211/" target="_blank" rel="noopener">LinkedIn</a>
            </div>

           </div>
          </div>
        </div>

    </div>
</section>
<!--HERO END-->

<!-- ABOUT -->
  <section id="about" class="section">
    <div class="container">
      <h2 class="section-title">About Me</h2>
      <br>
      <p>I am a passionate and self-motivated web developer who loves turning ideas into interactive and user-friendly
        websites. I have experience working with HTML, CSS, and JavaScript, and I enjoy building projects that improve
        my skills and solve real-world problems. My goal is to keep learning, stay creative, and deliver high-quality
        work.</p>
    </div>
  </section>
<!-- ABOUT END  -->

<!-- SKILLS -->
  <section id="skills" class="section alt">
    <div class="container">
      <h2 class="section-title">Skills</h2>
      <div class="skills-grid">
        <div class="skill">HTML5</div>
        <div class="skill">CSS3 / Grid / Flexbox</div>
        <div class="skill">JavaScript</div>
        <div class="skill">Responsive Design</div>
        <div class="skill">Git & GitHub</div>
        <div class="skill">Basic Node.js</div>
        <div class="skill">PHP</div>
        <div class="skill">MySQL</div>
        <div class="skill">Laravel</div>

      </div>
    </div>
  </section>
<!-- SKILLS END  -->


<!-- Projects Section -->
<section id="projects" class="section">
    <div class="container">
        <div class="header-row">
            <h2 class="section-title">Projects</h2>
            <div class="projects-controls">
                <input type="search" id="searchInput" placeholder="Search projects..." aria-label="Search projects">
                <select id="filterSelect" aria-label="Filter by">
                    <option value="all">All</option>
                    <option value="frontend">Frontend</option>
                    <option value="pwa">PWA</option>
                    <option value="game">Game</option>
                </select>
            </div>
        </div>

          <div class="container">
            <div class="projects-grid" id="projectsGrid" aria-live="polite">
                <?php if(count($projects) === 0): ?>
                 <p id="noProjectsMsg">No projects available.</p>
                <?php else: ?>
                <?php foreach($projects as $p): ?>
                   <div class="project-card" data-category="<?php echo $p['category']; ?>">
                        <?php if($p['image']): ?>
                            <img src="uploads/<?php echo $p['image']; ?>" alt="<?php echo $p['title']; ?> Thumbnail" class="project-thumb">
                        <?php endif; ?>
                        <h4><?php echo $p['title']; ?></h4>
                        <p><?php echo $p['proj_desc']; ?></p>
                        <?php if($p['link']): ?>
                            <button class="btn-outline">
                               <a href="<?php 
                                  echo $p['link'];  ?>" target="_blank" style="text-decoration:none;">View</a>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>  
        </div>
    </div>
</section>
<!-- PROJECTS END  -->

<!-- CONTACT -->
  <section id="contact" class="section alt" style='padding: 0;'>
    <div class="container" style='padding-top: 10px;'>
      <h2 class="section-title contact-title" >Contact</h2>
      <form id="contactForm" class="contact-form" >
        <div class="form-row" >
          <input type="text" placeholder="Your name" required>
          <input type="email" placeholder="Your email" required>
        </div>
        <textarea placeholder="Your message" rows="5" required></textarea>
        <div class="form-actions">
          <button type="submit" class="btn-primary">Send Message</button>
        </div>
      </form>
    </div>
  </section>
<!-- CONTACT END   -->

<!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <div>© <span id="year"></span> created by Vina. All rights reserved.</div>
    </div>
  </footer>
<!-- FOOTER END    -->

<script>
  document.getElementById('year').textContent = new Date().getFullYear();

// Client-side search & filter
const searchInput = document.getElementById('searchInput');
const filterSelect = document.getElementById('filterSelect');
const projectCards = Array.from(document.querySelectorAll('.project-card'));

function renderProjects() {
    const searchTerm = searchInput.value.toLowerCase();
    const filterValue = filterSelect.value;

    let visible = 0;

    projectCards.forEach(card => {
        const title = card.querySelector('h4').textContent.toLowerCase();
        const desc = card.querySelector('p').textContent.toLowerCase();
        const category = card.dataset.category || '';

        const matchesSearch = title.includes(searchTerm) || desc.includes(searchTerm);
        const matchesFilter = filterValue === 'all' || category === filterValue;

        if(matchesSearch && matchesFilter) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('noProjectsMsg').style.display = visible === 0 ? 'block' : 'none';
}

searchInput.addEventListener('input', renderProjects);
filterSelect.addEventListener('change', renderProjects);


//Contact Form
document.addEventListener("DOMContentLoaded", function () {
    const contactForm = document.getElementById("contactForm");

    contactForm.addEventListener("submit", function (e) {
        e.preventDefault(); // page reload रोकना

        // Form data लेना
        const name = contactForm.querySelector('input[type="text"]').value.trim();
        const email = contactForm.querySelector('input[type="email"]').value.trim();
        const message = contactForm.querySelector('textarea').value.trim();

        // Validation
        if (name === "" || email === "" || message === "") {
            alert("Please fill in all fields.");
            return;
        }

        // Email format check
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        // अभी सिर्फ console में print कर रहे हैं
        console.log("Name:", name);
        console.log("Email:", email);
        console.log("Message:", message);

        // Success message
        alert("Your message has been sent successfully!");

        // Form reset
        contactForm.reset();
    });
});

</script>
</body>
</html>
