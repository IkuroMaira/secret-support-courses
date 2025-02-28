# Structuration du code, nommage des fonctions

## 🏗️ Partie 1 : Structuration du code

### Principes fondamentaux de structuration
- **DRY (Don't Repeat Yourself)** : Éviter la duplication de code ♻️
- **KISS (Keep It Simple, Stupid)** : Garder le code simple et lisible 🧠

Exemple en Javascript

```js
// 1. Imports/Dépendances
import { fonctionUtile } from './utils.js';

// 2. Constantes et variables globales
const API_URL = 'https://api.exemple.com';
let compteur = 0;

// 3. Fonctions utilitaires
function formaterDate(date) {
  return date.toISOString().split('T')[0];
}

// 4. Fonctions principales
function recupererDonnees() {
  // Code ici
}

function traiterDonnees(data) {
  // Code ici
}

// 5. Gestionnaires d'événements
document.addEventListener('DOMContentLoaded', () => {
  // Initialisation
});

// 6. Exécution initiale
recupererDonnees();
```

### Quand créer un fonction ?

1. **Principe de responsabilité unique** : Une fonction doit faire une seule chose et la faire bien 🎯
    ```jsx
    // ❌ Fonction qui fait trop de choses
    function traiterFormulaire() {
      // Valider les données
      // Enregistrer dans la base de données
      // Envoyer un email
      // Afficher un message
    }
    
    // ✅ Fonctions avec responsabilités uniques
    function validerFormulaire() { /* ... */ }
    function enregistrerDonnees() { /* ... */ }
    function envoyerConfirmation() { /* ... */ }
    function afficherMessage() { /* ... */ }
    ```

2. **Code réutilisable** : Si vous écrivez le même code plusieurs fois, c'est un signe qu'il faut créer une fonction ♻️
3. **Lisibilité** : Si un bloc de code est complexe ou long (>15-20 lignes), envisagez de le transformer en fonction 📏
4. **Abstraction** : Créez des fonctions pour masquer la complexité des opérations 🧠

    ```jsx
    // Au lieu de:
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(email)) {
      afficherErreur('Email invalide');
    }
    
    // Préférez:
    function estEmailValide(email) {
      const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }
    
    if (!estEmailValide(email)) {
      afficherErreur('Email invalide');
    }
    ```

## 🔤 Partie 2 : Conventions de nommage des fonctions

### Principes généraux pour nommer vos fonctions 📋

1. **Verbe + Nom/Adjectif**: Une fonction réalise une action, son nom doit le refléter

    ```js
    // JavaScript
    getUser(), calculateTotal(), isValid(), convertToJSON()
    
    // PHP
    get_user(), calculate_total(), is_valid(), convert_to_json()
    ```

2. **Être spécifique** : Le nom doit indiquer précisément ce que fait la fonction

    ```jsx
    // ❌ Trop vague
    function process() { /* ... */ }
    
    // ✅ Spécifique
    function validateUserInput() { /* ... */ }
    ```

3. **Préfixes courants**:
    - `get/set` : Pour accéder ou modifier une valeur
    - `is/has/can` : Pour les fonctions qui retournent un booléen
    - `create/add` : Pour créer de nouvelles entités
    - `update/modify` : Pour modifier des entités existantes
    - `delete/remove` : Pour supprimer des entités

### Conventions spécifiques par langage 🌐
JavaScript
- camelCase pour les fonctions et variables
- PascalCase pour les classes

```js
function getUserData() { /* ... */ }
const userAge = 25;
class UserProfile { /* ... */ }
```

PHP
- snake_case traditionnellement (mais camelCase aussi utilisé dans les frameworks modernes)
```php
function get_user_data() { /* ... */ }
$user_age = 25;

// Ou style orienté objet (camelCase)
class UserProfile {
    public function getUserData() { /* ... */ }
}
```

## 📝 Résumé des points importants

### 1. Structuration du code

- **DRY**: Éviter la répétition de code
- **KISS**: Garder le code simple et compréhensible
- **Principe de responsabilité unique**: Une fonction = une tâche
- Créer des fonctions pour: code réutilisable, meilleure lisibilité, abstraction

### 2. Nommage des fonctions

- Toujours utiliser un verbe d'action + nom/adjectif
- Être spécifique et descriptif
- Respecter les conventions de nommage du langage:
   - JavaScript: camelCase pour les fonctions/variables, PascalCase pour les classes
   - PHP: snake_case traditionnellement, camelCase dans les frameworks modernes
- Utiliser des préfixes standards (get/set, is/has, create/add, etc.)

## Exercice

Corriger les noms des fonctions 🖊️

```
// Exemple en JavaScript - À corriger
function fn1(x) { return x * 2; }
function userData(id) { /* récupère les infos d'un utilisateur */ }
function CALC_SUM(arr) { /* calcule la somme d'un tableau */ }
function do_validation(form) { /* valide un formulaire */ }

// PHP - À corriger
function Fn1($x) { return $x * 2; }
function userData($id) { /* récupère les infos d'un utilisateur */ }
function CALC_SUM($arr) { /* calcule la somme d'un tableau */ }
```