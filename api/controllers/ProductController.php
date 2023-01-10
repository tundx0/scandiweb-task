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
    $product = $this->createProduct($type, $sku, $name, $price, $productSpecificAttribute);
    $this->productList->addProduct($product);
  }
  
  
  private function createProduct($type, $sku, $name, $price, $productSpecificAttribute) {
    $mod_attribute = '';
    if ($type == "DVDDisc") {
      $mod_attribute = "Size: " . $productSpecificAttribute . " MB";
    } elseif($type == "Book") {
      $mod_attribute = "Weight: " . $productSpecificAttribute . " KG";
    } else {
      $mod_attribute = "Dimensions: " . $productSpecificAttribute;
    }
    return new $type($sku, $name, $price, $mod_attribute);
  }
  

  public function deleteProducts(array $productSkus)
  {
    // Delete the products from the product list
    $this->productList->deleteProducts($productSkus);
  }
}

?>