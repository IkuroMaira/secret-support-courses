-- ======================================================
-- 🔰 NIVEAU DÉBUTANT - Requêtes simples
-- ======================================================

-- 📚 EXERCICE 1: SELECT - Afficher tous les utilisateurs
-- Affiche tous les utilisateurs enregistrés dans la base de données
SELECT * FROM utilisateurs;

-- 📚 EXERCICE 2: SELECT avec WHERE - Trouver un utilisateur par email
-- Trouve l'utilisateur dont l'email est 'marie@exemple.com'
SELECT * FROM utilisateurs WHERE email = 'marie@exemple.com';

-- 📚 EXERCICE 3: INSERT - Ajouter un nouvel utilisateur
-- Ajoute un nouvel utilisateur avec les informations spécifiées
INSERT INTO utilisateurs (nom, email, mot_de_passe)
VALUES ('Alex Moreau', 'alex@exemple.com', '$2y$10$abcdefghijklmnopqrstuv');

-- 📚 EXERCICE 4: UPDATE - Mettre à jour un utilisateur
-- Modifie le nom d'un utilisateur avec l'ID 3
UPDATE utilisateurs
SET nom = 'Sophie Martin'
WHERE id = 3;

-- 📚 EXERCICE 5: DELETE - Supprimer un utilisateur
-- Supprime l'utilisateur avec l'ID 5 (sera l'utilisateur Alex que vous venez d'ajouter)
DELETE FROM utilisateurs
WHERE id = 5;

-- ======================================================
-- 🔰 NIVEAU INTERMÉDIAIRE - Requêtes avec JOIN et GROUP BY
-- ======================================================

-- 📚 EXERCICE 6: INNER JOIN - Afficher les publications avec leur auteur
-- Affiche toutes les publications avec le nom de leur auteur
SELECT p.id, p.contenu, p.date_publication, u.nom as auteur
FROM publications p
INNER JOIN utilisateurs u ON p.utilisateur_id = u.id;

-- 📚 EXERCICE 7: LEFT JOIN - Afficher tous les utilisateurs et leurs publications
-- Affiche tous les utilisateurs et leurs publications (même s'ils n'ont pas de publication)
SELECT u.nom, p.contenu
FROM utilisateurs u
LEFT JOIN publications p ON u.id = p.utilisateur_id;

-- 📚 EXERCICE 8: COUNT et GROUP BY - Compter les publications par utilisateur
-- Compte le nombre de publications pour chaque utilisateur
SELECT u.nom, COUNT(p.id) as nombre_publications
FROM utilisateurs u
LEFT JOIN publications p ON u.id = p.utilisateur_id
GROUP BY u.id;

-- 📚 EXERCICE 9: Trouver les publications les plus commentées
-- Affiche les publications avec le nombre de commentaires, triées par nombre de commentaires
SELECT p.id, p.contenu, COUNT(c.id) as nombre_commentaires
FROM publications p
LEFT JOIN commentaires c ON p.id = c.publication_id
GROUP BY p.id
ORDER BY nombre_commentaires DESC;

-- 📚 EXERCICE 10: Trouver les publications les plus aimées
-- Affiche les publications avec le nombre de likes, triées par nombre de likes
SELECT p.id, p.contenu, COUNT(l.id) as nombre_likes
FROM publications p
LEFT JOIN likes l ON p.id = l.publication_id
GROUP BY p.id
ORDER BY nombre_likes DESC;

-- ======================================================
-- 🔰 NIVEAU AVANCÉ - Requêtes complexes
-- ======================================================

-- 📚 EXERCICE 11: Requête avec sous-requête - Publications populaires
-- Trouve les publications qui ont plus de likes que la moyenne
SELECT p.id, p.contenu, COUNT(l.id) as nombre_likes
FROM publications p
         JOIN likes l ON p.id = l.publication_id
GROUP BY p.id
HAVING COUNT(l.id) > (
SELECT AVG(like_count)
FROM (
         SELECT COUNT(id) as like_count
         FROM likes
         GROUP BY publication_id
     ) as avg_likes
);

-- 📚 EXERCICE 12: Utilisateurs les plus actifs (combinant publications et commentaires)
-- Trouve les utilisateurs qui ont soit publié, soit commenté le plus
SELECT u.id, u.nom,
   (SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) as publications,
   (SELECT COUNT(*) FROM commentaires WHERE utilisateur_id = u.id) as commentaires,
   ((SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) +
    (SELECT COUNT(*) FROM commentaires WHERE utilisateur_id = u.id)) as total_activite
