<?php

namespace src;

class Library
{
    private $books = [];

    public function addBook($name, $description, $inStock = true)
    {
        $book = new Book($name, $description, $inStock);
        $this->books[] = $book;
        return $book;
    }

    public function updateBook($id, $name, $description, $inStock)
    {
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

    public function deleteBook($id)
    {
        foreach ($this->books as $key => $book) {
            if ($book->id === $id) {
                unset($this->books[$key]);
                return true;
            }
        }
        return false;
    }

    public function getAllBooks()
    {
        return $this->books;
    }

    public function getBook($id)
    {
        foreach ($this->books as $book) {
            if ($book->id === $id) {
                return $book;
            }
        }
        return null;
    }

    public function sortBooks($column = 'name', $ascending = true)
    {
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
    public function searchBook($column, $value)
    {
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
