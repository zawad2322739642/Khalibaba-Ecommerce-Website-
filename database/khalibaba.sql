
CREATE DATABASE IF NOT EXISTS khalibaba CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE khalibaba;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
    seller_status ENUM('Pending','Approved','Suspended') NOT NULL DEFAULT 'Approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
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
    brand VARCHAR(80) NOT NULL DEFAULT '', specifications TEXT, warranty VARCHAR(100) NOT NULL DEFAULT '',
    status ENUM('Pending','Approved','Rejected','Hidden') NOT NULL DEFAULT 'Approved',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(30) NOT NULL DEFAULT 'Cash on delivery',
    payment_status ENUM('Pending','Paid','Refunded') NOT NULL DEFAULT 'Pending',
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

CREATE TABLE order_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('Pending','Processing','Shipped','Delivered','Cancelled') NOT NULL,
    actor_id INT NULL,
    note VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE ai_interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    query_text VARCHAR(300) NOT NULL,
    intent VARCHAR(40) NOT NULL,
    confidence ENUM('low','medium','high') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    buyer_id INT NOT NULL,
    rating TINYINT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY one_review_per_buyer_product (product_id, buyer_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
    CHECK (rating BETWEEN 1 AND 5)
);

CREATE TABLE returns (id INT AUTO_INCREMENT PRIMARY KEY, order_id INT NOT NULL, buyer_id INT NOT NULL, reason TEXT NOT NULL, status ENUM('Requested','Approved','Rejected','Received','Refunded') NOT NULL DEFAULT 'Requested', admin_note TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE, FOREIGN KEY(buyer_id) REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE support_tickets (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, order_id INT NULL, subject VARCHAR(150) NOT NULL, message TEXT NOT NULL, status ENUM('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open', admin_reply TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE SET NULL);
CREATE TABLE content_reports (id INT AUTO_INCREMENT PRIMARY KEY, reporter_id INT NOT NULL, product_id INT NULL, review_id INT NULL, reason VARCHAR(255) NOT NULL, status ENUM('Open','Reviewed','Dismissed') NOT NULL DEFAULT 'Open', admin_note TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(reporter_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE SET NULL, FOREIGN KEY(review_id) REFERENCES reviews(id) ON DELETE SET NULL);
CREATE TABLE marketplace_settings (setting_key VARCHAR(80) PRIMARY KEY, setting_value VARCHAR(255) NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
INSERT INTO marketplace_settings(setting_key,setting_value) VALUES ('commission_rate','5'),('return_policy','Returns can be requested for delivered orders and are reviewed by the marketplace team.');

INSERT INTO users (name,email,password,role) VALUES
('Demo Seller','seller@khalibaba.com',MD5('123456'),'seller'),
('Demo Buyer','buyer@khalibaba.com',MD5('123456'),'buyer'),
('Demo Admin','admin@khalibaba.com',MD5('123456'),'admin');

INSERT INTO products (seller_id,name,category,description,price,stock,image) VALUES
(1,'USB-C Fast Charging Cable','Cables','Durable 1 meter USB-C cable with fast charging support.',450,25,'usb-c.svg'),
(1,'Wireless Mouse','Computer Accessories','Ergonomic 2.4GHz wireless mouse for everyday use.',850,18,'mouse.svg'),
(1,'Bluetooth Earbuds','Audio','Compact wireless earbuds with charging case.',1650,12,'earbuds.svg'),
(1,'65W GaN Charger','Chargers','Compact 65W USB-C GaN wall charger.',2200,10,'charger.svg'),
(1,'Laptop Stand','Computer Accessories','Foldable aluminum laptop stand for desk setups.',1450,8,'stand.svg'),
(1,'USB Hub 4-Port','Adapters','4-port USB 3.0 hub for laptops and desktops.',990,15,'hub.svg'),
(1,'Magnetic Wireless Charger','Chargers','Compact magnetic charging pad for compatible phones.',1290,0,'charger.svg'),
(1,'Noise Isolating Earbuds','Audio','Wired earbuds with a comfortable in-ear fit.',690,0,'earbuds.svg'),
(1,'Slim USB-C Multiport Hub','Adapters','Portable hub with HDMI, USB-A, and USB-C ports.',1890,0,'hub.svg');

INSERT IGNORE INTO categories (name) SELECT DISTINCT category FROM products;
