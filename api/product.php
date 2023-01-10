<?php

abstract class Product {
  protected $sku;
  protected $name;
  protected $price;

  public function __construct($sku, $name, $price) {
    $this->sku = $sku;
    $this->name = $name;
    $this->price = $price;
  }

  abstract public function getProductSpecificAttribute();

  public function getSku() {
    return $this->sku;
  }

  public function getName() {
    return $this->name;
  }

  public function getPrice() {
    return $this->price;
  }
}
?>
