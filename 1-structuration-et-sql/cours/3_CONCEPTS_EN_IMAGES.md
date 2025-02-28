# 🖼️ Les concepts SQL en images

## 🔍 Types de jointures SQL illustrés

![Types de jointures SQL](https://www.codeproject.com/KB/database/Visual_SQL_Joins/Visual_SQL_JOINS_orig.jpg)

Cette image illustre les différents types de jointures SQL et comment ils affectent les résultats :
- **INNER JOIN** : Intersection des deux tables
- **LEFT JOIN** : Tous les enregistrements de la table de gauche + correspondances de la table de droite
- **RIGHT JOIN** : Tous les enregistrements de la table de droite + correspondances de la table de gauche
- **FULL OUTER JOIN** : Tous les enregistrements des deux tables

## 🔑 Clés primaires et étrangères

```
┌─────────────────────┐          ┌─────────────────────┐
│   utilisateurs      │          │   publications      │
├─────────────────────┤          ├─────────────────────┤
│ id (PK) ◆           │◆────────→│ utilisateur_id (FK) │
│ nom