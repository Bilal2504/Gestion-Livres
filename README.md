# Système de Gestion de Bibliothèque

Un système simple de gestion de bibliothèque en PHP permettant de gérer une collection de livres via une interface en ligne de commande.

Ce projet a été développé dans le cadre d'un exercice d'algorithmie en PHP. Il permet de :
- Ajouter des livres à la bibliothèque
- Modifier les informations des livres
- Supprimer des livres
- Afficher la liste des livres
- Rechercher des livres
- Trier les livres selon différents critères

##  Installation

1. Cloner le repository :
```bash
git clone https://github.com/votre-username/gestion-bibliotheque.git
```

2. Se placer dans le dossier du projet :
```bash
cd gestion-bibliotheque
```

## Utilisation

Pour lancer l'application :
```bash
php index.php
```

### Menu Principal
```
Gestion de Bibliothèque
1. Ajouter un livre
2. Modifier un livre
3. Supprimer un livre
4. Lister les livres
5. Afficher un livre
6. Trier les livres
7. Rechercher un livre
0. Quitter
```

### Fonctionnalités

#### 1. Ajouter un livre
- Entrez le nom du livre
- Ajoutez une description
- Indiquez si le livre est en stock (o/n)

#### 2. Modifier un livre
- Recherche par ID
- Modification des informations existantes
- Possibilité de garder les anciennes valeurs

#### 3. Supprimer un livre
- Recherche par ID
- Confirmation avant suppression

#### 4. Lister les livres
- Affiche tous les livres de la bibliothèque
- Format : ID, Nom, Description, Statut stock

#### 5. Afficher un livre
- Recherche et affichage détaillé d'un livre spécifique

#### 6. Trier les livres
- Tri par nom, description ou disponibilité
- Ordre croissant ou décroissant

#### 7. Rechercher un livre
- Recherche par différents critères
- Affichage des résultats détaillés

## Structure du Projet

```
gestion-bibliotheque/
│
├── index.php          # Fichier principal
└── src/                # Dossier source (si vous décidez de séparer le code)
    ├── Book.php        # Classe Book
    ├── Library.php     # Classe Library
    └── LibraryApp.php  # Interface utilisateur
```

## Algorithmes Utilisés

- Tri à bulles pour le tri des livres
- Recherche séquentielle pour la recherche des livres
