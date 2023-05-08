DROP TABLE IF EXISTS products;
USE product_db;

-- Create the products table
CREATE TABLE products (
  sku VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price VARCHAR(10) NOT NULL,
  specific_attribute VARCHAR(255) NOT NULL,
  type VARCHAR(255) NOT NULL
);

-- Insert products of type Book
INSERT INTO products (sku, name, price, specific_attribute, type)
VALUES ('sku1', 'Purple Hibiscus', 9.99, '0.5', 'Book'),
       ('sku4', 'Things Fall Apart', 14.99, '0.2', 'Book');

-- Insert products of type Furniture
INSERT INTO products (sku, name, price, specific_attribute, type)
VALUES ('sku2', 'Table', 19.99, '20x30x45', 'Furniture'),
       ('sku5', 'Book Shelf', 24.99, '90x42x70', 'Furniture');

-- Insert products of type DVD
INSERT INTO products (sku, name, price, specific_attribute, type)
VALUES ('sku3', 'Avatar The Way of The Water', 29.99, '900', 'DVDDisc'),
       ('sku6', 'Ant Man and The Wasp', 34.99, '700', 'DVDDisc');
