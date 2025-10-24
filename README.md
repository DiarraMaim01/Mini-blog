
---

# 📰 Mini-Blog — Application CRUD PHP / JavaScript

Une application web minimaliste de type **blog** permettant la création, la lecture, la modification et la suppression d’articles.
Développée avec **PHP (PDO/MySQL)** côté serveur et **JavaScript vanilla (Fetch API)** côté client.

---

## 🚀 Fonctionnalités

* ✅ CRUD complet (Create, Read, Update, Delete)
* ✅ API RESTful maison (endpoints JSON)
* ✅ Interface moderne et responsive
* ✅ Protection CSRF sur toutes les actions POST
* ✅ Validation des données côté client et serveur

---

## 🛠️ Technologies

* **Backend** : PHP 8+, MySQL, PDO
* **Frontend** : HTML5, CSS3, JavaScript ES6+
* **Sécurité** : jetons CSRF, validation côté serveur, PDO préparé

---

## 📁 Structure du projet

```
mini-blog/
├── 📄 index.html              # Liste des articles
├── 📄 add.html                # Ajout d’article
├── 📄 edit.html               # Édition d’article
│
├── 🎨 css/
│   └── style.css              # Styles modernes et responsive
│
├── ⚡ js/
│   ├── app.js                 # Gestion des articles (liste / ajout / suppression)
│   └── edit.js                # Gestion de l’édition via API
│
├── 🧩 utils/
│   ├── csrf.php               # Gestion des tokens CSRF
│   ├── functions.php          # Fonctions CRUD génériques (PDO)
│   └── db.php                 # Connexion PDO
│
└── 🔧 api/
    ├── articles.php           # Lecture (GET)
    ├── articles_create.php    # Création (POST)
    ├── articles_edit.php      # Modification (GET/POST)
    ├── articles_delete.php    # Suppression (POST)
    └── csrf_token.php         # Génération et vérification des jetons CSRF
```

---

## ⚡ Installation rapide

### 1. Créer la base de données MySQL

```sql
CREATE DATABASE mini_blog CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mini_blog;

CREATE TABLE articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  contenu TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 2. Configurer la connexion

Modifier `utils/db.php` avec vos identifiants MySQL :

```php
$host = 'localhost';
$dbname = 'mini_blog';
$user = 'root';
$pass = '';
```

### 3. Lancer le serveur local

```bash
php -S localhost:8000
```

Puis ouvrir : 👉 [http://localhost:8000/index.html](http://localhost:8000/index.html)

---

## 🔌 Endpoints de l’API

| Méthode      | URL                        | Description                       |
| ------------ | -------------------------- | --------------------------------- |
| `GET`        | `/api/articles.php`        | Liste tous les articles           |
| `POST`       | `/api/articles_create.php` | Ajoute un article                 |
| `GET`/`POST` | `/api/articles_edit.php`   | Récupère ou met à jour un article |
| `POST`       | `/api/articles_delete.php` | Supprime un article               |
| `GET`        | `/api/csrf_token.php`      | Récupère un jeton CSRF            |

Toutes les routes renvoient une réponse JSON de la forme :

```json
{ "ok": true, "articles": [...] }
```

---

## 🛡️ Sécurité

* 🔐 **Tokens CSRF** : générés et vérifiés côté serveur pour chaque requête POST
* 🧩 **Validation serveur** : vérification stricte des champs (`empty`, formats, etc.)
* 🧱 **PDO préparé** : protège contre les injections SQL
* 🧼 **Échappement XSS** : utilisation systématique de `htmlspecialchars()` côté affichage

---

## 👩‍💻 Auteur

**Maimouna Diarra**
Étudiante-ingénieure en Logiciels & Données — ESEO
💼 Passionnée par le développement web full-stack et la sécurité des applications.

---
