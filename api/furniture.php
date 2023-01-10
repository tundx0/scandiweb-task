<?php

require_once 'product.php';

class Furniture extends Product {
  private $dimensions;

  public function __construct($sku, $name, $price, $dimensions) {
    parent::__construct($sku, $name, $price);
    $this->dimensions = $dimensions;
  }

  public function getProductSpecificAttribute() {
    return $this->dimensions;
  }
}

?>