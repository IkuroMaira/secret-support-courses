# 🎯 Exercice pratique : Gestionnaire de bibliothèque

## 📚 Contexte

Vous êtes en train de développer une petite application web pour gérer les livres d'une bibliothèque. L'application doit permettre d'ajouter, consulter, modifier et supprimer des livres (opérations CRUD) dans une base de données.

## 🧩 Objectifs de l'exercice

1. Structurer correctement le code JavaScript
2. Nommer correctement les fonctions
3. Implémenter les opérations CRUD en SQL
4. Comprendre comment organiser son code selon les responsabilités

## 📋 Voici l'exercice :

## 📋 Instructions pour l'exercice

### 🎯 Objectif

Corrigez le fichier "Gestionnaire de bibliothèque" en réorganisant le code selon les bonnes pratiques et en complétant les requêtes SQL pour les opérations CRUD.

### 🛠️ Étapes à suivre

1. **Réorganisez le code** :
    - Regroupez les fonctions par catégorie (CRUD : Create, Read, Update, Delete)
    - Ajoutez des commentaires pour séparer les sections
    - Structurez le code de manière logique
2. **Corrigez les noms des fonctions** :
    - Utilisez la convention camelCase (ex: `getNombreDelivres()` au lieu de `get_nombre_de_livres()`)
    - Utilisez des noms descriptifs qui expliquent ce que fait la fonction
    - Commencez par un verbe d'action approprié (get, add, update, delete, search...)
3. **Complétez les requêtes SQL manquantes** :
    - Suivez les instructions dans les commentaires
    - Assurez-vous que vos requêtes suivent les bonnes pratiques SQL
    - N'oubliez pas les clauses WHERE pour les opérations de mise à jour et de suppression

### 📝 Requêtes SQL à compléter

1. **SELECT** (Read) : Récupérer tous les livres
2. **INSERT** (Create) : Ajouter un nouveau livre
3. **UPDATE** (Update) : Mettre à jour les informations d'un livre
4. **SELECT avec WHERE** (Read) : Trouver un livre par son ID
5. **DELETE** (Delete) : Supprimer un livre
6. **SELECT avec LIKE** (Read) : Rechercher des livres par titre ou auteur
7. **SELECT avec GROUP BY** (Read) : Compter le nombre de livres par auteur

## 🔍 Exemple de structure de table

Pour vous aider, voici la structure de la table `livres` dans la base de données :

```sql
CREATE TABLE livres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(100) NOT NULL,
    annee INT,
    isbn VARCHAR(20) UNIQUE,
    categorie VARCHAR(50),
    disponible BOOLEAN DEFAULT TRUE,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

```

## 💡 Conseils pour réussir l'exercice

- **Pour la structure du code** : pensez à l'organisation logique. Regroupez les fonctions qui ont un rôle similaire.
- **Pour le nommage des fonctions** :
    - Les fonctions de lecture commencent souvent par `get` ou `find`
    - Les fonctions de création par `create` ou `add`
    - Les fonctions de mise à jour par `update`
    - Les fonctions de suppression par `delete` ou `remove`
- **Pour les requêtes SQL** :
    - N'oubliez pas d'utiliser des paramètres (`?`) pour éviter les injections SQL
    - Vérifiez que vos clauses WHERE ciblent correctement les enregistrements

## 🎮 Pour aller plus loin

Après avoir terminé cet exercice, essayez d'étendre le projet en ajoutant :

- Une fonction qui liste les livres non disponibles
- Une fonction qui calcule l'âge moyen des livres
- Une structure permettant de gérer les emprunts de livres

Bonne chance dans cet exercice ! 🚀