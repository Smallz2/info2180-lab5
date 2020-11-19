<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");


$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$search_query = trim(htmlspecialchars(strip_tags($_GET['country'])));

$matching_countries = $conn->query("SELECT * FROM countries WHERE name LIKE '%$search_query%')");

if ($search_query != "") {
	$results = $matching_countries;
}

?>
<table class="table">
	<thead>
		<th>Name</th>
		<th>Continent</th>
		<th>Independence</th>
		<th>Head of State</th>
	</thead>
	<tbody>
		<?php if (empty($results)): ?>
			<tr>
				<td colspan="4">Nothing found</td>
			</tr>
		<?php else: ?>
			<?php foreach ($results as $row): ?>
			  <tr>
				  <td><?= $row['name'] ?></td>
				  <td><?= $row['continent'] ?></td>
				  <td><?= $row['independence_year'] ?></td>
				  <td><?= $row['head_of_state'] ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
