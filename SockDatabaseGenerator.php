<!DOCTYPE html>
<html>

<head>
    <title>Creating Database Table</title>
</head>

<body>

<?php
include 'db_connect.php';

// Drop database if exists
$sql = "DROP DATABASE IF EXISTS $dbname;";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

// Create database
$sql = "CREATE DATABASE $dbname;";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();

$conn = new mysqli("aaronproject", "root", "", $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE Users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}


// sql to create table
$sql = "CREATE TABLE Socks (
  sock_id INT AUTO_INCREMENT PRIMARY KEY,
  sock_color VARCHAR(30) NOT NULL,
  sock_pattern VARCHAR(50) NOT NULL,
  size VARCHAR(10) NOT NULL,
  status ENUM('available', 'stolen') DEFAULT 'available',
  image_url VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// sql to create table

$sql = "CREATE TABLE Theft_Reports (
  report_id INT AUTO_INCREMENT PRIMARY KEY,
  sock_id INT NOT NULL,
  reporter_user_id INT NOT NULL,
  report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  description TEXT NOT NULL,
  FOREIGN KEY (sock_id) REFERENCES Socks(sock_id) ON DELETE CASCADE,
  FOREIGN KEY (reporter_user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}



$sql = "CREATE TABLE Merchandise (
  merchandise_id INT AUTO_INCREMENT PRIMARY KEY,
  sock_id INT NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  stock_quantity INT NOT NULL,
  FOREIGN KEY (sock_id) REFERENCES Socks(sock_id) ON DELETE CASCADE
) ENGINE=InnoDB;
";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE Orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  total_amount DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "CREATE TABLE Order_Items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    merchandise_id INT NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (merchandise_id) REFERENCES Merchandise(merchandise_id) ON DELETE CASCADE
) ENGINE=InnoDB;
";

