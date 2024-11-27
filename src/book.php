<?php

namespace src;
class Book
{
    public $id;
    public $name;
    public $description;
    public $inStock;

    public function __construct($name, $description, $inStock = true)
    {
        $this->id = uniqid(); // Génère un ID unique
        $this->name = $name;
        $this->description = $description;
        $this->inStock = $inStock;
    }
}

