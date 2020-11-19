<?php

$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");


$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get params
$search_query = trim(htmlspecialchars(strip_tags($_GET['country'])));
$search_query_context = trim(htmlspecialchars(strip_tags($_GET['context'])));

if ($search_query != "") {
	$matching_countries = $conn->query("SELECT * FROM countries WHERE name LIKE '%$search_query%'");
	$results = $matching_countries;
}

if ($search_query_context != "" and $search_query != "") {
	$cities = $conn->query("SELECT cities.name, cities.district, cities.population FROM cities INNER JOIN countries ON cities.country_code = countries.code WHERE countries.name = '$search_query'");
	$results = $cities;
}

?>

<?php if ($search_query == "" and $search_query_context == ""): ?>
	<table class="table">
		<thead>
			<th>Name</th>
			<th>Continent</th>
			<th>Independence</th>
			<th>Head of State</th>
		</thead>
		<tbody>
			<?php foreach ($results as $row): ?>
			  <tr>
				  <td><?= $row['name'] ?></td>
				  <td><?= $row['continent'] ?></td>
				  <td><?= $row['independence_year'] ?></td>
				  <td><?= $row['head_of_state'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php elseif ($search_query != "" and $search_query_context == ""): ?>
	<table class="table">
		<thead>
			<th>Name</th>
			<th>Continent</th>
			<th>Independence</th>
			<th>Head of State</th>
		</thead>
		<tbody>
			<?php foreach ($results as $row): ?>
			  <tr>
				  <td><?= $row['name'] ?></td>
				  <td><?= $row['continent'] ?></td>
				  <td><?= $row['independence_year'] ?></td>
				  <td><?= $row['head_of_state'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<?php if(isset($search_query_context) and $search_query_context != ""): ?>
	<table class="table">
		<thead>
			<th>Name</th>
			<th>District</th>
			<th>Population</th>
		</thead>
		<tbody>
			<?php foreach ($results as $row): ?>
			  <tr>
				  <td><?= $row['name'] ?></td>
				  <td><?= $row['district'] ?></td>
				  <td><?= $row['population'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>