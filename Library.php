<?php

require_once 'Book.php';

class Library {
    private $books = [];
    private $file;

    public function __construct($file = "books.json") {
        $this->file = $file;
        $this->loadBooks();
    }

    private function loadBooks() {
        if (file_exists($this->file)) {
            $data = json_decode(file_get_contents($this->file), true);
            foreach ($data as $item) {
                $this->books[] = new Book($item['name'], $item['description'], $item['inStock']);
                $this->books[count($this->books) - 1]->id = $item['id'];
            }
        }
    }

    private function saveBooks() {
        $data = array_map(function ($book) {
            return [
                'id' => $book->id,
                'name' => $book->name,
                'description' => $book->description,
                'inStock' => $book->inStock,
            ];
        }, $this->books);
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addBook($name, $description, $inStock = true) {
        $book = new Book($name, $description, $inStock);
        $this->books[] = $book;
        $this->saveBooks();
        return $book;
    }

    public function updateBook($id, $name, $description, $inStock) {
        foreach ($this->books as $key => $book) {
            if ($book->id === $id) {
                $this->books[$key]->name = $name;
                $this->books[$key]->description = $description;
                $this->books[$key]->inStock = $inStock;
                $this->saveBooks();
                return true;
            }
        }
        return false;
    }

    public function deleteBook($id) {
        foreach ($this->books as $key => $book) {
            if ($book->id === $id) {
                unset($this->books[$key]);
                $this->books = array_values($this->books);
                $this->saveBooks();
                return true;
            }
        }
        return false;
    }

    public function getAllBooks() {
        return $this->books;
    }

    public function getBook($id) {
        foreach ($this->books as $book) {
            if ($book->id === $id) {
                return $book;
            }
        }
        return null;
    }

    public function sortBooks($column = 'name', $ascending = true) {
        $this->books = $this->mergeSort($this->books, $column, $ascending);
    }

    private function mergeSort($array, $column, $ascending) {
        if (count($array) < 2) {
            return $array;
        }
        $mid = count($array) / 2;
        $left = array_slice($array, 0, $mid);
        $right = array_slice($array, $mid);

        return $this->merge(
            $this->mergeSort($left, $column, $ascending),
            $this->mergeSort($right, $column, $ascending),
            $column,
            $ascending
        );
    }

    private function merge($left, $right, $column, $ascending) {
        $result = [];
        while (count($left) && count($right)) {
            $comparison = $this->compareBooks($left[0], $right[0], $column);
            if ($ascending ? $comparison <= 0 : $comparison >= 0) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }
        return array_merge($result, $left, $right);
    }

    private function quickSort($array, $column, $ascending) {
        if (count($array) < 2) {
            return $array;
        }

        $pivot = $array[0];
        $left = [];
        $right = [];

        for ($i = 1; $i < count($array); $i++) {
            $comparison = $this->compareBooks($array[$i], $pivot, $column);
            if ($ascending ? $comparison < 0 : $comparison > 0) {
                $left[] = $array[$i];
            } else {
                $right[] = $array[$i];
            }
        }

        return array_merge(
            $this->quickSort($left, $column, $ascending),
            [$pivot],
            $this->quickSort($right, $column, $ascending)
        );
    }

    private function compareBooks($a, $b, $column) {
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

    public function searchBook($column, $value) {
        $sortedBooks = $this->quickSort($this->books, $column, true);

        $low = 0;
        $high = count($sortedBooks) - 1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            $comparison = $this->compareByColumn($sortedBooks[$mid], $column, $value);

            if ($comparison === 0) {
                return $sortedBooks[$mid];
            } elseif ($comparison < 0) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        return null;
    }

    private function compareByColumn($book, $column, $value) {
        switch ($column) {
            case 'name':
                return strcmp($book->name, $value);
            case 'description':
                return strcmp($book->description, $value);
            case 'inStock':
                return $book->inStock === ($value === 'true') ? 0 : ($book->inStock ? 1 : -1);
            case 'id':
                return strcmp($book->id, $value);
            default:
                return 0;
        }
    }
}