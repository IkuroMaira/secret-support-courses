## 🗄️ Partie 3: CRUD et SQL

Une requête SQL est une **commande** permettant de **récupérer, insérer, mettre à jour ou supprimer** des données dans une base de données. Elle suit une **structure logique** qui combine différentes instructions pour obtenir le résultat voulu.

Voici comment nous allons construire une requête SQL **pas à pas**, en utilisant notre base de données.

### Comprendre le CRUD 🌐

CRUD représente les 4 opérations fondamentales pour manipuler des données:

- **C**reate (Créer) ➕
- **R**ead (Lire) 👁️
- **U**pdate (Mettre à jour) 🔄
- **D**elete (Supprimer) ❌

### Structure d'une table SQL

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

```

### Create (INSERT) ➕

```sql
INSERT INTO utilisateurs (nom, email, mot_de_passe)
VALUES ('Marie Dupont', 'marie@exemple.com', 'mot_de_passe_hash');

```

### Read (SELECT) 👁️

```sql
-- Lire tous les utilisateurs
SELECT * FROM utilisateurs;

-- Lire un utilisateur spécifique
SELECT * FROM utilisateurs WHERE id = 1;

-- Lire avec filtrage
SELECT nom, email FROM utilisateurs
WHERE date_inscription > '2023-01-01'
ORDER BY nom ASC;

```

### Update (UPDATE) 🔄

```sql
-- Mettre à jour un champ
UPDATE utilisateurs
SET email = 'nouveau.email@exemple.com'
WHERE id = 1;

-- Mettre à jour plusieurs champs
UPDATE utilisateurs
SET
    nom = 'Marie Martin',
    email = 'marie.martin@exemple.com'
WHERE id = 1;

```

### Delete (DELETE) ❌

```sql
-- Supprimer un utilisateur spécifique
DELETE FROM utilisateurs WHERE id = 1;

-- Supprimer selon un critère
DELETE FROM utilisateurs
WHERE date_inscription < '2022-01-01';

```

### Composants avancés d'une requête SQL 🔍

### 1. SELECT et FROM - Les fondamentaux 📊

```sql
SELECT id, nom, email FROM utilisateurs;

```

### 2. WHERE - Filtrer les résultats 🔎

```sql
SELECT nom, email FROM utilisateurs WHERE email LIKE '%@example.com';

```

### 3. Jointures (JOIN) - Relier les tables 🔗

### INNER JOIN - Ne garde que les correspondances

```sql
SELECT utilisateurs.nom, publications.contenu
FROM utilisateurs
INNER JOIN publications ON utilisateurs.id = publications.utilisateur_id;

```

### LEFT JOIN - Garde toutes les lignes de la première table

```sql
SELECT utilisateurs.nom, publications.contenu
FROM utilisateurs
LEFT JOIN publications ON utilisateurs.id = publications.utilisateur_id;

```

### RIGHT JOIN - Garde toutes les lignes de la seconde table

```sql
SELECT utilisateurs.nom, publications.contenu
FROM utilisateurs
RIGHT JOIN publications ON utilisateurs.id = publications.utilisateur_id;

```

### 4. GROUP BY et fonctions d'agrégation 📊

```sql
SELECT utilisateur_id, COUNT(*) AS nombre_publications
FROM publications
GROUP BY utilisateur_id;

```

### 5. HAVING - Filtrer après regroupement 🔍

```sql
SELECT publication_id, COUNT(*) AS nombre_likes
FROM likes
GROUP BY publication_id
HAVING COUNT(*) >= 3;

```

## 🚀 Exercices Pratiques

### Exercice 1: Corriger les noms des fonctions 🖊️

```jsx
// AVANT:
function fn1(x) { return x * 2; }
function userData(id) { /* récupère les infos d'un utilisateur */ }
function CALC_SUM(arr) { /* calcule la somme d'un tableau */ }
function do_validation(form) { /* valide un formulaire */ }

// APRÈS:
function doubleValue(x) { return x * 2; }
function getUserData(id) { /* récupère les infos d'un utilisateur */ }
function calculateSum(arr) { /* calcule la somme d'un tableau */ }
function validateForm(form) { /* valide un formulaire */ }

```

### Exercice 2: SQL - Requêtes pratiques 📝

1. Trouver l'utilisateur qui a posté le plus de publications:

```sql
SELECT utilisateur_id, COUNT(*) AS nombre_publications
FROM publications
GROUP BY utilisateur_id
ORDER BY nombre_publications DESC;

```

1. Trouver les publications qui ont reçu au moins 2 commentaires:

```sql
SELECT publication_id, COUNT(*) AS nombre_commentaires
FROM commentaires
GROUP BY publication_id
HAVING COUNT(*) >= 2;

```

1. Trouver les utilisateurs ayant commenté au moins 3 fois:

```sql
SELECT utilisateur_id, COUNT(*) AS nombre_commentaires
FROM commentaires
GROUP BY utilisateur_id
HAVING COUNT(*) >= 3;

```

## 📝 Résumé des points importants

### SQL et CRUD

- **CRUD**: Create (INSERT), Read (SELECT), Update (UPDATE), Delete (DELETE)
- **SELECT, FROM**: Bases d'une requête
- **WHERE**: Filtre avant traitement
- **JOIN**: Relie les tables (INNER, LEFT, RIGHT)
- **GROUP BY**: Regroupe les résultats pour agrégation
- **HAVING**: Filtre après agrégation

## 📚 Ressources complémentaires

- [MDN Web Docs - JavaScript](https://developer.mozilla.org/fr/docs/Web/JavaScript)
- [PHP Documentation](https://www.php.net/manual/fr/)
- [W3Schools SQL Tutorial](https://www.w3schools.com/sql/)
- [Clean Code by Robert C. Martin](https://www.amazon.fr/Clean-Code-Handbook-Software-Craftsmanship/dp/0132350882)

## 💡 Exercice à faire chez vous

Créez un petit script JavaScript qui:

1. Définit une fonction pour valider un email (comme dans l'exemple)
2. Définit une fonction pour valider un mot de passe (au moins 8 caractères, une majuscule, un chiffre)
3. Utilise ces fonctions pour vérifier un formulaire d'inscription

N'hésitez pas à me poser des questions lors de notre prochaine session! Bon développement! 🚀