<?php
/**
 * ======================================================
 * 📚 COURS: OPÉRATIONS CRUD EN SQL AVEC PHP
 * ======================================================
 *
 * Ce fichier contient des exemples et des explications sur:
 * - Les opérations CRUD (Create, Read, Update, Delete)
 * - Les requêtes SQL fondamentales
 * - L'utilisation de PDO pour se connecter à une base de données
 * - Les bonnes pratiques de nommage et de structuration
 */

// ======================================================
// 🔌 CONNEXION À LA BASE DE DONNÉES
// ======================================================

/**
 * Paramètres de connexion à la base de données
 * À adapter selon votre environnement
 */
$host = "localhost";
$dbname = "ma_base_de_donnees"; // Donner le nom qu'on le veut
$username = "root";
$password = "root"; // Valeur vide pour les Windows

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Configuration des options PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Lance des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourne les résultats sous forme de tableaux associatifs

    // echo "Connexion réussie à la base de données"; // Décommentez pour tester
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// ======================================================
// 🌐 COMPRENDRE LE CRUD
// ======================================================

/**
 * CRUD représente les 4 opérations fondamentales pour manipuler des données:
 *
 * - Create (Créer) ➕
 * - Read (Lire) 👁️
 * - Update (Mettre à jour) 🔄
 * - Delete (Supprimer) ❌
 */

// On va créer notre première table utilisateurs dans PHPMyAdmin
// De quoi on a besoin dans notre table utilisateurs ?
/*
- id numérique qui s'autoincrémente et qui est notre primary key
- nom de l'utilisateur texte non null
- email texte unique non null
- mot de passe texte non null
- date de l'inscription
*/

// Structure d'une table SQL typique (à exécuter dans PHPMyAdmin)
/*
CREATE TABLE utilisateurs (
    // TODO: à compléter
);
*/

// ======================================================
// ➕ CREATE (INSERT) - Ajouter des données
// ======================================================

// Ici on va determiner le SQL pour insérer notre premier utilisateur
/**
 * En SQL à compléter:
 *
 * INSERT INTO ...
 */

// En PHP avec PDO:
function ajouterUtilisateur($pdo, $nom, $email, $mot_de_passe) {
    // Hachage du mot de passe (toujours utiliser password_hash en production) pour ceux qui veulent hacher le mot de passe
//     $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $mot_de_passe_hash]);
        return $pdo->lastInsertId(); // Retourne l'ID de l'utilisateur inséré
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
        return false;
    }
}

// Exemple d'utilisation:
// $nouvel_id = ajouterUtilisateur($pdo, 'Jean Martin', 'jean@exemple.com', 'motdepasse123');
// echo "Nouvel utilisateur ajouté avec l'ID: " . $nouvel_id;

// ======================================================
// 👁️ READ (SELECT) - Lire des données
// ======================================================

// Insérer dans PHPMyAdmin ces données pour pratiquer
/*
-- Insertion des données de test pour les utilisateurs
INSERT INTO utilisateurs (nom, email, mot_de_passe, date_inscription) VALUES
    ('Dupont Marie', 'marie.dupont@email.com', '0612dfv345678', '2023-01-15 10:30:00'),
    ('Martin Thomas', 'thomas.martin@email.com', '072frge3456789', '2023-02-20 14:45:00'),
    ('Dubois Sophie', 'sophie.dubois@email.com', '0634fzefzef567890', '2023-03-10 09:15:00'),
    ('Bernard Lucas', 'lucas.bernard@email.com', '0745dvfbb678901', '2023-04-05 16:20:00'),
    ('Petit Emma', 'emma.petit@email.com', '06567zfzgr89012', '2023-05-12 11:00:00'),
    ('Robert Hugo', 'hugo.robert@email.com', '07678901efzge23', '2023-06-18 13:30:00'),
    ('Richard Chloé', 'chloe.richard@email.com', '06rgregeg78901234', '2023-07-23 15:45:00'),
    ('Moreau Nathan', 'nathan.moreau@email.com', '078aefzreg9012345', '2023-08-30 10:10:00'),
    ('Simon Léa', 'lea.simon@email.com', '069012kilug3456', '2023-09-14 12:25:00'),
    ('Laurent Gabriel', 'gabriel.laurent@email.com', '0701234qvqzgrg567', '2023-10-01 14:40:00'),
    ('Bussac Gwenaëlle', 'bussac.gwenaelle@email.com', '0701234qvqzgrg567', '2023-10-01 15:40:00');
*/

