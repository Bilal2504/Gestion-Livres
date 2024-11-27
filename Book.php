<?php

class Book {
    public $id;
    public $name;
    public $description;
    public $inStock;

    public function __construct($name, $description, $inStock = true) {
        $this->id = uniqid();
        $this->name = $name;
        $this->description = $description;
        $this->inStock = $inStock;
    }
}