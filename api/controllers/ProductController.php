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
        'product_specific_attribute' => $product->getProductSpecificAttribute(),
        'type' => get_class($product)
      );
    }

    header('Content-Type: application/json');
    echo json_encode($productListArray);
  }

  public function addProduct($sku, $name, $price, $type, $productSpecificAttribute) {
    try {
      $product = new $type($sku, $name, $price, $productSpecificAttribute);
      if($this->p = $this->productList->addProduct($product)){
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      var_dump($e);
    }
  }
  
  

  

  public function deleteProducts(array $productSkus)
  {
    // Delete the products from the product list
    $this->productList->deleteProducts($productSkus);
  }
}

?>