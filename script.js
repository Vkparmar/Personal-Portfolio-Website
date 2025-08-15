// Variables & Initial Data 
const addBtn = document.getElementById('addProjectBtn');
const modal = document.getElementById('projectModal');
const closeModal = modal.querySelector('.modal-close');
const form = document.getElementById('projectForm');
const projectsGrid = document.getElementById('projectsGrid');
const noMsg = document.getElementById('noProjectsMsg');

const searchInput = document.getElementById('searchInput');
const filterSelect = document.getElementById('filterSelect');

let projects = JSON.parse(localStorage.getItem('projects')) || [];

// Rendering & Creating Project Cards 
// यह function projects को filter और search के हिसाब से दिखाएगा
function renderProjects() {
  projectsGrid.innerHTML = '';

  // search और filter के हिसाब से projects को filter करना
  const searchTerm = searchInput.value.toLowerCase();
  const filterValue = filterSelect.value;

  const filteredProjects = projects.filter(p => {
    const matchesSearch = p.title.toLowerCase().includes(searchTerm) || p.desc.toLowerCase().includes(searchTerm);
    const matchesFilter = filterValue === 'all' || (p.category && p.category === filterValue);

    return matchesSearch && matchesFilter;
  });

  if (filteredProjects.length === 0) {
    noMsg.style.display = 'block';
    return;
  }
  noMsg.style.display = 'none';

  filteredProjects.forEach((p, idx) => {
    const card = createProjectCard(p, idx);
    projectsGrid.appendChild(card);
  });
}

// createProjectCard function
function createProjectCard(p, idx) {
  const card = document.createElement('div');
  card.className = 'project-card';
  card.innerHTML = `
    ${p.image ? `<img src="${p.image}" alt="${p.title} Thumbnail" class="project-thumb">` : ''}
    <h4>${p.title}</h4>
    <p>${p.desc}</p>
    ${p.link ? `<button class="btn-outline"><a href="${p.link}" target="_blank" rel="noopener" style="text-decoration:none;">View</a></button>` : ''}
    <button class="btn-outline" style="margin-top:0.5rem">Delete</button>
  `;

  const deleteBtn = card.querySelector('button:last-of-type');
  deleteBtn.addEventListener('click', () => {
    deleteProject(idx);
  });

  card.style.animation = 'projectFadeIn 0.5s ease forwards';

  return card;
}

// Project Delete, Modal Open/Close, and Form Submit 
function deleteProject(index) {
  projects.splice(index, 1);
  localStorage.setItem('projects', JSON.stringify(projects));
  renderProjects();
}

function openModal() {
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden'; // prevent background scroll
  setTimeout(() => {
    form.querySelector('#projTitle').focus();
  }, 300);
}

function closeModalFunc() {
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = 'auto';
}

form.addEventListener('submit', e => {
  e.preventDefault();

  const title = document.getElementById('projTitle').value.trim();
  const link = document.getElementById('projLink').value.trim();
  const desc = document.getElementById('projDesc').value.trim();
  const category = document.getElementById('projCategory').value; // नया फील्ड
  const imageInput = document.getElementById('projImage');

  if (!title || !desc) {
    alert('Please fill in the required fields.');
    return;
  }

  function saveProject(imageDataUrl = '') {
    projects.push({ title, link, desc, image: imageDataUrl, category });
    localStorage.setItem('projects', JSON.stringify(projects));
    renderProjects();
    closeModalFunc();
    form.reset();
  }

  if (imageInput.files.length > 0) {
    const file = imageInput.files[0];
    const reader = new FileReader();

    reader.onload = function(event) {
      const imageDataUrl = event.target.result;
      saveProject(imageDataUrl);
    };

    reader.readAsDataURL(file);
  } else {
    saveProject();
  }
});

// Event Listeners & Initial Load 
addBtn.addEventListener('click', openModal);
closeModal.addEventListener('click', closeModalFunc);

modal.addEventListener('click', e => {
    if(e.target === modal) {
        closeModalFunc();
    }
});

document.addEventListener('keydown', e => {
   if(e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
       closeModalFunc();
   }

});

document.getElementById('year').textContent = new Date().getFullYear();

// Search input और filter select पर event listener लगाएं ताकि input बदलते ही renderProjects call हो
searchInput.addEventListener('input', renderProjects);
filterSelect.addEventListener('change', renderProjects);

renderProjects();

