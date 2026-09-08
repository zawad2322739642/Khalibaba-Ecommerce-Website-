
CREATE DATABASE IF NOT EXISTS khalibaba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE khalibaba;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
    shipping_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    seller_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (name,email,password,role) VALUES
('Demo Seller','seller@khalibaba.com',MD5('123456'),'seller'),
('Demo Buyer','buyer@khalibaba.com',MD5('123456'),'buyer');

INSERT INTO products (seller_id,name,category,description,price,stock,image) VALUES
(1,'USB-C Fast Charging Cable','Cables','Durable 1 meter USB-C cable with fast charging support.',450,25,'usb-c.svg'),
(1,'Wireless Mouse','Computer Accessories','Ergonomic 2.4GHz wireless mouse for everyday use.',850,18,'mouse.svg'),
(1,'Bluetooth Earbuds','Audio','Compact wireless earbuds with charging case.',1650,12,'earbuds.svg'),
(1,'65W GaN Charger','Chargers','Compact 65W USB-C GaN wall charger.',2200,10,'charger.svg'),
(1,'Laptop Stand','Computer Accessories','Foldable aluminum laptop stand for desk setups.',1450,8,'stand.svg'),
(1,'USB Hub 4-Port','Adapters','4-port USB 3.0 hub for laptops and desktops.',990,15,'hub.svg'),
(1,'Mechanical Keyboard','Computer Accessories','Compact 75% mechanical keyboard with hot-swappable switches.',2450,7,'keyboard.svg'),
(1,'Portable SSD 1TB','Storage','Fast and compact external SSD for work and travel.',5200,5,'ssd.svg'),
(1,'Noise Cancelling Headphones','Audio','Wireless over-ear headphones with a long battery life.',3990,6,'headphones.svg'),
(1,'Gaming Headset','Audio','RGB gaming headset with a detachable microphone.',2100,0,'headset.svg'),
(1,'Webcam Pro 4K','Computer Accessories','4K USB webcam for video calls and streaming.',3200,0,'webcam.svg'),
(1,'Mini Projector','Electronics','Pocket-sized projector for movies and presentations.',6800,0,'projector.svg');
