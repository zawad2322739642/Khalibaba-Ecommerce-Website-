<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "khalibaba";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Categories are administered centrally; existing product categories are retained on upgrade.
$conn->query("CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
$conn->query("INSERT IGNORE INTO categories (name) SELECT DISTINCT category FROM products WHERE category <> ''");

function ensureColumn($conn, $table, $column, $definition) {
    $check = $conn->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    if ($check && !$check->num_rows) {
        try {
            $conn->query("ALTER TABLE `$table` ADD COLUMN `$column` $definition");
        } catch (mysqli_sql_exception $exception) {
            if (strpos($exception->getMessage(), 'Duplicate column name') === false) throw $exception;
        }
    }
}

// Keep existing course-project databases compatible with optional SRS features.
$conn->query("CREATE TABLE IF NOT EXISTS ai_interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    query_text VARCHAR(300) NOT NULL,
    intent VARCHAR(40) NOT NULL,
    confidence ENUM('low','medium','high') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
)");
$conn->query("CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    buyer_id INT NOT NULL,
    rating TINYINT NOT NULL,
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY one_review_per_buyer_product (product_id, buyer_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
)");
ensureColumn($conn, 'users', 'seller_status', "ENUM('Pending','Approved','Suspended') NOT NULL DEFAULT 'Approved'");
ensureColumn($conn, 'products', 'brand', "VARCHAR(80) NOT NULL DEFAULT ''");
ensureColumn($conn, 'products', 'specifications', "TEXT NULL");
ensureColumn($conn, 'products', 'warranty', "VARCHAR(100) NOT NULL DEFAULT ''");
ensureColumn($conn, 'products', 'status', "ENUM('Pending','Approved','Rejected','Hidden') NOT NULL DEFAULT 'Approved'");
ensureColumn($conn, 'orders', 'payment_method', "VARCHAR(30) NOT NULL DEFAULT 'Cash on delivery'");
ensureColumn($conn, 'orders', 'payment_status', "ENUM('Pending','Paid','Refunded') NOT NULL DEFAULT 'Pending'");
$conn->query("CREATE TABLE IF NOT EXISTS returns (
    id INT AUTO_INCREMENT PRIMARY KEY, order_id INT NOT NULL, buyer_id INT NOT NULL, reason TEXT NOT NULL,
    status ENUM('Requested','Approved','Rejected','Received','Refunded') NOT NULL DEFAULT 'Requested',
    admin_note TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE, FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
)");
$conn->query("CREATE TABLE IF NOT EXISTS support_tickets (
    id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, order_id INT NULL, subject VARCHAR(150) NOT NULL, message TEXT NOT NULL,
    status ENUM('Open','In Progress','Resolved','Closed') NOT NULL DEFAULT 'Open', admin_reply TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
)");
$conn->query("CREATE TABLE IF NOT EXISTS content_reports (
    id INT AUTO_INCREMENT PRIMARY KEY, reporter_id INT NOT NULL, product_id INT NULL, review_id INT NULL, reason VARCHAR(255) NOT NULL,
    status ENUM('Open','Reviewed','Dismissed') NOT NULL DEFAULT 'Open', admin_note TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL,
    FOREIGN KEY (review_id) REFERENCES reviews(id) ON DELETE SET NULL
)");
$conn->query("CREATE TABLE IF NOT EXISTS marketplace_settings (
    setting_key VARCHAR(80) PRIMARY KEY, setting_value VARCHAR(255) NOT NULL, updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
$conn->query("CREATE TABLE IF NOT EXISTS order_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('Pending','Processing','Shipped','Delivered','Cancelled') NOT NULL,
    actor_id INT NULL,
    note VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES users(id) ON DELETE SET NULL
)");
$conn->query("INSERT IGNORE INTO marketplace_settings(setting_key, setting_value) VALUES ('commission_rate','5'),('return_policy','Returns can be requested for delivered orders and are reviewed by the marketplace team.')");

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function taka($amount) {
    return "৳" . number_format((float)$amount, 2);
}

function recordOrderStatus($conn, $orderId, $status, $actorId = null, $note = null) {
    $stmt = $conn->prepare('INSERT INTO order_status_history(order_id,status,actor_id,note) VALUES(?,?,?,?)');
    $stmt->bind_param('isis', $orderId, $status, $actorId, $note);
    $stmt->execute();
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /Khalibaba/auth/login.php");
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: /Khalibaba/index.php");
        exit;
    }
}
?>
