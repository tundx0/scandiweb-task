<?php
class ProductController {
  protected $productList;
  public $p;
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
    try {
      $product = $this->createProduct($type, $sku, $name, $price, $productSpecificAttribute);
      if($this->p = $this->productList->addProduct($product)){
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      var_dump($e);
    }
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