if ($conn->query($sql) === TRUE) {
  echo "Table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO Socks (sock_color, sock_pattern, size, status, image_url) VALUES
('Red', 'Striped', 'Small', 'available', 'stripedredsock.jpg'),
('Red', 'Polka Dot', 'Medium', 'available', 'polkadotredsock.jpg'),
('Red', 'Argyle', 'Large', 'available', 'argyleredsock.jpg'),
('Red', 'Solid', 'Extra Large', 'available', 'solidredsock.jpg'),
('Red', 'Checked', 'Small', 'available', 'checkedredsock.jpg'),
('Red', 'Graphic', 'Medium', 'stolen', 'graphicredsock.jpg'),
('Red', 'Floral', 'Large', 'available', 'floralredsock.jpg'),
('Red', 'Geometric', 'Extra Large', 'available', 'geometricredsock.jpg'),
('Red', 'Swirled', 'Medium', 'available', 'swirledredsock.jpg'),
('Red', 'Textured', 'Small', 'stolen', 'texturedredsock.jpg'),
('Blue', 'Striped', 'Small', 'available', 'stripedbluesock.jpg'),
('Blue', 'Polka Dot', 'Medium', 'available', 'polkadotbluesock.jpg'),
('Blue', 'Argyle', 'Large', 'stolen', 'argylebluesock.jpg'),
('Blue', 'Solid', 'Extra Large', 'available', 'solidbluesock.jpg'),
('Blue', 'Checked', 'Small', 'available', 'checkedbluesock.jpg'),
('Blue', 'Graphic', 'Medium', 'available', 'graphicbluesock.jpg'),
('Blue', 'Floral', 'Large', 'available', 'floralbluesock.jpg'),
('Blue', 'Geometric', 'Extra Large', 'stolen', 'geometricbluesock.jpg'),
('Blue', 'Swirled', 'Medium', 'available', 'swirledbluesock.jpg'),
('Blue', 'Textured', 'Small', 'available', 'texturedbluesock.jpg'),
('Green', 'Striped', 'Small', 'available', 'stripedgreensock.jpg'),
('Green', 'Polka Dot', 'Medium', 'available', 'polkadotgreensock.jpg'),
('Green', 'Argyle', 'Large', 'available', 'argylegreensock.jpg'),
('Green', 'Solid', 'Extra Large', 'stolen', 'solidgreensock.jpg'),
('Green', 'Checked', 'Small', 'available', 'checkedgreensock.jpg'),
('Green', 'Graphic', 'Medium', 'available', 'graphicgreensock.jpg'),
('Green', 'Floral', 'Large', 'available', 'floralgreensock.jpg'),
('Green', 'Geometric', 'Extra Large', 'available', 'geometricgreensock.jpg'),
('Green', 'Swirled', 'Medium', 'stolen', 'swirledgreensock.jpg'),
('Green', 'Textured', 'Small', 'available', 'texturedgreensock.jpg'),
('Yellow', 'Striped', 'Small', 'available', 'stripedyellowsock.jpg'),
('Yellow', 'Polka Dot', 'Medium', 'stolen', 'polkadotyellowsock.jpg'),
('Yellow', 'Argyle', 'Large', 'available', 'argyleyellowsock.jpg'),
('Yellow', 'Solid', 'Extra Large', 'available', 'solidyellowsock.jpg'),
('Yellow', 'Checked', 'Small', 'available', 'checkedyellowsock.jpg'),
('Yellow', 'Graphic', 'Medium', 'available', 'graphicyellowsock.jpg'),
('Yellow', 'Floral', 'Large', 'available', 'floralyellowsock.jpg'),
('Yellow', 'Geometric', 'Extra Large', 'available', 'geometricyellowsock.jpg'),
('Yellow', 'Swirled', 'Medium', 'available', 'swirledyellowsock.jpg'),
('Yellow', 'Textured', 'Small', 'stolen', 'texturedyellowsock.jpg'),
('Purple', 'Striped', 'Small', 'available', 'stripedpurplesock.jpg'),
('Purple', 'Polka Dot', 'Medium', 'available', 'polkadotpurplesock.jpg'),
('Purple', 'Argyle', 'Large', 'stolen', 'argylepurplesock.jpg'),
('Purple', 'Solid', 'Extra Large', 'available', 'solidpurplesock.jpg'),
('Purple', 'Checked', 'Small', 'available', 'checkedpurplesock.jpg'),
('Purple', 'Graphic', 'Medium', 'available', 'graphicpurplesock.jpg'),
('Purple', 'Floral', 'Large', 'available', 'floralpurplesock.jpg'),
('Purple', 'Geometric', 'Extra Large', 'stolen', 'geometricpurplesock.jpg'),
('Purple', 'Swirled', 'Medium', 'available', 'swirledpurplesock.jpg'),
('Purple', 'Textured', 'Small', 'available', 'texturedpurplesock.jpg'),
('Black', 'Striped', 'Small', 'available', 'stripedblacksock.jpg'),
('Black', 'Polka Dot', 'Medium', 'available', 'polkadotblacksock.jpg'),
('Black', 'Argyle', 'Large', 'available', 'argyleblacksock.jpg'),
('Black', 'Solid', 'Extra Large', 'stolen', 'solidblacksock.jpg'),
('Black', 'Checked', 'Small', 'available', 'checkedblacksock.jpg'),
('Black', 'Graphic', 'Medium', 'available', 'graphicblacksock.jpg'),
('Black', 'Floral', 'Large', 'available', 'floralblacksock.jpg'),
('Black', 'Geometric', 'Extra Large', 'available', 'geometricblacksock.jpg'),
('Black', 'Swirled', 'Medium', 'available', 'swirledblacksock.jpg'),
('Black', 'Textured', 'Small', 'stolen', 'texturedblacksock.jpg'),
('White', 'Striped', 'Small', 'available', 'stripedwhitesock.jpg'),
('White', 'Polka Dot', 'Medium', 'available', 'polkadotwhitesock.jpg'),
('White', 'Argyle', 'Large', 'available', 'argylewhitesock.jpg'),
('White', 'Solid', 'Extra Large', 'available', 'solidwhitesock.jpg'),
('White', 'Checked', 'Small', 'stolen', 'checkedwhitesock.jpg'),
('White', 'Graphic', 'Medium', 'available', 'graphicwhitesock.jpg'),
('White', 'Floral', 'Large', 'available', 'floralwhitesock.jpg'),
('White', 'Geometric', 'Extra Large', 'available', 'geometricwhitesock.jpg'),
('White', 'Swirled', 'Medium', 'available', 'swirledwhitesock.jpg'),
('White', 'Textured', 'Small', 'available', 'texturedwhitesock.jpg'),
('Orange', 'Striped', 'Small', 'available', 'stripedorangesock.jpg'),
('Orange', 'Polka Dot', 'Medium', 'available', 'polkadotorangesock.jpg'),
('Orange', 'Argyle', 'Large', 'available', 'argyleorangesock.jpg'),
('Orange', 'Solid', 'Extra Large', 'stolen', 'solidorangesock.jpg'),
('Orange', 'Checked', 'Small', 'available', 'checkedorangesock.jpg'),
('Orange', 'Graphic', 'Medium', 'available', 'graphicorangesock.jpg'),
('Orange', 'Floral', 'Large', 'available', 'floralorangesock.jpg'),
('Orange', 'Geometric', 'Extra Large', 'available', 'geometricorangesock.jpg'),
('Orange', 'Swirled', 'Medium', 'available', 'swirledorangesock.jpg'),
('Orange', 'Textured', 'Small', 'available', 'texturedorangesock.jpg'),
('Pink', 'Striped', 'Small', 'available', 'stripedpinksock.jpg'),
('Pink', 'Polka Dot', 'Medium', 'available', 'polkadotpinksock.jpg'),
('Pink', 'Argyle', 'Large', 'available', 'argylepinksock.jpg'),
('Pink', 'Solid', 'Extra Large', 'available', 'solidpinksock.jpg'),
('Pink', 'Checked', 'Small', 'available', 'checkedpinksock.jpg'),
('Pink', 'Graphic', 'Medium', 'available', 'graphicpinksock.jpg'),
('Pink', 'Floral', 'Large', 'stolen', 'floralpinksock.jpg'),
('Pink', 'Geometric', 'Extra Large', 'available', 'geometricpinksock.jpg'),
('Pink', 'Swirled', 'Medium', 'available', 'swirledpinksock.jpg'),
('Pink', 'Textured', 'Small', 'available', 'texturedpinksock.jpg'),
('Brown', 'Striped', 'Small', 'available', 'stripedbrownsock.jpg'),
('Brown', 'Polka Dot', 'Medium', 'available', 'polkadotbrownsock.jpg'),
('Brown', 'Argyle', 'Large', 'available', 'argylebrownsock.jpg'),
('Brown', 'Solid', 'Extra Large', 'available', 'solidbrownsock.jpg'),
('Brown', 'Checked', 'Small', 'stolen', 'checkedbrownsock.jpg'),
('Brown', 'Graphic', 'Medium', 'available', 'graphicbrownsock.jpg'),
('Brown', 'Floral', 'Large', 'available', 'floralbrownsock.jpg'),
('Brown', 'Geometric', 'Extra Large', 'available', 'geometricbrownsock.jpg'),
('Brown', 'Swirled', 'Medium', 'available', 'swirledbrownsock.jpg'),
('Brown', 'Textured', 'Small', 'available', 'texturedbrownsock.jpg');
";

if ($conn->query($sql) === TRUE) {
  echo "Table entries created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}


$sql = "INSERT INTO Merchandise (sock_id, price, stock_quantity) VALUES
(1, 9.99, 100),  -- Red Striped Small
(2, 10.99, 150), -- Red Polka Dot Medium
(3, 11.99, 200), -- Red Argyle Large
(4, 12.99, 50),  -- Red Solid Extra Large
(5, 8.99, 120),  -- Red Checked Small
(7, 10.99, 80),  -- Red Floral Large
(8, 11.99, 60),  -- Red Geometric Extra Large
(9, 10.99, 90),  -- Red Swirled Medium
(10, 9.99, 110), -- Red Textured Small
(11, 9.99, 100),  -- Blue Striped Small
(12, 10.99, 150), -- Blue Polka Dot Medium
(14, 12.99, 50),  -- Blue Solid Extra Large
(15, 8.99, 120),  -- Blue Checked Small
(16, 10.99, 80),  -- Blue Graphic Medium
(17, 10.99, 80),  -- Blue Floral Large
(18, 11.99, 60),  -- Blue Geometric Extra Large
(19, 10.99, 90),  -- Blue Swirled Medium
(20, 9.99, 110),  -- Blue Textured Small
(21, 9.99, 100),  -- Green Striped Small
(22, 10.99, 150), -- Green Polka Dot Medium
(23, 11.99, 200), -- Green Argyle Large
(24, 12.99, 50),  -- Green Solid Extra Large
(25, 8.99, 120),  -- Green Checked Small
(26, 10.99, 80),  -- Green Graphic Medium
(27, 10.99, 80),  -- Green Floral Large
(28, 11.99, 60),  -- Green Geometric Extra Large
(30, 10.99, 90),  -- Green Textured Small
(31, 9.99, 100),  -- Yellow Striped Small
(33, 11.99, 200), -- Yellow Argyle Large
(34, 12.99, 50),  -- Yellow Solid Extra Large
(35, 8.99, 120),  -- Yellow Checked Small
(36, 10.99, 80),  -- Yellow Graphic Medium
(37, 10.99, 80),  -- Yellow Floral Large
(38, 11.99, 60),  -- Yellow Geometric Extra Large
(39, 10.99, 90),  -- Yellow Swirled Medium
(40, 9.99, 110),  -- Yellow Textured Small
(41, 9.99, 100),  -- Purple Striped Small
(42, 10.99, 150), -- Purple Polka Dot Medium
(44, 12.99, 50),  -- Purple Solid Extra Large
(45, 8.99, 120),  -- Purple Checked Small
(46, 10.99, 80),  -- Purple Graphic Medium
(47, 10.99, 80),  -- Purple Floral Large
(48, 11.99, 60),  -- Purple Geometric Extra Large
(49, 10.99, 90),  -- Purple Swirled Medium
(50, 9.99, 110),  -- Purple Textured Small
(51, 9.99, 100),  -- Black Striped Small
(52, 10.99, 150), -- Black Polka Dot Medium
(53, 11.99, 200), -- Black Argyle Large
(55, 12.99, 50),  -- Black Checked Small
(56, 10.99, 80),  -- Black Graphic Medium
(57, 10.99, 80),  -- Black Floral Large
(58, 11.99, 60),  -- Black Geometric Extra Large
(59, 10.99, 90),  -- Black Swirled Medium
(60, 9.99, 110),  -- Black Textured Small
(61, 9.99, 100),  -- White Striped Small
(62, 10.99, 150), -- White Polka Dot Medium
(63, 11.99, 200), -- White Argyle Large
(64, 12.99, 50),  -- White Solid Extra Large
(65, 10.99, 80),  -- White Graphic Medium
(66, 10.99, 80),  -- White Floral Large
(67, 11.99, 60),  -- White Geometric Extra Large
(68, 10.99, 90),  -- White Swirled Medium
(69, 9.99, 110),  -- White Textured Small
(70, 9.99, 100),  -- Orange Striped Small
(71, 10.99, 150), -- Orange Polka Dot Medium
(72, 11.99, 200), -- Orange Argyle Large
(73, 12.99, 50),  -- Orange Checked Small
(74, 10.99, 80),  -- Orange Graphic Medium
(75, 10.99, 80),  -- Orange Floral Large
(76, 11.99, 60),  -- Orange Geometric Extra Large
(77, 10.99, 90),  -- Orange Swirled Medium
(78, 9.99, 110),  -- Orange Textured Small
(79, 9.99, 100),  -- Pink Striped Small
(80, 10.99, 150), -- Pink Polka Dot Medium
(81, 11.99, 200), -- Pink Argyle Large
(82, 12.99, 50),  -- Pink Solid Extra Large
(83, 10.99, 80),  -- Pink Checked Small
(84, 10.99, 80),  -- Pink Graphic Medium
(86, 11.99, 60),  -- Pink Geometric Extra Large
(87, 10.99, 90),  -- Pink Swirled Medium
(88, 9.99, 110),  -- Pink Textured Small
(89, 9.99, 100),  -- Brown Striped Small
(90, 10.99, 150), -- Brown Polka Dot Medium
(91, 11.99, 200), -- Brown Argyle Large
(92, 12.99, 50),  -- Brown Solid Extra Large
(93, 10.99, 80),  -- Brown Graphic Medium
(94, 10.99, 80),  -- Brown Floral Large
(95, 11.99, 60),  -- Brown Geometric Extra Large
(96, 10.99, 90),  -- Brown Swirled Medium
(97, 9.99, 110),  -- Brown Textured Small
(98, 9.99, 100)  -- Red Houndstooth Small";

if ($conn->query($sql) === TRUE) {
  echo "Table entries created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

</body>
</html>