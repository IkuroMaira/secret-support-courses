# 📚 COURS : LES FONDAMENTAUX SQL
## *Comprendre les concepts essentiels pour maîtriser les requêtes SQL*

---

## 📋 Table des matières
1. [Les bases des tables SQL](#1-les-bases-des-tables-sql)
    - [Structure d'une table](#structure-dune-table)
    - [Clés primaires et étrangères](#clés-primaires-et-étrangères)
    - [Contraintes d'intégrité (CASCADE)](#contraintes-dintégrité-cascade)

2. [Les requêtes SELECT fondamentales](#2-les-requêtes-select-fondamentales)
    - [Structure d'une requête SELECT](#structure-dune-requête-select)
    - [WHERE : filtrer les résultats](#where--filtrer-les-résultats)
    - [ORDER BY : trier les résultats](#order-by--trier-les-résultats)
    - [LIMIT : limiter les résultats](#limit--limiter-les-résultats)

3. [Les jointures entre tables](#3-les-jointures-entre-tables)
    - [Le mot-clé JOIN](#le-mot-clé-join)
    - [La clause ON](#la-clause-on)
    - [Types de jointures](#types-de-jointures)
    - [Exemples pratiques](#exemples-pratiques-de-jointures)

4. [Les alias avec AS](#4-les-alias-avec-as)
    - [Alias pour les colonnes](#alias-pour-les-colonnes)
    - [Alias pour les tables](#alias-pour-les-tables)
    - [Avantages des alias](#avantages-des-alias)

5. [La recherche avec LIKE](#5-la-recherche-avec-like)
    - [Utilisation des caractères jokers](#utilisation-des-caractères-jokers)
    - [Exemples pratiques](#exemples-pratiques-de-like)

6. [L'agrégation de données](#6-lagrégation-de-données)
    - [Les fonctions d'agrégation (COUNT, SUM, AVG, MIN, MAX)](#les-fonctions-dagrégation)
    - [La clause GROUP BY](#la-clause-group-by)
    - [La clause HAVING](#la-clause-having)

7. [Exercices pratiques](#7-exercices-pratiques)

---

## 1. Les bases des tables SQL

### Structure d'une table

Une table SQL est composée de lignes (enregistrements) et de colonnes (champs). Chaque colonne a un type de données spécifique.

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

Dans cet exemple :
- `id`, `nom`, `email`, `date_inscription` sont des colonnes
- `INT`, `VARCHAR`, `DATETIME` sont des types de données
- `AUTO_INCREMENT`, `PRIMARY KEY`, `NOT NULL`, `UNIQUE`, `DEFAULT` sont des contraintes

### Clés primaires et étrangères

#### 🔑 Clé primaire (PRIMARY KEY)
- **Définition** : Une clé primaire est une colonne (ou un ensemble de colonnes) qui identifie de façon unique chaque ligne d'une table.
- **Caractéristiques** :
    - Doit être unique
    - Ne peut pas être NULL
    - Une seule clé primaire par table
    - Souvent utilisée avec AUTO_INCREMENT pour générer automatiquement des valeurs uniques

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- autres colonnes
);
```

#### 🔗 Clé étrangère (FOREIGN KEY)
- **Définition** : Une clé étrangère est une colonne qui établit une relation entre deux tables. Elle fait référence à la clé primaire d'une autre table.
- **Objectif** : Maintenir l'intégrité référentielle entre les tables (s'assurer que les données liées sont cohérentes).

```sql
CREATE TABLE publications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    contenu TEXT NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
);
```

Dans cet exemple :
- `utilisateur_id` est une clé étrangère dans la table `publications`
- Elle fait référence à la colonne `id` de la table `utilisateurs`
- Chaque valeur dans `utilisateur_id` doit correspondre à une valeur existante dans `utilisateurs.id`

### Contraintes d'intégrité (CASCADE)

Les contraintes d'intégrité déterminent ce qui se passe lorsqu'une ligne référencée est modifiée ou supprimée.

#### Options de contraintes :

1. **CASCADE** : Propage automatiquement les modifications/suppressions
```sql
FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
```
Lorsqu'un utilisateur est supprimé, toutes ses publications sont également supprimées.

2. **SET NULL** : Met la clé étrangère à NULL
```sql
FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL
```
Lorsqu'un utilisateur est supprimé, la colonne `utilisateur_id` est définie sur NULL pour toutes ses publications.

3. **RESTRICT** (ou NO ACTION) : Empêche la suppression/modification (par défaut)
```sql
FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE RESTRICT
```
Empêche la suppression d'un utilisateur tant qu'il a des publications.

4. **SET DEFAULT** : Met la clé étrangère à sa valeur par défaut
```sql
FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET DEFAULT
```

> 💡 **Note** : La contrainte CASCADE est très pratique pour maintenir automatiquement l'intégrité de la base de données, mais doit être utilisée avec prudence car elle peut entraîner des suppressions en cascade massives.

---

## 2. Les requêtes SELECT fondamentales

### Structure d'une requête SELECT

La structure de base d'une requête SELECT :

```sql
SELECT colonnes
FROM table
WHERE condition
ORDER BY colonne [ASC|DESC]
LIMIT nombre;
```

- **SELECT** : Spécifie les colonnes à récupérer
- **FROM** : Spécifie la table source
- **WHERE** : Filtre les lignes (facultatif)
- **ORDER BY** : Trie les résultats (facultatif)
- **LIMIT** : Limite le nombre de résultats (facultatif)

### WHERE : filtrer les résultats

La clause WHERE est utilisée pour filtrer les lignes selon une condition.

#### Opérateurs de comparaison :
- `=` : égal à
- `<>` ou `!=` : différent de
- `<` : inférieur à
- `>` : supérieur à
- `<=` : inférieur ou égal à
- `>=` : supérieur ou égal à

#### Opérateurs logiques :
- `AND` : les deux conditions doivent être vraies
- `OR` : au moins une des conditions doit être vraie
- `NOT` : inverse la condition

```sql
-- Utilisateurs dont le nom contient 'Martin' ET qui se sont inscrits après le 1er janvier 2023
SELECT * FROM utilisateurs 
WHERE nom LIKE '%Martin%' AND date_inscription > '2023-01-01';

-- Utilisateurs qui s'appellent 'Sophie' OU 'Marie'
SELECT * FROM utilisateurs 
WHERE nom = 'Sophie' OR nom = 'Marie';
```

### ORDER BY : trier les résultats

La clause ORDER BY est utilisée pour trier les résultats selon une ou plusieurs colonnes.

```sql
-- Trier par nom (ordre alphabétique)
SELECT * FROM utilisateurs ORDER BY nom;

-- Trier par date d'inscription (du plus récent au plus ancien)
SELECT * FROM utilisateurs ORDER BY date_inscription DESC;

-- Trier par nom, puis par date d'inscription
SELECT * FROM utilisateurs ORDER BY nom ASC, date_inscription DESC;
```

#### Le mot-clé DESC

- **ASC** (ascending) : ordre croissant (par défaut si non spécifié)
- **DESC** (descending) : ordre décroissant

### LIMIT : limiter les résultats

La clause LIMIT est utilisée pour limiter le nombre de résultats retournés.

```sql
-- Récupérer les 10 premiers utilisateurs
SELECT * FROM utilisateurs LIMIT 10;

-- Récupérer 10 utilisateurs à partir du 5ème
SELECT * FROM utilisateurs LIMIT 5, 10;  -- OFFSET 5, LIMIT 10
-- ou (syntaxe plus moderne)
SELECT * FROM utilisateurs LIMIT 10 OFFSET 5;
```

---

## 3. Les jointures entre tables

### Le mot-clé JOIN

Les jointures permettent de combiner des données provenant de plusieurs tables sur la base d'une relation entre elles.

### La clause ON

La clause ON spécifie la condition de jointure entre les tables.

```sql
SELECT *
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id;
```

Dans cet exemple :
- La table `publications` est jointe à la table `utilisateurs`
- La condition de jointure est que `publications.utilisateur_id` doit correspondre à `utilisateurs.id`

### Types de jointures

#### INNER JOIN (ou simplement JOIN)
- Retourne uniquement les lignes qui ont une correspondance dans les deux tables

```sql
SELECT p.contenu, u.nom
FROM publications p
INNER JOIN utilisateurs u ON p.utilisateur_id = u.id;
```

#### LEFT JOIN (ou LEFT OUTER JOIN)
- Retourne toutes les lignes de la table de gauche (première table), même si elles n'ont pas de correspondance dans la table de droite
- Pour les lignes sans correspondance, les colonnes de la table de droite sont NULL

```sql
SELECT u.nom, p.contenu
FROM utilisateurs u
LEFT JOIN publications p ON u.id = p.utilisateur_id;
```
Cette requête retournera tous les utilisateurs, même ceux qui n'ont pas de publications.

#### RIGHT JOIN (ou RIGHT OUTER JOIN)
- Fonctionne comme LEFT JOIN, mais retourne toutes les lignes de la table de droite

```sql
SELECT u.nom, p.contenu
FROM utilisateurs u
RIGHT JOIN publications p ON u.id = p.utilisateur_id;
```

#### FULL JOIN (ou FULL OUTER JOIN)
- Retourne toutes les lignes des deux tables, avec ou sans correspondance
- Non supporté nativement par MySQL, mais peut être simulé avec UNION

```sql
-- Simulation de FULL JOIN en MySQL
SELECT u.nom, p.contenu
FROM utilisateurs u
LEFT JOIN publications p ON u.id = p.utilisateur_id
UNION
SELECT u.nom, p.contenu
FROM utilisateurs u
RIGHT JOIN publications p ON u.id = p.utilisateur_id
WHERE u.id IS NULL;
```

### Exemples pratiques de jointures

#### Exemple 1 : Afficher les publications avec le nom de leur auteur
```sql
SELECT p.id, p.contenu, u.nom AS auteur
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id;
```

#### Exemple 2 : Afficher tous les utilisateurs et leur nombre de publications
```sql
SELECT u.nom, COUNT(p.id) AS nombre_publications
FROM utilisateurs u
LEFT JOIN publications p ON u.id = p.utilisateur_id
GROUP BY u.id;
```

#### Exemple 3 : Afficher les commentaires avec le nom de l'auteur et le contenu de la publication
```sql
SELECT c.contenu AS commentaire, u.nom AS auteur, p.contenu AS publication
FROM commentaires c
JOIN utilisateurs u ON c.utilisateur_id = u.id
JOIN publications p ON c.publication_id = p.id;
```

---

## 4. Les alias avec AS

### Alias pour les colonnes

Les alias de colonnes permettent de renommer temporairement une colonne dans les résultats d'une requête.

```sql
-- Sans alias
SELECT COUNT(*) FROM publications;

-- Avec alias
SELECT COUNT(*) AS nombre_total_publications FROM publications;
```

Dans les résultats, la colonne s'affichera avec le nom "nombre_total_publications" au lieu de "COUNT(*)".

### Alias pour les tables

Les alias de tables permettent de renommer temporairement une table dans une requête. C'est particulièrement utile dans les jointures pour rendre le code plus lisible et moins verbeux.

```sql
-- Sans alias
SELECT publications.contenu, utilisateurs.nom
FROM publications
JOIN utilisateurs ON publications.utilisateur_id = utilisateurs.id;

-- Avec alias
SELECT p.contenu, u.nom
FROM publications p
JOIN utilisateurs u ON p.utilisateur_id = u.id;
```

### Avantages des alias

1. **Lisibilité** : Rend le code plus concis et plus lisible
2. **Clarté** : Donne des noms plus descriptifs aux colonnes
3. **Nécessité** : Obligatoire lors de l'utilisation de fonctions d'agrégation sans GROUP BY
4. **Prévention des ambiguïtés** : Utile lorsque deux tables ont des colonnes portant le même nom

> 💡 **Note** : Le mot-clé AS est facultatif dans MySQL, mais le mettre rend le code plus explicite.
>
> ```sql
> -- Ces deux lignes sont équivalentes :
> SELECT COUNT(*) AS total FROM utilisateurs;
> SELECT COUNT(*) total FROM utilisateurs;
> ```

---

## 5. La recherche avec LIKE

Le mot-clé LIKE est utilisé dans une clause WHERE pour rechercher un motif spécifique dans une colonne.

### Utilisation des caractères jokers

- **%** (pourcentage) : Correspond à zéro ou plusieurs caractères
- **_** (underscore) : Correspond à exactement un caractère

```sql
-- Noms commençant par 'M'
SELECT * FROM utilisateurs WHERE nom LIKE 'M%';

-- Noms se terminant par 'in'
SELECT * FROM utilisateurs WHERE nom LIKE '%in';

-- Noms contenant 'ar' n'importe où
SELECT * FROM utilisateurs WHERE nom LIKE '%ar%';

-- Noms avec exactement 5 caractères
SELECT * FROM utilisateurs WHERE nom LIKE '_____';

-- Noms commençant par 'M' et contenant exactement 5 caractères
SELECT * FROM utilisateurs WHERE nom LIKE 'M____';
```

### Exemples pratiques de LIKE

#### Exemple 1 : Rechercher des utilisateurs par nom
```sql
SELECT * FROM utilisateurs WHERE nom LIKE '%Martin%';
```

#### Exemple 2 : Rechercher des emails d'un domaine spécifique
```sql
SELECT * FROM utilisateurs WHERE email LIKE '%@exemple.com';
```

#### Exemple 3 : Rechercher des publications contenant un mot spécifique
```sql
SELECT * FROM publications WHERE contenu LIKE '%SQL%';
```

> ⚠️ **Attention** : Les recherches avec LIKE sont généralement plus lentes que les recherches exactes, surtout si le caractère joker est utilisé au début du motif (comme '%mot').

---

## 6. L'agrégation de données

### Les fonctions d'agrégation

Les fonctions d'agrégation permettent de calculer une valeur unique à partir d'un ensemble de valeurs.

#### COUNT() : Compter le nombre de lignes
```sql
-- Nombre total d'utilisateurs
SELECT COUNT(*) FROM utilisateurs;

-- Nombre d'utilisateurs avec un email @exemple.com
SELECT COUNT(*) FROM utilisateurs WHERE email LIKE '%@exemple.com';

-- Nombre de valeurs non NULL dans la colonne 'email'
SELECT COUNT(email) FROM utilisateurs;
```

> 💡 **Note** : `COUNT(*)` compte toutes les lignes, tandis que `COUNT(colonne)` compte les valeurs non NULL de la colonne.

#### SUM() : Calculer la somme des valeurs
```sql
-- Nombre total de likes
SELECT SUM(nombre_likes) FROM publications;
```

#### AVG() : Calculer la moyenne des valeurs
```sql
-- Moyenne des likes par publication
SELECT AVG(nombre_likes) FROM publications;
```

#### MIN() et MAX() : Trouver la valeur minimale et maximale
```sql
-- Date de la première inscription
SELECT MIN(date_inscription) FROM utilisateurs;

-- Date de la dernière inscription
SELECT MAX(date_inscription) FROM utilisateurs;
```

### La clause GROUP BY

La clause GROUP BY est utilisée pour regrouper les lignes qui ont les mêmes valeurs dans des colonnes spécifiées.

```sql
-- Nombre d'utilisateurs par date d'inscription
SELECT date_inscription, COUNT(*) AS nombre_utilisateurs
FROM utilisateurs
GROUP BY date_inscription;

-- Nombre de publications par utilisateur
SELECT utilisateur_id, COUNT(*) AS nombre_publications
FROM publications
GROUP BY utilisateur_id;
```

#### Exemple avec plusieurs colonnes

```sql
-- Nombre de publications par utilisateur et par mois
SELECT 
    utilisateur_id, 
    MONTH(date_publication) AS mois, 
    COUNT(*) AS nombre_publications
FROM publications
GROUP BY utilisateur_id, MONTH(date_publication);
```

### La clause HAVING

La clause HAVING est utilisée pour filtrer les résultats d'un GROUP BY, de la même manière que WHERE filtre les lignes individuelles.

> ⚠️ **Important** : WHERE filtre les lignes avant le regroupement, tandis que HAVING filtre les groupes après le regroupement.

```sql
-- Utilisateurs ayant publié plus de 5 publications
SELECT utilisateur_id, COUNT(*) AS nombre_publications
FROM publications
GROUP BY utilisateur_id
HAVING nombre_publications > 5;

-- Utilisateurs ayant plus de 2 publications contenant le mot 'SQL'
SELECT utilisateur_id, COUNT(*) AS nombre_publications_sql
FROM publications
WHERE contenu LIKE '%SQL%'
GROUP BY utilisateur_id
HAVING nombre_publications_sql > 2;
```

---

## 7. Exercices pratiques

Maintenant que nous avons vu les concepts fondamentaux, voici quelques exercices pratiques qui combinent ces concepts. Utilisez la base de données que nous avons créée avec les tables `utilisateurs`, `publications`, `commentaires` et `likes`.

### Exercice 1 : Jointures et agrégation
Écrivez une requête qui affiche pour chaque utilisateur :
- Son nom
- Le nombre de publications qu'il a faites
- Le nombre total de likes reçus sur ses publications
- Le nombre total de commentaires reçus sur ses publications

```sql
-- Votre solution ici
```

### Exercice 2 : Recherche avec LIKE
Trouvez toutes les publications dont le contenu contient le mot "SQL" ou "MySQL", et affichez :
- Le contenu de la publication
- Le nom de l'auteur
- La date de publication

```sql
-- Votre solution ici
```

### Exercice 3 : GROUP BY et HAVING
Identifiez les utilisateurs qui ont commenté plus de 3 publications différentes, et affichez :
- Le nom de l'utilisateur
- Le nombre de publications distinctes commentées
- La date du commentaire le plus récent

```sql
-- Votre solution ici
```

### Exercice 4 : Requête complexe avec jointures multiples
Créez une liste d'activité qui montre :
- Le type d'activité (publication, commentaire, like)
- Le nom de l'utilisateur qui a effectué l'action
- Le contenu (pour les publications et commentaires) ou l'ID de la publication (pour les likes)
- La date de l'activité
- Le tout trié par date (du plus récent au plus ancien)

```sql
-- Votre solution ici
```

---

## 📚 Ressources complémentaires

- [Documentation officielle MySQL](https://dev.mysql.com/doc/)
- [W3Schools SQL Tutorial](https://www.w3schools.com/sql/)
- [SQLBolt - Learn SQL with interactive exercises](https://sqlbolt.com/)
- [Mode SQL Tutorial](https://mode.com/sql-tutorial/)
- [Codecademy - Learn SQL](https://www.codecademy.com/learn/learn-sql)

---

## 🧠 Quiz de révision

1. Quelle est la différence entre une clé primaire et une clé étrangère ?
2. Quel est le rôle de la clause ON dans une jointure ?
3. Quelle est la différence entre un INNER JOIN et un LEFT JOIN ?
4. Pourquoi utilise-t-on des alias avec AS ?
5. Comment peut-on trouver tous les enregistrements dont une colonne contient une certaine chaîne de caractères ?
6. Quelle est la différence entre WHERE et HAVING ?
7. Quel mot-clé utilise-t-on pour trier les résultats d'une requête ?
8. Comment compter le nombre de lignes d'une table ?
9. Que fait la contrainte ON DELETE CASCADE sur une clé étrangère ?
10. Quelle clause est nécessaire lors de l'utilisation de fonctions d'agrégation pour regrouper les résultats ?

---

**Solutions exercices et quiz disponibles séparément.**