CREATE TABLE products (
id SERIAL PRIMARY KEY,
name VARCHAR(100),
images VARCHAR(255),
price INTEGER,
stock INTEGER
);

CREATE TABLE purchases (
id SERIAL PRIMARY KEY,
product_id INTEGER,
qty INTEGER,
date DATE
);

CREATE TABLE orders (
id SERIAL PRIMARY KEY,
user_id INTEGER,
status ENUM('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
date DATE
);

CREATE TABLE order_items (
id SERIAL PRIMARY KEY,
order_id INTEGER,
product_id INTEGER,
qty INTEGER
);

CREATE TABLE users (
id SERIAL PRIMARY KEY,
name VARCHAR(100),
email VARCHAR(100),
password VARCHAR(255),
role VARCHAR(20)
);




INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@gmail.com','123','admin'),
('User','user@gmail.com','123','user');