// Ici on va déterminer le SQL pour afficher les données de la table utilisateurs
/**
 * En SQL:
 *
 * -- Lire tous les utilisateurs :
 *
 * -- Lire un utilisateur spécifique
 *
 * -- Lire avec filtrage : où la date d'inscription est '2023-02-28' et ranger par ordre alphabétique
 */

// Fonction pour récupérer tous les utilisateurs
function obtenirTousLesUtilisateurs($pdo) {
    $sql = "SELECT ...";

    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la récupération : " . $e->getMessage();
        return [];
    }
}

// Fonction pour récupérer un utilisateur par son ID
function obtenirUtilisateurParId($pdo, $id) {
    $sql = "SELECT ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(); // Retourne false si aucun résultat
    } catch(PDOException $e) {
        echo "Erreur lors de la récupération : " . $e->getMessage();
        return false;
    }
}

// Fonction pour rechercher des utilisateurs avec filtrage
function rechercherUtilisateurs($pdo, $date_min, $ordre = 'ASC') {
    $sql = "SELECT ...

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date_min]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la recherche : " . $e->getMessage();
        return [];
    }
}

// Exemples d'utilisation:
// $tous_les_utilisateurs = obtenirTousLesUtilisateurs($pdo);
// $utilisateur = obtenirUtilisateurParId($pdo, 1);
// $utilisateurs_recents = rechercherUtilisateurs($pdo, '2023-01-01');

// ======================================================
// 🔄 UPDATE (UPDATE) - Mettre à jour des données
// ======================================================

// Ici on déterminer le SQL pour
/**
 * En SQL:
 *
 * -- Mettre à jour le champ de l'utilisateur avec l'id = 1
 * UPDATE ...
 *
 * -- Mettre à jour plusieurs champs (nom et email)
 * UPDATE ...
 * SET ...
 */

// Fonction pour mettre à jour l'email d'un utilisateur
function mettreAJourEmail($pdo, $id, $nouvel_email) {
    $sql = "UPDATE ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nouvel_email, $id]);
        return $stmt->rowCount(); // Nombre de lignes affectées
    } catch(PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}

// Fonction pour mettre à jour plusieurs champs d'un utilisateur
function mettreAJourUtilisateur($pdo, $id, $nom, $email) {
    $sql = "UPDATE ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $email, $id]);
        return $stmt->rowCount(); // Nombre de lignes affectées
    } catch(PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}

// Exemples d'utilisation:
// $resultat = mettreAJourEmail($pdo, 1, 'nouveau.email@exemple.com');
// $resultat = mettreAJourUtilisateur($pdo, 1, 'Marie Martin', 'marie.martin@exemple.com');

// ======================================================
// ❌ DELETE (DELETE) - Supprimer des données
// ======================================================

// Ici on va déterminer le SQL pour
/**
 * En SQL:
 *
 * -- Supprimer un utilisateur spécifique
 * DELETE ...
 *
 * -- Supprimer selon un critère selon la date d'inscription < '2022-01-01'
 * DELETE ...
 * WHERE ...;
 */

// Fonction pour supprimer un utilisateur par son ID
function supprimerUtilisateur($pdo, $id) {
    $sql = "DELETE ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount(); // Nombre de lignes affectées
    } catch(PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
        return false;
    }
}

// Fonction pour supprimer des utilisateurs selon une date
function supprimerUtilisateursAnciens($pdo, $date_limite) {
    $sql = "DELETE ...";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$date_limite]);
        return $stmt->rowCount(); // Nombre de lignes affectées
    } catch(PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
        return false;
    }
}

