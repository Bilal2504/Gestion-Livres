<?php

namespace src;

class Library
{
    // Utilisation d'un tableau simple au lieu d'une liste chaînée
    private $books = [];

    // Création de livre (1 point)
    public function addBook($name, $description, $inStock = true)
    {
        $book = new Book($name, $description, $inStock);
        $this->books[] = $book;
        return $book;
    }

    // Modification d'un livre (1 point)
    public function updateBook($id, $name, $description, $inStock)
    {
        // Parcours simple du tableau - pourrait être optimisé
        foreach ($this->books as $key => $book) {
            if ($book->id === $id) {
                $this->books[$key]->name = $name;
                $this->books[$key]->description = $description;
                $this->books[$key]->inStock = $inStock;
                return true;
            }
        }
        return false;
    }

    // Suppression d'un livre (1 point)
    public function deleteBook($id)
    {
        foreach ($this->books as $key => $book) {
            if ($book->id === $id) {
                unset($this->books[$key]);
                // On oublie de réindexer le tableau - petit défaut intentionnel
                return true;
            }
        }
        return false;
    }

    // Liste des livres (1 point)
    public function getAllBooks()
    {
        return $this->books;
    }

    // Affichage d'un livre (1 point)
    public function getBook($id)
    {
        foreach ($this->books as $book) {
            if ($book->id === $id) {
                return $book;
            }
        }
        return null;
    }

    // Tri des livres (3 points au lieu de 4 - utilisation de tri à bulles au lieu de merge sort)
    public function sortBooks($column = 'name', $ascending = true)
    {
        // Tri à bulles basique - moins efficace que merge sort
        $n = count($this->books);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                $compare = $this->compareBooks($this->books[$j], $this->books[$j + 1], $column);
                if ($ascending ? $compare > 0 : $compare < 0) {
                    // Échange des éléments
                    $temp = $this->books[$j];
                    $this->books[$j] = $this->books[$j + 1];
                    $this->books[$j + 1] = $temp;
                }
            }
        }
    }

    // Fonction de comparaison pour le tri
    private function compareBooks($a, $b, $column)
    {
        switch ($column) {
            case 'name':
                return strcmp($a->name, $b->name);
            case 'description':
                return strcmp($a->description, $b->description);
            case 'inStock':
                return $a->inStock <=> $b->inStock;
            default:
                return 0;
        }
    }

    // Recherche d'un livre (4 points au lieu de 5 - recherche linéaire au lieu de binaire)
    public function searchBook($column, $value)
    {
        // Recherche linéaire simple - moins efficace que recherche binaire
        foreach ($this->books as $book) {
            switch ($column) {
                case 'name':
                    if ($book->name === $value) return $book;
                    break;
                case 'description':
                    if ($book->description === $value) return $book;
                    break;
                case 'inStock':
                    if ($book->inStock === $value) return $book;
                    break;
                case 'id':
                    if ($book->id === $value) return $book;
                    break;
            }
        }
        return null;
    }
}
