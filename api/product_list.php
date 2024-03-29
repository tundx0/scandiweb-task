<?php

require_once 'product.php';

class ProductList {
  public $conn;

  private $productList = array();
  public $host = "host.docker.internal";
  public $username = "ola";
  public $password = "mypass";
  public $dbname = "product_db";

  public function __construct() {
    // Connect to the database
    // $host = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "product_db";
    $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);

    // Check for connection error
    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
  }

  public function addProduct(Product $product) {
    try {
      $sku = $product->getSku();
      $query = "SELECT * FROM products WHERE sku = '$sku'";
      $result = mysqli_query($this->conn, $query);
      if (mysqli_num_rows($result) > 0) {
          // If SKU exists, return an error message
          return true;
      } else {
        // Code that might throw an error
        $sku = $product->getSku();
        $name = $product->getName();
        $price = $product->getPrice();
        $type = get_class($product);
        $specificAttribute = $product->getProductSpecificAttribute();

        $sql = "INSERT INTO products (sku, name, price, type, specific_attribute) VALUES ('$sku', '$name', '$price', '$type', '$specificAttribute')";
        if (mysqli_query($this->conn, $sql)) {
          return false;
        } else {
          return true;
        }
      }
    } catch (Exception $e) {
        // Handle the error by returning an error message
        return "Error: " . $e->getMessage();
    }
}


  public function getProductList() {
    $this->productList = array();
  
    $sql = "SELECT * FROM products";
    $result = mysqli_query($this->conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = $result->fetch_object()) {
        $product = new $row->type($row->sku, $row->name, $row->price, $row->specific_attribute);
        $this->productList[] = $product;
      }
    }
    return $this->productList;
  }
 
  public function deleteProducts(array $productSkus)
  {
        // $product = array();
    $this->productList = array_filter($this->productList, function($product) use ($productSkus) {
      return !in_array($product->sku, $productSkus);
    });
    $placeholders = rtrim(str_repeat('?,', count($productSkus)), ',');
    $sql = "DELETE FROM products WHERE sku IN ($placeholders)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($productSkus)), ...$productSkus);
    $stmt->execute();
  }
}
?>