// Exemples d'utilisation:
// $resultat = supprimerUtilisateur($pdo, 1);
// $nombre_supprimes = supprimerUtilisateursAnciens($pdo, '2022-01-01');

// ======================================================
// 🔍 COMPOSANTS AVANCÉS D'UNE REQUÊTE SQL
// ======================================================

// 1. SELECT et FROM - Les fondamentaux 📊
/**
 * SELECT id, nom, email FROM utilisateurs;
 */

// 2. WHERE - Filtrer les résultats 🔎
/**
 * SELECT ... LIKE '%@example.com';
 */

// 3. Jointures (JOIN) - Relier les tables 🔗

// INNER JOIN - Ne garde que les correspondances
function obtenirPublicationsUtilisateurs($pdo) {
    $sql = "SELECT ...
            FROM ...
            INNER JOIN ... ON ...";

    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la requête : " . $e->getMessage();
        return [];
    }
}

// LEFT JOIN - Garde toutes les lignes de la première table
function obtenirUtilisateursAvecPublications($pdo) {
    $sql = "SELECT ...
            FROM ...
            LEFT JOIN ... ON ...";

    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la requête : " . $e->getMessage();
        return [];
    }
}

// 4. GROUP BY et fonctions d'agrégation 📊
function compterPublicationsParUtilisateur($pdo) {
    $sql = "SELECT utilisateur_id, COUNT(*) AS nombre_publications
            FROM ...
            GROUP BY ...";

    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors du comptage : " . $e->getMessage();
        return [];
    }
}

// 5. HAVING - Filtrer après regroupement 🔍
function obtenirPublicationsPopulaires($pdo, $min_likes = 3) {
    $sql = "SELECT publication_id, COUNT(*) AS nombre_likes
            FROM ...
            GROUP BY ...
            HAVING COUNT(*) >= ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$min_likes]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la requête : " . $e->getMessage();
        return [];
    }
}

// ======================================================
// 🚀 EXERCICES PRATIQUES
// ======================================================

