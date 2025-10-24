# 📰 Mini-Blog - Application CRUD PHP/JavaScript

Application web de blog minimaliste développée avec PHP et JavaScript vanilla.

---

## 🚀 Fonctionnalités
- ✅ CRUD complet (Create, Read, Update, Delete)
- ✅ API RESTful maison
- ✅ Interface moderne et responsive
- ✅ Protection CSRF intégrée
- ✅ Validation côté client et serveur

---

## 🛠️ Technologies
- **Backend** : PHP 8+, MySQL, PDO
- **Frontend** : HTML5, CSS3, JavaScript ES6+
- **Sécurité** : Tokens CSRF, validation des données

---

## 📁 Structure
mini-blog/
├── 📄 index.html # Liste des articles
├── 📄 add.html # Ajout d'article
├── 📄 edit.html # Édition d'article
├── 🎨 css/style.css # Styles modernes
├──🧩 utils
├ ├──csrf.php 
| ├──functions.php 
│ └── db.php 
├── ⚡ js/
│ ├── app.js # Gestion principale
│ └── edit.js # Édition d'articles
└── 🔧 api/
├── articles.php # Lecture
├── articles_create.php # Création
├── articles_edit.php # Modification
├── articles_delete.php # Suppression
└── csrf_token.php # Sécurité CSRF

---


## ⚡ Installation rapide

1. **Base de données** :
```sql
CREATE DATABASE mini_blog;
USE mini_blog;
CREATE TABLE articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255),
  contenu TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


2. Configuration :
Éditer utils/db.php avec vos paramètres MySQL.

3 **Lancement**:

bash
php -S localhost:8000

---

##🔌 API Endpoints

GET /api/articles.php - Liste des articles

POST /api/articles_create.php - Créer un article

GET/POST /api/articles_edit.php - Lire/Modifier un article

POST /api/articles_delete.php - Supprimer un article

---

##🛡️ Sécurité

Tokens CSRF sur toutes les actions modifiantes

Validation des données côté serveur

Protection contre les injections SQL avec PDO

---

👩‍💻 Auteur
Maimouna DIARRA - Ingénieure logiciels & données

