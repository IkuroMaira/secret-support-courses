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

// Structure d'une table SQL typique (à exécuter dans PHPMyAdmin)
/*
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);
*/

// ======================================================
// ➕ CREATE (INSERT) - Ajouter des données
// ======================================================

/**
 * En SQL pur:
 *
 * INSERT INTO utilisateurs (nom, email, mot_de_passe)
 * VALUES ('Marie Dupont', 'marie@exemple.com', 'mot_de_passe_hash');
 */

// En PHP avec PDO:
function ajouterUtilisateur($pdo, $nom, $email, $mot_de_passe) {
    // Hachage du mot de passe (toujours utiliser password_hash en production)
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";

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

/**
 * En SQL pur:
 *
 * -- Lire tous les utilisateurs
 * SELECT * FROM utilisateurs;
 *
 * -- Lire un utilisateur spécifique
 * SELECT * FROM utilisateurs WHERE id = 1;
 *
 * -- Lire avec filtrage
 * SELECT nom, email FROM utilisateurs
 * WHERE date_inscription > '2023-01-01'
 * ORDER BY nom ASC;
 */

// Fonction pour récupérer tous les utilisateurs
function obtenirTousLesUtilisateurs($pdo) {
    $sql = "SELECT * FROM utilisateurs";

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
    $sql = "SELECT * FROM utilisateurs WHERE id = ?";

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
    $sql = "SELECT nom, email FROM utilisateurs
            WHERE date_inscription > ?
            ORDER BY nom $ordre";

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

/**
 * En SQL pur:
 *
 * -- Mettre à jour un champ
 * UPDATE utilisateurs
 * SET email = 'nouveau.email@exemple.com'
 * WHERE id = 1;
 *
 * -- Mettre à jour plusieurs champs
 * UPDATE utilisateurs
 * SET
 *     nom = 'Marie Martin',
 *     email = 'marie.martin@exemple.com'
 * WHERE id = 1;
 */

// Fonction pour mettre à jour l'email d'un utilisateur
function mettreAJourEmail($pdo, $id, $nouvel_email) {
    $sql = "UPDATE utilisateurs SET email = ? WHERE id = ?";

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
    $sql = "UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?";

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

/**
 * En SQL pur:
 *
 * -- Supprimer un utilisateur spécifique
 * DELETE FROM utilisateurs WHERE id = 1;
 *
 * -- Supprimer selon un critère
 * DELETE FROM utilisateurs
 * WHERE date_inscription < '2022-01-01';
 */

// Fonction pour supprimer un utilisateur par son ID
function supprimerUtilisateur($pdo, $id) {
    $sql = "DELETE FROM utilisateurs WHERE id = ?";

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
    $sql = "DELETE FROM utilisateurs WHERE date_inscription < ?";

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
 * SELECT nom, email FROM utilisateurs WHERE email LIKE '%@example.com';
 */

// 3. Jointures (JOIN) - Relier les tables 🔗

// INNER JOIN - Ne garde que les correspondances
function obtenirPublicationsUtilisateurs($pdo) {
    $sql = "SELECT utilisateurs.nom, publications.contenu
            FROM utilisateurs
            INNER JOIN publications ON utilisateurs.id = publications.utilisateur_id";

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
    $sql = "SELECT utilisateurs.nom, publications.contenu
            FROM utilisateurs
            LEFT JOIN publications ON utilisateurs.id = publications.utilisateur_id";

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
            FROM publications
            GROUP BY utilisateur_id";

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
            FROM likes
            GROUP BY publication_id
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
 * Exercice 1: SQL - Requêtes pratiques 📝
 *
 * 1. Trouver l'utilisateur qui a posté le plus de publications:
 * // À compléter pendant le cours
 * // SELECT utilisateur_id, COUNT(*) AS nombre_publications
 * // FROM publications
 * // GROUP BY utilisateur_id
 * // ORDER BY nombre_publications DESC
 * // LIMIT 1;
 *
 * 2. Trouver les publications qui ont reçu au moins 2 commentaires:
 * // À compléter pendant le cours
 * // SELECT publication_id, COUNT(*) AS nombre_commentaires
 * // FROM commentaires
 * // GROUP BY publication_id
 * // HAVING COUNT(*) >= 2;
 *
 * 3. Trouver les utilisateurs ayant commenté au moins 3 fois:
 * // À compléter pendant le cours
 * // SELECT utilisateur_id, COUNT(*) AS nombre_commentaires
 * // FROM commentaires
 * // GROUP BY utilisateur_id
 * // HAVING COUNT(*) >= 3;
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