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

class ProductList {
  public $conn;

  private $productList = array();


  public function __construct() {
    // Connect to the database
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "product_db";
    $this->conn = mysqli_connect($host, $username, $password, $dbname);

    // Check for connection error
    if (!$this->conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
  }

  public function addProduct(Product $product) {
    $sku = $product->getSku();
    $name = $product->getName();
    $price = $product->getPrice();
    $type = get_class($product);
    $specificAttribute = $product->getProductSpecificAttribute();

    $sql = "INSERT INTO products (sku, name, price, type, specific_attribute) VALUES ('$sku', '$name', '$price', '$type', '$specificAttribute')";
    if (mysqli_query($this->conn, $sql)) {
      echo "New product added successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
    }
  }

  public function getProductList() {
    $this->productList = array();

    $sql = "SELECT * FROM products";
    $result = mysqli_query($this->conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $sku = $row['sku'];
        $name = $row['name'];
        $price = $row['price'];
        $type = $row['type'];
        $specificAttribute = $row['specific_attribute'];

        $product = null;
        switch($type) {
          case 'DVDDisc':
            $product = new DVDDisc($sku, $name, $price, $specificAttribute);
            break;
          case 'Book':
            $product = new Book($sku, $name, $price, $specificAttribute);
            break;
          case 'Furniture':
            $product = new Furniture($sku, $name, $price, $specificAttribute);
            break;
        }
        if ($product != null) {
          $productList[] = $product;
        }
      }
    }

    return $productList;
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
