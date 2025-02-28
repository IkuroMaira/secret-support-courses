<?php
// Gestionnaire de bibliothèque - Fichier PHP à corriger
// Ce fichier contient du code qui doit être réorganisé et amélioré

// Connexion à la base de données avec PDO (ne pas modifier cette partie)
$servername = "localhost";
$username = "utilisateur_bibliotheque";
$password = "mot_de_passe";
$dbname = "bibliotheque";

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Configuration pour que PDO lance des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configuration pour récupérer les résultats sous forme de tableaux associatifs
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "Connexion réussie"; // Décommentez pour tester la connexion
} catch(PDOException $e) {
    die("Échec de la connexion: " . $e->getMessage());
}

// Fonctions diverses mélangées (à réorganiser)

// Fonction pour supprimer un livre de la base de données
function delete_book($pdo, $id) {
    // TODO: Écrivez la requête SQL pour supprimer un livre par son ID
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "Livre supprimé avec succès!";
        return true;
    } catch(PDOException $e) {
        echo "Erreur lors de la suppression: " . $e->getMessage();
        return false;
    }
}

// Fonction pour récupérer tous les livres
function get_all_books($pdo) {
    // TODO: Écrivez la requête SQL pour récupérer tous les livres
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la récupération des livres: " . $e->getMessage();
        return [];
    }
}

// Fonction pour ajouter un nouveau livre
function add_new_book($pdo, $titre, $auteur, $annee, $isbn, $categorie) {
    // TODO: Écrivez la requête SQL pour ajouter un nouveau livre
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $auteur, $annee, $isbn, $categorie]);
        echo "Nouveau livre ajouté avec l'ID: " . $pdo->lastInsertId();
        return $pdo->lastInsertId();
    } catch(PDOException $e) {
        echo "Erreur lors de l'ajout: " . $e->getMessage();
        return false;
    }
}

// Fonction pour rechercher un livre par son ID
function find_book_by_id($pdo, $id) {
    // TODO: Écrivez la requête SQL pour trouver un livre par son ID
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch(PDOException $e) {
        echo "Erreur lors de la recherche: " . $e->getMessage();
        return null;
    }
}

// Fonction pour mettre à jour les informations d'un livre
function update_book_info($pdo, $id, $titre, $auteur, $annee, $isbn, $categorie, $disponible) {
    // TODO: Écrivez la requête SQL pour mettre à jour les informations d'un livre
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $auteur, $annee, $isbn, $categorie, $disponible, $id]);
        echo "Livre mis à jour avec succès!";
        return true;
    } catch(PDOException $e) {
        echo "Erreur lors de la mise à jour: " . $e->getMessage();
        return false;
    }
}

// Fonction pour rechercher des livres par titre ou auteur
function search_books($pdo, $searchTerm) {
    // TODO: Écrivez la requête SQL pour rechercher des livres par titre ou auteur (utilisez LIKE)
    $sql = ""; // À compléter

    try {
        $searchTerm = "%$searchTerm%"; // Ajoute des % pour rechercher n'importe où dans la chaîne
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors de la recherche: " . $e->getMessage();
        return [];
    }
}

// Fonction pour compter le nombre de livres par auteur
function count_books_by_author($pdo) {
    // TODO: Écrivez la requête SQL pour compter le nombre de livres par auteur (utilisez GROUP BY)
    $sql = ""; // À compléter

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch(PDOException $e) {
        echo "Erreur lors du comptage: " . $e->getMessage();
        return [];
    }
}

// Fonction pour récupérer le nombre total de livres dans la bibliothèque
function get_nombre_de_livres($pdo) {
    $sql = "SELECT COUNT(*) AS total FROM livres";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    } catch(PDOException $e) {
        echo "Erreur lors du comptage total: " . $e->getMessage();
        return 0;
    }
}

// Fonction pour marquer un livre comme non disponible
function mark_book_as_unavailable($pdo, $id) {
    $sql = "UPDATE livres SET disponible = 0 WHERE id = ?";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "Livre marqué comme non disponible!";
        return true;
    } catch(PDOException $e) {
        echo "Erreur lors du marquage: " . $e->getMessage();
        return false;
    }
}

// Fonction pour afficher les statistiques de la bibliothèque
function display_library_statistics($pdo) {
    try {
        $totalBooks = get_nombre_de_livres($pdo);
        echo "Nombre total de livres: $totalBooks <br>";

        // Afficher d'autres statistiques...
    } catch(PDOException $e) {
        echo "Erreur lors de l'affichage des statistiques: " . $e->getMessage();
    }
}

// Exemple d'utilisation des fonctions (pour démonstration)
// Décommentez pour tester

/*
// Récupérer tous les livres
$books = get_all_books($pdo);
foreach ($books as $book) {
    echo "Titre: " . $book['titre'] . ", Auteur: " . $book['auteur'] . "<br>";
}

// Ajouter un nouveau livre
add_new_book($pdo, "Harry Potter", "J.K. Rowling", 1997, "978-0747532699", "Fantasy");

// Rechercher un livre par son ID
$book = find_book_by_id($pdo, 1);
if ($book) {
    echo "Livre trouvé: " . $book['titre'] . "<br>";
} else {
    echo "Livre non trouvé.<br>";
}
*/

// Aucune fermeture de connexion explicite nécessaire avec PDO
// PHP ferme automatiquement la connexion à la fin du script
?>