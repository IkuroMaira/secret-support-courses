-- Script SQL pour créer et remplir les tables d'exemple
-- pour le gestionnaire de bibliothèque

-- Supprimer les tables si elles existent déjà (optionnel)
DROP TABLE IF EXISTS emprunts;
DROP TABLE IF EXISTS livres;
DROP TABLE IF EXISTS utilisateurs;
DROP TABLE IF EXISTS categories;

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

-- Mise à jour du statut des livres empruntés
UPDATE livres SET disponible = FALSE WHERE id IN (3, 6, 10, 14, 19);

-- Mise à jour du nombre d'emprunts pour chaque utilisateur
UPDATE utilisateurs SET nombre_emprunts = 2 WHERE id = 1;
UPDATE utilisateurs SET nombre_emprunts = 1 WHERE id = 2;
UPDATE utilisateurs SET nombre_emprunts = 2 WHERE id = 3;
UPDATE utilisateurs SET nombre_emprunts = 1 WHERE id = 4;
UPDATE utilisateurs SET nombre_emprunts = 2 WHERE id = 5;
UPDATE utilisateurs SET nombre_emprunts = 1 WHERE id = 6;
UPDATE utilisateurs SET nombre_emprunts = 2 WHERE id = 7;
UPDATE utilisateurs SET nombre_emprunts = 1 WHERE id = 8;
UPDATE utilisateurs SET nombre_emprunts = 2 WHERE id = 9;
UPDATE utilisateurs SET nombre_emprunts = 1 WHERE id = 10;