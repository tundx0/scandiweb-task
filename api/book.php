<?php

require_once 'product.php';

class Book extends Product {
  private $weight;

  public function __construct($sku, $name, $price, $weight) {
    parent::__construct($sku, $name, $price);
    $this->weight = $weight;
  }

  public function getProductSpecificAttribute() {
    return $this->weight;
  }
}

?>