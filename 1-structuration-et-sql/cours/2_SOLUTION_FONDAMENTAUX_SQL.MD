# 📝 Solutions des exercices - Fondamentaux SQL

## Exercice 1 : Jointures et agrégation

Écrivez une requête qui affiche pour chaque utilisateur : son nom, le nombre de publications qu'il a faites, le nombre total de likes reçus sur ses publications, et le nombre total de commentaires reçus sur ses publications.

### Solution :
```sql
SELECT 
    u.id,
    u.nom,
    COUNT(DISTINCT p.id) AS nombre_publications,
    COUNT(DISTINCT l.id) AS nombre_likes,
    COUNT(DISTINCT c.id) AS nombre_commentaires
FROM 
    utilisateurs u
LEFT JOIN 
    publications p ON u.id = p.utilisateur_id
LEFT JOIN 
    likes l ON p.id = l.publication_id
LEFT JOIN 
    commentaires c ON p.id = c.publication_id
GROUP BY 
    u.id, u.nom;
```

> 💡 **Remarque** : Cette solution peut donner des résultats incorrects à cause du produit cartésien. Une meilleure approche utiliserait des sous-requêtes :

```sql
SELECT 
    u.id,
    u.nom,
    (SELECT COUNT(*) FROM publications WHERE utilisateur_id = u.id) AS nombre_publications,
    (
        SELECT COUNT(*) 
        FROM publications p
        JOIN likes l ON p.id = l.publication_id
        WHERE p.utilisateur_id = u.id
    ) AS nombre_likes,
    (
        SELECT COUNT(*) 
        FROM publications p
        JOIN commentaires c ON p.id = c.publication_id
        WHERE p.utilisateur_id = u.id
    ) AS nombre_commentaires
FROM 
    utilisateurs u;
```

## Exercice 2 : Recherche avec LIKE

Trouvez toutes les publications dont le contenu contient le mot "SQL" ou "MySQL", et affichez : le contenu de la publication, le nom de l'auteur, et la date de publication.

### Solution :
```sql
SELECT 
    p.contenu,
    u.nom AS auteur,
    p.date_publication
FROM 
    publications p
JOIN 
    utilisateurs u ON p.utilisateur_id = u.id
WHERE 
    p.contenu LIKE '%SQL%' OR p.contenu LIKE '%MySQL%'
ORDER BY 
    p.date_publication DESC;
```

## Exercice 3 : GROUP BY et HAVING

Identifiez les utilisateurs qui ont commenté plus de 3 publications différentes, et affichez : le nom de l'utilisateur, le nombre de publications distinctes commentées, et la date du commentaire le plus récent.

### Solution :
```sql
SELECT 
    u.nom,
    COUNT(DISTINCT c.publication_id) AS nombre_publications_commentees,
    MAX(c.date_commentaire) AS dernier_commentaire
FROM 
    utilisateurs u
JOIN 
    commentaires c ON u.id = c.utilisateur_id
GROUP BY 
    u.id, u.nom
HAVING 
    nombre_publications_commentees > 3;
```

## Exercice 4 : Requête complexe avec jointures multiples

Créez une liste d'activité qui montre : le type d'activité (publication, commentaire, like), le nom de l'utilisateur qui a effectué l'action, le contenu (pour les publications et commentaires) ou l'ID de la publication (pour les likes), et la date de l'activité, le tout trié par date (du plus récent au plus ancien).

### Solution :
```sql
-- Publications
SELECT 
    'Publication' AS type_activite,
    u.nom AS utilisateur,
    p.contenu AS detail,
    p.date_publication AS date_activite
FROM 
    publications p
JOIN 
    utilisateurs u ON p.utilisateur_id = u.id

UNION ALL

-- Commentaires
SELECT 
    'Commentaire' AS type_activite,
    u.nom AS utilisateur,
    c.contenu AS detail,
    c.date_commentaire AS date_activite
FROM 
    commentaires c
JOIN 
    utilisateurs u ON c.utilisateur_id = u.id

UNION ALL

-- Likes
SELECT 
    'Like' AS type_activite,
    u.nom AS utilisateur,
    CONCAT('Like sur publication #', l.publication_id) AS detail,
    l.date_like AS date_activite
FROM 
    likes l
JOIN 
    utilisateurs u ON l.utilisateur_id = u.id

ORDER BY 
    date_activite DESC;
```

---

# 🧠 Réponses au Quiz de révision

1. **Quelle est la différence entre une clé primaire et une clé étrangère ?**
    - Une clé primaire identifie de façon unique chaque enregistrement dans une table.
    - Une clé étrangère est une colonne qui fait référence à la clé primaire d'une autre table, établissant ainsi une relation entre les deux tables.

2. **Quel est le rôle de la clause ON dans une jointure ?**
    - La clause ON spécifie la condition de jointure entre deux tables, indiquant quelles colonnes doivent correspondre pour lier les enregistrements.

3. **Quelle est la différence entre un INNER JOIN et un LEFT JOIN ?**
    - INNER JOIN retourne uniquement les enregistrements qui ont une correspondance dans les deux tables.
    - LEFT JOIN retourne tous les enregistrements de la table de gauche (première table), même s'ils n'ont pas de correspondance dans la table de droite.

4. **Pourquoi utilise-t-on des alias avec AS ?**
    - Pour rendre le code plus lisible et concis
    - Pour donner des noms plus descriptifs aux colonnes
    - Pour éviter les ambiguïtés lorsque deux tables ont des colonnes portant le même nom
    - Pour simplifier la référence aux tables dans les requêtes complexes

5. **Comment peut-on trouver tous les enregistrements dont une colonne contient une certaine chaîne de caractères ?**
    - En utilisant l'opérateur LIKE avec des caractères jokers (%) : `WHERE colonne LIKE '%chaîne%'`

6. **Quelle est la différence entre WHERE et HAVING ?**
    - WHERE filtre les lignes individuelles avant le regroupement (GROUP BY)
    - HAVING filtre les groupes après le regroupement

7. **Quel mot-clé utilise-t-on pour trier les résultats d'une requête ?**
    - ORDER BY

8. **Comment compter le nombre de lignes d'une table ?**
    - `SELECT COUNT(*) FROM table;`

9. **Que fait la contrainte ON DELETE CASCADE sur une clé étrangère ?**
    - Elle propage automatiquement la suppression : lorsqu'un enregistrement est supprimé dans la table parent, tous les enregistrements liés dans la table enfant sont également supprimés.

10. **Quelle clause est nécessaire lors de l'utilisation de fonctions d'agrégation pour regrouper les résultats ?**
    - GROUP BY