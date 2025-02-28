# 📝 Corrigé : Opérations CRUD en SQL

## 🔰 Exercices débutants

### Exercice A1 : Affichez tous les utilisateurs dont le nom contient la lettre 'a'.
```sql
SELECT * FROM utilisateurs WHERE nom LIKE '%a%';
```

### Exercice A2 : Insérez un nouvel utilisateur avec vos propres informations.
```sql
INSERT INTO utilisateurs (nom, email, mot_de_passe) 
VALUES ('Votre Nom', 'votre.email@exemple.com', '$2y$10$abcdefghijklmnopqrstuv');
```

### Exercice A3 : Mettez à jour l'email de l'utilisateur avec l'ID 2.
```sql
UPDATE utilisateurs 
SET email = 'nouveau.email@exemple.com' 
WHERE id = 2;
```

### Exercice A4 : Supprimez la publication avec l'ID 4.
```sql
DELETE FROM publications 
WHERE id = 4;
```

## 🔰 Exercices intermédiaires

### Exercice B1 : Affichez le nombre de commentaires par publication, y compris les publications sans commentaire.
```sql
SELECT 
    p.id, 
    p.contenu, 
    COUNT(c.id) as nombre_commentaires
FROM publications p
LEFT JOIN commentaires c ON p.id = c.publication_id
GROUP BY p.id;
```

### Exercice B2 : Trouvez l'utilisateur qui a reçu le plus de likes sur ses publications.
```sql
SELECT 
    u.id, 
    u.nom, 
    COUNT(l.id) as nombre_total_likes
FROM utilisateurs u
JOIN publications p ON u.id = p.utilisateur_id
JOIN likes l ON p.id = l.publication_id
GROUP BY u.id
ORDER BY nombre_total_likes DESC
LIMIT 1;
```

### Exercice B3 : Affichez les publications et leurs auteurs, triées par date (les plus récentes d'abord).
```sql
SELECT 
    p.id, 
    p.contenu, 
    p.date_publication, 
    u.nom as auteur
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id
ORDER BY p.date_publication DESC;
```

### Exercice B4 : Trouvez les utilisateurs qui n'ont pas encore fait de commentaire.
```sql
SELECT u.id, u.nom
FROM utilisateurs u
LEFT JOIN commentaires c ON u.id = c.utilisateur_id
WHERE c.id IS NULL;
```

## 🔰 Exercices avancés

### Exercice C1 : Calculez le taux d'engagement pour chaque publication (nombre de commentaires + nombre de likes).
```sql
SELECT 
    p.id, 
    p.contenu,
    COUNT(DISTINCT c.id) as nombre_commentaires,
    COUNT(DISTINCT l.id) as nombre_likes,
    (COUNT(DISTINCT c.id) + COUNT(DISTINCT l.id)) as engagement_total
FROM publications p
LEFT JOIN commentaires c ON p.id = c.publication_id
LEFT JOIN likes l ON p.id = l.publication_id
GROUP BY p.id
ORDER BY engagement_total DESC;
```

### Exercice C2 : Trouvez les utilisateurs qui ont commenté leurs propres publications.
```sql
SELECT 
    u.nom,
    p.contenu as publication,
    c.contenu as commentaire
FROM commentaires c
JOIN publications p ON c.publication_id = p.id
JOIN utilisateurs u ON c.utilisateur_id = u.id
WHERE c.utilisateur_id = p.utilisateur_id;
```

### Exercice C3 : Créez une vue nommée 'resume_utilisateur' qui affiche pour chaque utilisateur: son nom, le nombre de publications, le nombre de commentaires reçus et le nombre de likes reçus.
```sql
CREATE VIEW resume_utilisateur AS
SELECT 
    u.id,
    u.nom,
    (SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) as nombre_publications,
    (
        SELECT COUNT(*) 
        FROM commentaires c
        JOIN publications p ON c.publication_id = p.id
        WHERE p.utilisateur_id = u.id
    ) as nombre_commentaires_recus,
    (
        SELECT COUNT(*) 
        FROM likes l
        JOIN publications p ON l.publication_id = p.id
        WHERE p.utilisateur_id = u.id
    ) as nombre_likes_recus
FROM utilisateurs u;

-- Pour afficher la vue après l'avoir créée
SELECT * FROM resume_utilisateur;
```

## 🏆 Challenge final

### Challenge D1 : Créez une requête qui montre une timeline complète des activités avec le nom de l'utilisateur associé et la date de l'activité, le tout trié par date.
```sql
SELECT 
    'publication' as type_activite, 
    u.nom as utilisateur, 
    p.contenu as detail, 
    p.date_publication as date_activite
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id

UNION ALL

SELECT 
    'commentaire' as type_activite, 
    u.nom as utilisateur, 
    CONCAT('Commentaire sur la publication #', c.publication_id, ': ', c.contenu) as detail, 
    c.date_commentaire as date_activite
FROM commentaires c
JOIN utilisateurs u ON c.utilisateur_id = u.id

UNION ALL

SELECT 
    'like' as type_activite, 
    u.nom as utilisateur, 
    CONCAT('Like sur la publication #', l.publication_id) as detail, 
    l.date_like as date_activite
FROM likes l
JOIN utilisateurs u ON l.utilisateur_id = u.id

ORDER BY date_activite DESC;
```