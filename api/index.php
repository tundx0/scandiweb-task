<?php

require "product.php";
require "controllers/ProductController.php";


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
  header("Access-Control-Allow-Headers: Content-Type");
  exit;
}


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$parts = explode("/", $path);
// var_dump($parts)

$resource = $parts[2];
$endpoint = $_SERVER["REQUEST_URI"];
$id = $parts[3] ?? null;

$method = $_SERVER['REQUEST_METHOD'];
// echo $resource;

if (!$resource == 'api') {
  http_response_code(404);
  exit;

}
header("Content-type: application/json; charset=UTF-8");


$productList = new ProductList();
$productController = new ProductController($productList);

switch ($method) {
  case 'GET':
    // If the endpoint is api/v1/, show all products
    if ($endpoint == '/api/v1/') {
      $productController->showAllProducts();
    }else{
      header('HTTP/1.1 404 NOT FOUND');
      header('Content-Type: application/json');
      echo json_encode(array('message' => 'No Data'));
    }
    break;
  case 'DELETE':
    // If the endpoint is api/v1/product, delete the specified products
    if ($endpoint == '/api/v1/product') {
      $requestBody = file_get_contents('php://input');
      $requestData = json_decode($requestBody, true);
  
      // Extract the list of product SKUs from the request body
      $productSkus = $requestData['skus'];
  
      
      $productList->deleteProducts($productSkus);
  
      header('HTTP/1.1 200 OK');
      header('Content-Type: application/json');
      echo json_encode(array('message' => 'Products deleted successfully'));
    } else {
      // Return a 404 Not Found error if the endpoint is not api/v1/product
      header('HTTP/1.1 404 Not Found');
      header('Content-Type: application/json');
      echo json_encode(array('message' => 'Endpoint not found'));
    }
    break;
    
  case 'POST':
    // If the endpoint is api/v1/product, add a new product
    if ($endpoint == '/api/v1/product') {
      // Get the request body as a JSON object
      $requestBody = file_get_contents('php://input');
      $productData = json_decode($requestBody, true);

      // Extract the product data from the request body
      $sku = $productData['sku'];
      $name = $productData['name'];
      $price = $productData['price'];
      $type = $productData['type'];
      $productSpecificAttribute = $productData['product_specific_attribute'];

      // Add the product using the ProductController's addProduct method
      $productController->addProduct($sku, $name, $price, $type, $productSpecificAttribute);
      header('HTTP/1.1 201 Created');
      header('Content-Type: application/json');
      echo json_encode(array('message' => 'Product added successfully'));
    }
    break;
  default:
    // Return an error if the HTTP method or endpoint is not supported
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: GET, POST, DELETE');
    break;
}
// $productController->addProduct('dvd5', 'The Shawshank Redemption', 9.99, 'DVDDisc', 4.7);
// $productController->addProduct('furniture5', 'Sofa', 499.99, 'Furniture', '100x200x300');
// $productController->addProduct('book5', 'The Great Gatsby', 14.99 , 'Book', 0.8);
mysqli_close($productList->conn);



?>