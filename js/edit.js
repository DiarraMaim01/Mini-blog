 const form = document.getElementById("edit-form");
 const erreur = document.getElementById("edit-error");

 let csrfToken = '';

// Récupérer le token CSRF
async function getCsrfToken() {
    try {
        const response = await fetch('./api/csrf_token.php');
        const data = await response.json();
        if (data.ok) {
            csrfToken = data.token;
            document.querySelectorAll('input[name="csrf_token"]').forEach(input => {
                input.value = csrfToken;
            });
        }
    } catch (error) {
        console.error('Erreur CSRF:', error);
    }
}

// Appel au chargement
getCsrfToken();

async function chargerArticle() {
    // chargement de l'id de l'article a modifier depuis l'URL
 const id = new URLSearchParams(location.search).get('id');
 if (!id) {
    erreur.innerHTML = "Aucune id fournie par l'URL";
    return;
    }
    try {
        const res = await fetch(`./api/articles_edit.php?id=${encodeURIComponent(id)}`);
        const data = await res.json();

        // verification res et data

        if (!res.ok || !data.ok) throw new Error(data.error || "Erreur API");
        const a = data.article ;

        // pre-remplir le formulaire avec les données de l'article
        document.getElementById('id').value = a.id;
        document.getElementById('titre').value= a.titre;
         document.getElementById('contenu').value= a.contenu;

    } catch (e) {
        console.error(error);
        erreur.innerHTML = e.message || "Erreur inattendue";
    }
}

chargerArticle();

// gestion de la modification 
form.addEventListener('submit', async(e)=>{
    e.preventDefault();

    fd = new FormData(form) ;
    fd.append('csrf_token', csrfToken);

    try{
        const res = await fetch("./api/articles_edit.php", { 
            method :'POST' ,
            body : fd,
        });

        const data = await res.json();
        if (!res.ok || !data.ok) throw new Error(data.error || "Erreur édition");

        alert('✅ article mis à jour avec succès');

        //redirection 
       location.href ='index.html';

    }catch (e){
    erreur.textContent ="❌Erreur" + e.message;
    }

});