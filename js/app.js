const container = document.getElementById('articles');
const addForm   = document.getElementById('add-form');
const addError  = document.getElementById('add-error');

/* 1) Charger la liste */
async function chargerArticles() {
  if (!container) return; // ← page sans liste (ex: add.html)
  try {
    const res = await fetch('./api/articles.php');
    if (!res.ok) throw new Error('Erreur API : ' + res.status);

    const data = await res.json();
    if (!data.ok) throw new Error(data.error || 'Réponse API invalide');

    container.innerHTML = data.articles.map(a => `
      <div class="article-card" data-id="${a.id}">
        <h3 class="article-title">${escapeHTML(a.titre)}</h3>
        <p class="article-content">${escapeHTML(a.contenu)}</p>
        <button class="btn-danger" data-id="${a.id}">Supprimer</button>
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
    try {
      const res = await fetch('./api/articles_create.php', { method: 'POST', body: fd });
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
    const btn = e.target.closest('.btn-danger');
    if (!btn) return;

    const id = btn.dataset.id;
    if (!id) return;

    if (!confirm('Supprimer cet article ?')) return;

    try {
      const fd = new FormData();
      fd.append('id', id);

      const res = await fetch('./api/articles_delete.php', { method: 'POST', body: fd });
      const data = await res.json();

      if (!res.ok || !data.ok) throw new Error(data.error || 'Suppression impossible');

      await chargerArticles();
    } catch (err) {
      alert('❌ ' + err.message);
    }
  });

  /* 4) Premier chargement (uniquement sur index.html) */
  chargerArticles();
}
