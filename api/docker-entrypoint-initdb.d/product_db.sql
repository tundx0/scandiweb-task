
-- Database: `product_db`
--

-- --------------------------------------------------------

CREATE TABLE products (
  sku VARCHAR(255) PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  product_specific_attribute VARCHAR(255) NOT NULL
);

INSERT INTO products (sku, name, price, product_specific_attribute)
VALUES ('sku1', 'Product 1', 9.99, 'Attribute 1'),
       ('sku2', 'Product 2', 19.99, 'Attribute 2'),
       ('sku3', 'Product 3', 29.99, 'Attribute 3');
--
-- Table structure for table `products`
--

-- CREATE TABLE `products` (
--   `sku` varchar(20) NOT NULL,
--   `price` float NOT NULL,
--   `type` varchar(20) NOT NULL,
--   `name` varchar(20) NOT NULL,
--   `specific_attribute` varchar(40) NOT NULL
-- )

-- --
-- -- Dumping data for table `products`
-- --

-- INSERT INTO `products` (`sku`, `price`, `type`, `name`, `specific_attribute`) VALUES
-- ('book5', 14.99, 'Book', 'The Great Gatsby', 'Weight: 0.8 KG'),
-- ('dvd5', 9.99, 'DVDDisc', 'The Shawshank Redemp', 'size: 4.7 MB'),
-- ('furniture5', 499.99, 'Furniture', 'Sofa', 'Dimensions: 100x200x');

-- --
-- -- Indexes for dumped tables
-- --

-- --
-- -- Indexes for table `products`
-- --
-- ALTER TABLE `products`
--   ADD UNIQUE KEY `sku` (`sku`);
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
