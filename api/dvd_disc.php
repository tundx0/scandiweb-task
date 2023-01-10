<?php

require_once 'product.php';

class DVDDisc extends Product {
  private $size;

  public function __construct($sku, $name, $price, $size) {
    parent::__construct($sku, $name, $price);
    $this->size = $size;
  }

  public function getProductSpecificAttribute() {
    return $this->size;
  }
}
?>