/**
 * Mettre en place une base de données pour l'exercice:
 *
 -- Création de la table des catégories
 CREATE TABLE categories (
     id INT AUTO_INCREMENT PRIMARY KEY,
     nom VARCHAR(50) NOT NULL,
     description TEXT
 );

 -- Création de la table des utilisateurs
 CREATE TABLE utilisateurs (
   id INT AUTO_INCREMENT PRIMARY KEY,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) UNIQUE NOT NULL,
   telephone VARCHAR(15),
   date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP,
   nombre_emprunts INT DEFAULT 0
 );

 -- Création de la table des livres
 CREATE TABLE livres (
     id INT AUTO_INCREMENT PRIMARY KEY,
     titre VARCHAR(255) NOT NULL,
     auteur VARCHAR(100) NOT NULL,
     annee INT,
     isbn VARCHAR(20) UNIQUE,
     categorie_id INT,
     disponible BOOLEAN DEFAULT TRUE,
     date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     FOREIGN KEY (categorie_id) REFERENCES categories(id)
 );

 -- Création de la table des emprunts
 CREATE TABLE emprunts (
     id INT AUTO_INCREMENT PRIMARY KEY,
     utilisateur_id INT NOT NULL,
     livre_id INT NOT NULL,
     date_emprunt DATETIME DEFAULT CURRENT_TIMESTAMP,
     date_retour_prevue DATETIME,
     date_retour_effective DATETIME NULL,
     FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id),
     FOREIGN KEY (livre_id) REFERENCES livres(id)
 );

 -- Insertion des données de test pour les catégories
 INSERT INTO categories (nom, description) VALUES
     ('Roman', 'Œuvres de fiction racontant des histoires imaginaires'),
     ('Science-fiction', 'Œuvres basées sur des progrès scientifiques et technologiques imaginaires'),
     ('Fantasy', 'Œuvres mettant en scène des univers imaginaires avec des éléments magiques'),
     ('Biographie', 'Récits de la vie d''une personne écrite par une autre personne'),
     ('Histoire', 'Livres traitant d''événements historiques et de leur analyse'),
     ('Développement personnel', 'Livres visant l''amélioration de soi'),
     ('Informatique', 'Livres sur la programmation et les technologies informatiques'),
     ('Cuisine', 'Livres de recettes et techniques culinaires');

 -- Insertion des données de test pour les utilisateurs
 INSERT INTO utilisateurs (nom, prenom, email, telephone, date_inscription) VALUES
     ('Dupont', 'Marie', 'marie.dupont@email.com', '0612345678', '2023-01-15 10:30:00'),
     ('Martin', 'Thomas', 'thomas.martin@email.com', '0723456789', '2023-02-20 14:45:00'),
     ('Dubois', 'Sophie', 'sophie.dubois@email.com', '0634567890', '2023-03-10 09:15:00'),
     ('Bernard', 'Lucas', 'lucas.bernard@email.com', '0745678901', '2023-04-05 16:20:00'),
     ('Petit', 'Emma', 'emma.petit@email.com', '0656789012', '2023-05-12 11:00:00'),
     ('Robert', 'Hugo', 'hugo.robert@email.com', '0767890123', '2023-06-18 13:30:00'),
     ('Richard', 'Chloé', 'chloe.richard@email.com', '0678901234', '2023-07-23 15:45:00'),
     ('Moreau', 'Nathan', 'nathan.moreau@email.com', '0789012345', '2023-08-30 10:10:00'),
     ('Simon', 'Léa', 'lea.simon@email.com', '0690123456', '2023-09-14 12:25:00'),
     ('Laurent', 'Gabriel', 'gabriel.laurent@email.com', '0701234567', '2023-10-01 14:40:00');

 -- Insertion des données de test pour les livres
 INSERT INTO livres (titre, auteur, annee, isbn, categorie_id, disponible) VALUES
     ('Le Petit Prince', 'Antoine de Saint-Exupéry', 1943, '978-2070612758', 1, TRUE),
     ('1984', 'George Orwell', 1949, '978-2070368228', 2, TRUE),
     ('Harry Potter à l''école des sorciers', 'J.K. Rowling', 1997, '978-2070643028', 3, FALSE),
     ('L''Alchimiste', 'Paulo Coelho', 1988, '978-2290004448', 1, TRUE),
     ('Dune', 'Frank Herbert', 1965, '978-2266233415', 2, TRUE),
     ('Le Seigneur des Anneaux', 'J.R.R. Tolkien', 1954, '978-2267011258', 3, FALSE),
     ('Steve Jobs', 'Walter Isaacson', 2011, '978-2709638326', 4, TRUE),
     ('Sapiens : Une brève histoire de l''humanité', 'Yuval Noah Harari', 2015, '978-2226257734', 5, TRUE),
     ('L''Art de la Simplicité', 'Dominique Loreau', 2005, '978-2501084444', 6, TRUE),
     ('Clean Code', 'Robert C. Martin', 2008, '978-0132350884', 7, FALSE),
     ('Le Guide du Routard - Paris', 'Collectif', 2023, '978-2016281900', 5, TRUE),
     ('Harry Potter et la Chambre des Secrets', 'J.K. Rowling', 1998, '978-2070625178', 3, TRUE),
     ('Les Misérables', 'Victor Hugo', 1862, '978-2253096337', 1, TRUE),
     ('La Cuisine pour les Nuls', 'Bryan Miller', 2006, '978-2754000895', 8, FALSE),
     ('Le Meilleur des Mondes', 'Aldous Huxley', 1932, '978-2266283038', 2, TRUE),
     ('Les Fourmis', 'Bernard Werber', 1991, '978-2253063339', 2, TRUE),
     ('La Ferme des Animaux', 'George Orwell', 1945, '978-2072903073', 1, TRUE),
     ('Le Hobbit', 'J.R.R. Tolkien', 1937, '978-2267023305', 3, TRUE),
     ('Apprendre PHP, MySQL et JavaScript', 'Robin Nixon', 2018, '978-2412034361', 7, FALSE),
     ('Le Grand Livre de la Boulangerie', 'Jean-Marie Lanio', 2017, '978-2841239771', 8, TRUE);

 -- Insertion des données de test pour les emprunts
 INSERT INTO emprunts (utilisateur_id, livre_id, date_emprunt, date_retour_prevue, date_retour_effective) VALUES
      (1, 3, '2023-11-05 10:15:00', '2023-11-19 10:15:00', NULL),
      (2, 6, '2023-11-06 14:30:00', '2023-11-20 14:30:00', NULL),
      (3, 10, '2023-11-07 11:45:00', '2023-11-21 11:45:00', NULL),
      (4, 14, '2023-11-08 16:00:00', '2023-11-22 16:00:00', NULL),
      (5, 19, '2023-11-09 09:30:00', '2023-11-23 09:30:00', NULL),
      (6, 3, '2023-10-10 13:45:00', '2023-10-24 13:45:00', '2023-10-23 15:30:00'),
      (7, 6, '2023-10-15 15:15:00', '2023-10-29 15:15:00', '2023-10-28 11:20:00'),
      (8, 10, '2023-10-20 10:30:00', '2023-11-03 10:30:00', '2023-11-05 14:10:00'),
      (9, 14, '2023-10-25 12:00:00', '2023-11-08 12:00:00', '2023-11-06 16:45:00'),
      (10, 19, '2023-10-30 14:15:00', '2023-11-13 14:15:00', '2023-11-12 09:30:00'),
      (1, 1, '2023-10-01 09:00:00', '2023-10-15 09:00:00', '2023-10-14 10:20:00'),
      (3, 5, '2023-10-03 11:30:00', '2023-10-17 11:30:00', '2023-10-16 14:15:00'),
      (5, 9, '2023-10-05 14:45:00', '2023-10-19 14:45:00', '2023-10-18 16:30:00'),
      (7, 13, '2023-10-07 16:15:00', '2023-10-21 16:15:00', '2023-10-20 11:45:00'),
      (9, 17, '2023-10-09 10:45:00', '2023-10-23 10:45:00', '2023-10-22 15:00:00');

 */

