<!DOCTYPE html>
<html>
<head>
    <title>Create Irish Folklore Database and Tables</title>
</head>
<body>

<?php



$conn = new mysqli("conorproject", "root", "", $dbname, port 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$dbname = "irish_folklore_db";

// Drop existing DB
$sql = "DROP DATABASE IF EXISTS $dbname;";
if ($conn->query($sql) === TRUE) {
    echo "Database dropped successfully<br>";
} else {
    echo "Error dropping database: " . $conn->error . "<br>";
}

// Create DB
$sql = "CREATE DATABASE $dbname;";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();

// Connect to the new DB
$conn = new mysqli("conorproject", "root", "", $dbname,  port 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Users table
$sql = "CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating Users table: " . $conn->error . "<br>";
}

// Create Mythical_Creatures table
$sql = "CREATE TABLE Mythical_Creatures (
    creature_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Mythical_Creatures table created successfully<br>";
} else {
    echo "Error creating Mythical_Creatures table: " . $conn->error . "<br>";
}

// Create Legendary_Creatures table
$sql = "CREATE TABLE Legendary_Creatures (
    creature_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Legendary_Creatures table created successfully<br>";
} else {
    echo "Error creating Legendary_Creatures table: " . $conn->error . "<br>";
}

// Create Shop_Items table
$sql = "CREATE TABLE Shop_Items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('T-shirt', 'Hoodie', 'Book', 'Accessories') NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Shop_Items table created successfully<br>";
} else {
    echo "Error creating Shop_Items table: " . $conn->error . "<br>";
}

// Create Orders table
$sql = "CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Orders table created successfully<br>";
} else {
    echo "Error creating Orders table: " . $conn->error . "<br>";
}

// Create Order_Items table
$sql = "CREATE TABLE Order_Items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES Shop_Items(item_id) ON DELETE CASCADE
) ENGINE=InnoDB;";
if ($conn->query($sql) === TRUE) {
    echo "Order_Items table created successfully<br>";
} else {
    echo "Error creating Order_Items table: " . $conn->error . "<br>";
}

// Insert some sample mythical creatures
$sql = "INSERT INTO Mythical_Creatures (name, description, image_url) VALUES
('Banshee', 'A female spirit who heralds death by wailing.', 'images/banshee.jpg'),
('Leprechaun', 'A small fairy in Irish folklore, known for mischief and gold.', 'images/leprechaun.jpg'),
('Selkie', 'A mythological creature capable of changing from seal to human.', 'images/selkie.jpg');";

if ($conn->query($sql) === TRUE) {
    echo "Sample mythical creatures inserted<br>";
} else {
    echo "Error inserting mythical creatures: " . $conn->error . "<br>";
}

// Insert some sample legendary creatures
$sql = "INSERT INTO Legendary_Creatures (name, description, image_url) VALUES
('Fionn mac Cumhaill', 'A legendary hunter-warrior in Irish mythology.', 'images/fionn.jpg'),
('Cú Chulainn', 'A mythical hero with superhuman abilities.', 'images/cuchulainn.jpg'),
('The Dullahan', 'A headless rider on a black horse, harbinger of death.', 'images/dullahan.jpg');";

if ($conn->query($sql) === TRUE) {
    echo "Sample legendary creatures inserted<br>";
} else {
    echo "Error inserting legendary creatures: " . $conn->error . "<br>";
}

// Insert some sample shop items
$sql = "INSERT INTO Shop_Items (name, category, description, price, stock_quantity, image_url) VALUES
('Irish Folklore T-shirt', 'T-shirt', 'High quality cotton T-shirt with Irish folklore design.', 19.99, 100, 'images/tshirt.jpg'),
('Celtic Hoodie', 'Hoodie', 'Comfortable hoodie with Celtic knot design.', 39.99, 50, 'images/hoodie.jpg'),
('Irish Mythology Book', 'Book', 'An in-depth book about Irish myths and legends.', 14.99, 200, 'images/book.jpg'),
('Celtic Knot Bracelet', 'Accessories', 'Bracelet with traditional Celtic knot design.', 9.99, 150, 'images/bracelet.jpg');";

if ($conn->query($sql) === TRUE) {
    echo "Sample shop items inserted<br>";
} else {
    echo "Error inserting shop items: " . $conn->error . "<br>";
}

$conn->close();

?>

</body>
</html>
