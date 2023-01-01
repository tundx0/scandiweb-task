<?php
class ProductController {
  protected $productList;

  public function __construct(ProductList $productList) {
    $this->productList = $productList;
  }

  public function showAllProducts() {
    $productListArray = array();
    foreach ($this->productList->getProductList() as $product) {
      $productListArray[] = array(
        'sku' => $product->getSku(),
        'name' => $product->getName(),
        'price' => $product->getPrice(),
        'product_specific_attribute' => $product->getProductSpecificAttribute()
      );
    }

    header('Content-Type: application/json');
    echo json_encode($productListArray);
  }

  public function addProduct($sku, $name, $price, $type, $productSpecificAttribute) {
    $product = null;

    // Determine which product subclass to create based on the product-specific attribute
    if ($type == "DVDDisc") {
      $mod_attribute = "size: " . $productSpecificAttribute . " MB";
      $product = new DVDDisc($sku, $name, $price, $mod_attribute);
    }
    elseif($type == "Book") {
      $mod_attribute = "Weight: " . $productSpecificAttribute . " KG";
      $product = new Book($sku, $name, $price, $mod_attribute);
    } else {
      $mod_attribute = "Dimensions: " . $productSpecificAttribute;
      $product = new Furniture($sku, $name, $price, $mod_attribute);
    }

    $this->productList->addProduct($product);
  }

  public function deleteProducts(array $productSkus)
  {
    // Delete the products from the product list
    $this->productList->deleteProducts($productSkus);
  }
}

?>