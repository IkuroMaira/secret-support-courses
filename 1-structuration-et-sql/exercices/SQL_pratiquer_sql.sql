-- Création de la base de données (si elle n'existe pas déjà)
CREATE DATABASE IF NOT EXISTS ma_base_de_donnees;

-- Utiliser la base de données
USE ma_base_de_donnees;

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des publications
CREATE TABLE IF NOT EXISTS publications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utilisateur_id INT NOT NULL,
        contenu TEXT NOT NULL,
        date_publication DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

-- Table des commentaires
CREATE TABLE IF NOT EXISTS commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    publication_id INT NOT NULL,
    contenu TEXT NOT NULL,
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (publication_id) REFERENCES publications(id) ON DELETE CASCADE
);

-- Table des likes
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    publication_id INT NOT NULL,
    date_like DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (publication_id) REFERENCES publications(id) ON DELETE CASCADE,
    UNIQUE KEY unique_like (utilisateur_id, publication_id)
);

-- Insertion d'utilisateurs
INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES
    ('Marie Dupont', 'marie@exemple.com', '$2y$10$HxUtLwvYDl.ZZtP9J4N2P.fRZIjhQuY.QFAg/CeUfLhbhXUHl42aK'), -- mot_de_passe = 'password123'
    ('Jean Martin', 'jean@exemple.com', '$2y$10$Ux6vYdBJ3NxPWnhJZDw0l.I.cT/LGqVs.TGl7S5OX7yvmxnXtrVHq'), -- mot_de_passe = 'secret456'
    ('Sophie Lefebvre', 'sophie@exemple.com', '$2y$10$I5E1o5jE64hJWz4c9E9K2eQpVj6xDCqC8vF3wN3WwHl1y4JK8OuNa'), -- mot_de_passe = 'secure789'
    ('Thomas Dubois', 'thomas@exemple.com', '$2y$10$c7NlH4hZ1.oXq.0B/OepXuJ9QnT1/E/YpZ3vQ2.KYmT5VJl2DMfvy'); -- mot_de_passe = 'mypass123'

-- Insertion de publications
INSERT INTO publications (utilisateur_id, contenu) VALUES
    (1, 'Bonjour tout le monde ! Ceci est ma première publication.'),
    (2, 'Je viens de commencer à apprendre PHP et MySQL, c''est passionnant !'),
    (3, 'Quelqu''un aurait-il des ressources sur les requêtes SQL avancées ?'),
    (1, 'J''adore travailler avec PDO en PHP, c''est tellement sécurisé !'),
    (2, 'Les jointures SQL sont vraiment puissantes pour lier des données.'),
    (4, 'Je cherche des exemples de projets pour pratiquer mes connaissances en SQL.'),
    (3, 'Voici un tutoriel intéressant que j''ai trouvé: [lien vers un tutoriel]'),
    (4, 'Comment optimiser les performances de vos requêtes SQL');

-- Insertion de commentaires
INSERT INTO commentaires (utilisateur_id, publication_id, contenu) VALUES
    (2, 1, 'Bienvenue dans la communauté !'),
    (3, 1, 'Ravi de te voir ici !'),
    (4, 2, 'Je suis aussi débutant, on pourrait échanger des astuces.'),
    (1, 3, 'Je te recommande la documentation officielle de MySQL.'),
    (2, 3, 'Tu peux aussi consulter le site W3Schools pour des exemples simples.'),
    (3, 5, 'Absolument ! Les jointures m''ont sauvé sur mon dernier projet.'),
    (1, 6, 'Tu pourrais créer un petit système de blog ou un gestionnaire de tâches.'),
    (2, 6, 'Ou une application de gestion de contacts, c''est simple mais complet.'),
    (3, 6, 'J''ai un projet open source sur GitHub si ça t''intéresse.'),
    (4, 7, 'Merci pour le partage !'),
    (1, 8, 'L''indexation est clé pour les performances.'),
    (2, 8, 'N''oublie pas aussi d''optimiser tes requêtes avec EXPLAIN.');

-- Insertion de likes
INSERT INTO likes (utilisateur_id, publication_id) VALUES
    (2, 1), (3, 1), (4, 1), -- 3 likes pour la publication 1
    (1, 2), (3, 2), -- 2 likes pour la publication 2
    (1, 3), (2, 3), (4, 3), -- 3 likes pour la publication 3
    (2, 4), -- 1 like pour la publication 4
    (1, 5), (3, 5), (4, 5), -- 3 likes pour la publication 5
    (1, 6), (2, 6), (3, 6), (4, 6), -- 4 likes pour la publication 6
    (1, 7), (2, 7), -- 2 likes pour la publication 7
    (1, 8), (2, 8), (3, 8), (4, 8); -- 4 likes pour la publication 8