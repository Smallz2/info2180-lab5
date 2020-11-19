<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");


$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$search_query = trim(htmlspecialchars(strip_tags($_GET['country'])));


$matching_countries = $conn->query("SELECT * FROM countries WHERE name LIKE '%$search_query%'");

?>
<ul>
<?php foreach ($matching_countries as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
