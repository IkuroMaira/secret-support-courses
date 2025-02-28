-- Script SQL pour créer et remplir les tables d'exemple

-- Création de la table des utilisateurs
CREATE TABLE utilisateurs (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nom VARCHAR(50) NOT NULL,
      email VARCHAR(100) UNIQUE NOT NULL,
      mot_de_passe VARCHAR(255) NOT NULL,
      date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);


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