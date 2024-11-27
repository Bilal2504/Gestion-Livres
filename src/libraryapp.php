<?php

namespace src;

class LibraryApp
{
    private $library;

    public function __construct()
    {
        $this->library = new Library();
    }

    public function run()
    {
        while (true) {
            $this->showMenu();
            $choice = trim(fgets(STDIN));

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
                case '0':
                    echo "Au revoir!\n";
                    exit(0);
                default:
                    echo "Option invalide\n";
            }
        }
    }

    private function showMenu()
    {
        echo "\nGestion de Bibliothèque\n";
        echo "1. Ajouter un livre\n";
        echo "2. Modifier un livre\n";
        echo "3. Supprimer un livre\n";
        echo "4. Lister les livres\n";
        echo "5. Afficher un livre\n";
        echo "6. Trier les livres\n";
        echo "7. Rechercher un livre\n";
        echo "0. Quitter\n";
        echo "Choisissez une option : ";
    }

    private function addBook()
    {
        echo "Nom du livre : ";
        $name = trim(fgets(STDIN));
        echo "Description : ";
        $description = trim(fgets(STDIN));
        echo "En stock (o/n) : ";
        $inStock = strtolower(trim(fgets(STDIN))) === 'o';

        $book = $this->library->addBook($name, $description, $inStock);
        echo "Livre ajouté avec l'ID : " . $book->id . "\n";
    }

    private function listBooks()
    {
        $books = $this->library->getAllBooks();
        if (empty($books)) {
            echo "Aucun livre trouvé.\n";
            return;
        }

        foreach ($books as $book) {
            echo "ID: " . $book->id . "\n";
            echo "Nom: " . $book->name . "\n";
            echo "Description: " . $book->description . "\n";
            echo "En stock: " . ($book->inStock ? 'Oui' : 'Non') . "\n";
            echo "---------------\n";
        }
    }
}
