## Testez vos compétences Laravel — Relations Eloquent

Ce dépôt est un exercice pratique : réalisez les tâches listées ci-dessous
et faites passer les tests PHPUnit, qui échouent volontairement pour le moment.

Pour vérifier votre progression, les tests se trouvent dans `tests/Feature/RelationshipsTest.php`.

Au départ, si vous exécutez `php artisan test`, tous les tests échouent.
Votre objectif est de les faire passer un par un.

> ⚠️ **Vous n'avez pas le droit de modifier les fichiers de tests.**


## Installation du projet

```sh
git clone <url-du-depot> projet
cd projet
cp .env.example .env  # Éditez vos variables d'environnement
composer install
php artisan key:generate
```

Puis lancez `php artisan test` pour voir les erreurs à corriger.


## Soumettre votre solution

Créez une Pull Request (ou Merge Request) vers la branche `main`.

---

## Tâche 1. Relation hasMany mal définie

Dans `app/Models/User.php`, la méthode `tasks()` utilise une relation hasMany,
mais il manque un paramètre (la foreign key). Corrigez cette définition.

Méthode de test : `test_user_create_task()`.

---

## Tâche 2. Relation belongsTo avec utilisateur manquant

La route GET `/tasks` affiche la liste des tâches, mais elle génère une erreur
quand une tâche n'est associée à aucun utilisateur.

Corrigez ce problème : la liste doit s'afficher même si l'utilisateur est absent,
en affichant simplement une cellule vide à la place du nom.

Plusieurs approches sont possibles — choisissez celle qui vous convient.

Méthode de test : `test_task_with_no_user()`.

---

## Tâche 3. Relation à deux niveaux (hasManyThrough)

La route GET `/users/{user}` affiche les commentaires des tâches appartenant à un utilisateur.
Définissez la relation de `User` vers `Comment` dans le modèle `User`,
afin que la vue `users/show.blade.php` fonctionne correctement.

Méthode de test : `test_show_users_comments()`.

---

## Tâche 4. Relation belongsToMany — Nom de la table pivot

La route GET `/roles` affiche la liste des rôles avec le nombre d'utilisateurs associés.
La relation dans `app/Models/Role.php` est mal définie : le nom de la table pivot (pivot table)
est incorrect. Corrigez la définition de la relation.

Méthode de test : `test_show_roles_with_users()`.

---

## Tâche 5. Relation belongsToMany — Champs supplémentaires dans la table pivot

La route GET `/teams` affiche les équipes avec leurs utilisateurs, chaque utilisateur
ayant des champs supplémentaires issus de la table pivot (pivot table).
Corrigez la relation dans `app/Models/Team.php` pour que la vue `teams/index.blade.php`
affiche les données correctement.

Méthode de test : `test_teams_with_users()`.

---

## Tâche 6. Relation hasMany — Moyenne d'un champ

La route GET `/countries` affiche les pays avec la taille moyenne de leurs équipes.
Corrigez le controller `CountryController` pour charger la moyenne via la relation,
telle qu'attendue par la vue Blade.

Méthode de test : `test_countries_with_team_size()`.

---

## Tâche 7. Relation polymorphique (Polymorphic)

La route GET `/attachments` affiche les noms de fichiers et les noms de classe
des modèles `Task` et `Comment`. Corrigez la relation dans `app/Models/Attachment.php`
pour que cela fonctionne.

Méthode de test : `test_attachments_polymorphic()`.

---

## Tâche 8. Ajout d'un enregistrement via belongsToMany

La route POST `/projects` doit enregistrer un projet pour l'utilisateur connecté,
avec le champ `start_date` issu de la requête (`$request`).
Écrivez cette ligne dans le controller `ProjectController`.

Méthode de test : `test_belongstomany_add()`.

---

## Tâche 9. Filtrage via belongsToMany

La route GET `/users` doit afficher uniquement les utilisateurs ayant au moins un projet.
Corrigez le controller `UserController` pour ajouter ce filtre.

Méthode de test : `test_filter_users()`.

---

## Questions / Problèmes ?

Si vous rencontrez des difficultés ou avez des suggestions, créez une Issue.

Bon courage !
