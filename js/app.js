const container = document.getElementById('articles');
const addForm   = document.getElementById('add-form');
const addError  = document.getElementById('add-error');

let csrfToken = '';

// Fonction pour récupérer le token CSRF
async function getCsrfToken() {
    try {
        const response = await fetch('./api/csrf_token.php');
        const data = await response.json();
        if (data.ok) {
            csrfToken = data.token;
            // Injection du  token dans tous les formulaires
            document.querySelectorAll('input[name="csrf_token"]').forEach(input => {
                input.value = csrfToken;
            });
        }
    } catch (error) {
        console.error('Erreur CSRF:', error);
    }
}

// Appel au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('form')) {
        getCsrfToken();
    }
});

/* 1) Charger la liste */
async function chargerArticles() {
  if (!container) return; // ← page sans liste
  try {
    const res = await fetch('./api/articles.php');
    if (!res.ok) throw new Error('Erreur API : ' + res.status);

    const data = await res.json();
    if (!data.ok) throw new Error(data.error || 'Réponse API invalide');

    container.innerHTML = data.articles.map(a => `
      <div class="article-card" data-id="${a.id}">
        <h3 class="article-title">${escapeHTML(a.titre)}</h3>
        <p class="article-content">${escapeHTML(a.contenu)}</p>
        <div class="article-actions">
          <a href="edit.html?id=${a.id}" class="btn btn-secondary btn-edit">
            ✏️ Modifier
          </a>
          <button class="btn btn-danger btn-delete" data-id="${a.id}">
            🗑️ Supprimer
          </button>
        </div>
      </div>
    `).join('');

  } catch (e) {
    container.innerHTML = `<p class="error">❌ ${escapeHTML(e.message)}</p>`;
  }
}

function escapeHTML(str) {
  return String(str)
    .replaceAll('&','&amp;')
    .replaceAll('<','&lt;')
    .replaceAll('>','&gt;')
    .replaceAll('"','&quot;')
    .replaceAll("'",'&#039;');
}

/* 2) Ajouter un article (présent uniquement sur add.html) */
if (addForm) {
  addForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    addError && (addError.textContent = '');

    const fd = new FormData(addForm);
    fd.append('csrf_token', csrfToken); 
    try {
      const res = await fetch('./api/articles_create.php', { 
        method: 'POST',
        body: fd });

      const data = await res.json();

      if (!res.ok || !data.ok) throw new Error(data.error || 'Erreur lors de l’ajout');

      addForm.reset();
      // Redirection vers la liste après succès
      setTimeout(() => { window.location.href = 'index.html'; }, 700);

    } catch (err) {
      if (addError) addError.textContent = '❌ ' + err.message;
      else alert('❌ ' + err.message);
    }
  });
}

/* 3) Suppression : seulement si on est sur la page liste */
if (container) {
  container.addEventListener('click', async (e) => {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;

    const id = btn.dataset.id;
    if (!id) return;

    if (!confirm('Supprimer cet article ?')) return;

    try {
      const fd = new FormData();
      fd.append('id', id);
      fd.append('csrf_token', csrfToken);

      const res = await fetch('./api/articles_delete.php', {
         method: 'POST',
         body: fd });
         
      const data = await res.json();

      if (!res.ok || !data.ok) throw new Error(data.error || 'Suppression impossible');

      await chargerArticles();
    } catch (err) {
      alert('❌ ' + err.message);
    }
  });

  /* 4) Premier chargement */
  chargerArticles();
}