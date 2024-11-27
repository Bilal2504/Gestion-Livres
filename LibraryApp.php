<?php

require_once 'Library.php';
require_once 'History.php';

class LibraryApp {
    private $library;
    private $history;

    public function __construct() {
        $this->library = new Library();
        $this->history = new History();
    }

    public function run() {
        echo "Démarrage de l'application...\n";

        while (true) {
            $this->showMenu();
            echo "En attente d'une saisie utilisateur...\n";
            $choice = trim(fgets(STDIN));
            echo "Option choisie : $choice\n";

            switch ($choice) {
                case '1':
                    $this->addBook();
                    break;
                case '2':
                    $this->updateBook();
                    break;
                case '3':
                    $this->deleteBook();
                    break;
                case '4':
                    $this->listBooks();
                    break;
                case '5':
                    $this->showBook();
                    break;
                case '6':
                    $this->sortBooks();
                    break;
                case '7':
                    $this->searchBook();
                    break;
                case '8':
                    $this->history->displayHistory();
                    break;
                case '0':
                    echo "Au revoir!\n";
                    exit(0);
                default:
                    echo "Option invalide\n";
            }
        }
    }

    private function showMenu() {
        echo "\n--- Gestion de Bibliothèque ---\n";
        echo "1. Ajouter un livre\n";
        echo "2. Modifier un livre\n";
        echo "3. Supprimer un livre\n";
        echo "4. Lister les livres\n";
        echo "5. Afficher un livre\n";
        echo "6. Trier les livres\n";
        echo "7. Rechercher un livre\n";
        echo "8. Afficher l'historique\n";
        echo "0. Quitter\n";
        echo "Choisissez une option : ";
    }

    private function addBook() {
        echo "Nom du livre : ";
        $name = trim(fgets(STDIN));
        echo "Description : ";
        $description = trim(fgets(STDIN));
        echo "En stock (o/n) : ";
        $inStock = strtolower(trim(fgets(STDIN))) === 'o';

        $book = $this->library->addBook($name, $description, $inStock);
        $this->history->addAction("Ajout d'un livre", "ID: {$book->id}, Nom: {$book->name}");
        echo "Livre ajouté avec succès (ID : {$book->id}).\n";
    }

    private function updateBook() {
        echo "ID du livre à modifier : ";
        $id = trim(fgets(STDIN));
        echo "Nouveau nom : ";
        $name = trim(fgets(STDIN));
        echo "Nouvelle description : ";
        $description = trim(fgets(STDIN));
        echo "En stock (o/n) : ";
        $inStock = strtolower(trim(fgets(STDIN))) === 'o';

        if ($this->library->updateBook($id, $name, $description, $inStock)) {
            $this->history->addAction("Modification d'un livre", "ID: $id");
            echo "Livre modifié avec succès.\n";
        } else {
            echo "Livre non trouvé.\n";
        }
    }

    private function deleteBook() {
        echo "ID du livre à supprimer : ";
        $id = trim(fgets(STDIN));

        if ($this->library->deleteBook($id)) {
            $this->history->addAction("Suppression d'un livre", "ID: $id");
            echo "Livre supprimé avec succès.\n";
        } else {
            echo "Livre non trouvé.\n";
        }
    }

    private function listBooks() {
        $books = $this->library->getAllBooks();
        if (empty($books)) {
            echo "Aucun livre trouvé.\n";
            return;
        }

        foreach ($books as $book) {
            echo "ID: {$book->id}\n";
            echo "Nom: {$book->name}\n";
            echo "Description: {$book->description}\n";
            echo "En stock: " . ($book->inStock ? 'Oui' : 'Non') . "\n";
            echo "---------------\n";
        }
        $this->history->addAction("Liste des livres", "Nombre de livres affichés: " . count($books));
    }

    private function showBook() {
        echo "ID du livre à afficher : ";
        $id = trim(fgets(STDIN));
        $book = $this->library->getBook($id);
        if ($book) {
            echo "ID: {$book->id}\n";
            echo "Nom: {$book->name}\n";
            echo "Description: {$book->description}\n";
            echo "En stock: " . ($book->inStock ? 'Oui' : 'Non') . "\n";
            $this->history->addAction("Affichage d'un livre", "ID: $id");
        } else {
            echo "Livre non trouvé.\n";
        }
    }

    private function sortBooks() {
        echo "Trier par (name/description/inStock) : ";
        $column = trim(fgets(STDIN));
        echo "Ordre (o/n) : ";
        $order = strtolower(trim(fgets(STDIN))) === 'o';
        $this->library->sortBooks($column, $order);
        $this->history->addAction("Tri des livres", "Colonne: $column, Ordre: " . ($order ? "croissant" : "décroissant"));
        echo "Livres triés.\n";
    }

    private function searchBook() {
        echo "Recherche par (name/description/inStock/id) : ";
        $column = trim(fgets(STDIN));
        echo "Valeur à rechercher : ";
        $value = trim(fgets(STDIN));

        $book = $this->library->searchBook($column, $value);
        if ($book) {
            echo "ID: {$book->id}\n";
            echo "Nom: {$book->name}\n";
            echo "Description: {$book->description}\n";
            echo "En stock: " . ($book->inStock ? 'Oui' : 'Non') . "\n";
            $this->history->addAction("Recherche d'un livre", "ID: {$book->id}");
        } else {
            echo "Livre non trouvé.\n";
        }
    }
}