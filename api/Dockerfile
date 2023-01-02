FROM php:7.4-apache

# Install MySQL and PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y default-mysql-client


RUN a2enmod rewrite

# Copy the application code to the container
COPY . /var/www/html/

COPY ./docker-entrypoint-initdb.d /docker-entrypoint-initdb.d

RUN chmod -R 775 /docker-entrypoint-initdb.d


# CMD ["/usr/sbin/mysqld", "--init-file=/docker-entrypoint-initdb.d/product_db.sql"]
# Set the working directory to the application root
WORKDIR /var/www/html/

# Expose the default Apache port
EXPOSE 80