/**
 * Exercice 1: SQL - Requêtes pratiques 📝
 *
 * 1. Trouver l'utilisateur qui a posté le plus de publications:
 * // À compléter pendant le cours
 *
 * 2. Trouver les publications qui ont reçu au moins 2 commentaires:
 * // À compléter pendant le cours
 *
 * 3. Trouver les utilisateurs ayant commenté au moins 3 fois:
 * // À compléter pendant le cours
 */

/**
 * Implémentez ces requêtes SQL en PHP avec PDO ci-dessous:
 */

// 1. Trouver l'utilisateur qui a posté le plus de publications
function trouverUtilisateurPlusActif($pdo) {
    // À compléter pendant le cours
    $sql = "";

    try {
        $stmt = $pdo->query($sql);
        return $stmt->fetch();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}

// 2. Trouver les publications qui ont reçu au moins 2 commentaires
function trouverPublicationsPopulaires($pdo, $min_commentaires = 2) {
    // À compléter pendant le cours
    $sql = "";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$min_commentaires]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

// 3. Trouver les utilisateurs ayant commenté au moins 3 fois
function trouverUtilisateursActifs($pdo, $min_commentaires = 3) {
    // À compléter pendant le cours
    $sql = "";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$min_commentaires]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

/**
 * ======================================================
 * 📝 RESSOURCES RECOMMANDÉES
 * ======================================================
 *
 * - Documentation PHP officielle: https://www.php.net/docs.php
 * - Documentation PDO: https://www.php.net/manual/fr/book.pdo.php
 * - SQL Tutorial (W3Schools): https://www.w3schools.com/sql/
 * - PHP The Right Way: https://phptherightway.com/
 */

// Fermeture de la connexion à la base de données (optionnel avec PDO)
// $pdo = null;
?>