FROM utilisateurs u
ORDER BY total_activite DESC;

-- 📚 EXERCICE 13: Multi-jointures - Vue détaillée des commentaires
-- Affiche les détails des commentaires, y compris l'auteur du commentaire et la publication commentée
SELECT
    c.id as commentaire_id,
    c.contenu as commentaire,
    u_commentaire.nom as auteur_commentaire,
    p.contenu as publication,
    u_publication.nom as auteur_publication
FROM commentaires c
    JOIN utilisateurs u_commentaire ON c.utilisateur_id = u_commentaire.id
    JOIN publications p ON c.publication_id = p.id
    JOIN utilisateurs u_publication ON p.utilisateur_id = u_publication.id;

-- 📚 EXERCICE 14: Requête avec DATE - Activité récente
-- Trouve toutes les interactions (publications, commentaires, likes) des 7 derniers jours
-- Note: Comme nos données d'exemple ont toutes la même date, modifions d'abord quelques dates
UPDATE publications SET date_publication = DATE_SUB(NOW(), INTERVAL 5 DAY) WHERE id = 1;
UPDATE commentaires SET date_commentaire = DATE_SUB(NOW(), INTERVAL 3 DAY) WHERE id = 2;
UPDATE likes SET date_like = DATE_SUB(NOW(), INTERVAL 2 DAY) WHERE id = 3;

-- Maintenant la requête pour trouver l'activité récente
SELECT 'publication' as type, p.contenu as contenu, u.nom as utilisateur, p.date_publication as date
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id
WHERE p.date_publication >= DATE_SUB(NOW(), INTERVAL 7 DAY)

UNION ALL

SELECT 'commentaire' as type, c.contenu as contenu, u.nom as utilisateur, c.date_commentaire as date
FROM commentaires c
JOIN utilisateurs u ON c.utilisateur_id = u.id
WHERE c.date_commentaire >= DATE_SUB(NOW(), INTERVAL 7 DAY)

UNION ALL

SELECT 'like' as type, CONCAT('Like sur publication #', l.publication_id) as contenu, u.nom as utilisateur, l.date_like as date
FROM likes l
JOIN utilisateurs u ON l.utilisateur_id = u.id
WHERE l.date_like >= DATE_SUB(NOW(), INTERVAL 7 DAY)

ORDER BY date DESC;

-- ======================================================
-- 🏆 CHALLENGE - Requêtes très avancées
-- ======================================================

-- 📚 EXERCICE 15: Ranking des utilisateurs
-- Crée un classement des utilisateurs basé sur un score calculé
-- (publications × 10 + commentaires × 5 + likes reçus × 2)
SELECT
    u.id,
    u.nom,
    (SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) * 10 as score_publications,
    (SELECT COUNT(*) FROM commentaires WHERE utilisateur_id = u.id) * 5 as score_commentaires,
    (
        SELECT COALESCE(SUM(like_count), 0)
        FROM (
                 SELECT COUNT(l.id) as like_count
                 FROM publications p
                 LEFT JOIN likes l ON p.id = l.publication_id
                 WHERE p.utilisateur_id = u.id
                 GROUP BY p.id
             ) as publication_likes
    ) * 2 as score_likes,
    (
        (SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) * 10 +
        (SELECT COUNT(*) FROM commentaires WHERE utilisateur_id = u.id) * 5 +
        (
            SELECT COALESCE(SUM(like_count), 0)
            FROM (
                     SELECT COUNT(l.id) as like_count
                     FROM publications p
                     LEFT JOIN likes l ON p.id = l.publication_id
                     WHERE p.utilisateur_id = u.id
                     GROUP BY p.id
                 ) as publication_likes
        ) * 2
        ) as score_total
FROM utilisateurs u
ORDER BY score_total DESC;

-- 📚 EXERCICE 16: Analyse d'interaction sociale
-- Trouve quels utilisateurs interagissent le plus ensemble
-- (en se commentant mutuellement leurs publications)
SELECT
    u1.nom as utilisateur1,
    u2.nom as utilisateur2,
    COUNT(*) as interactions
FROM commentaires c1
    JOIN publications p1 ON c1.publication_id = p1.id
    JOIN utilisateurs u1 ON p1.utilisateur_id = u1.id
    JOIN utilisateurs u2 ON c1.utilisateur_id = u2.id
WHERE u1.id != u2.id
GROUP BY u1.id, u2.id
ORDER BY interactions DESC;