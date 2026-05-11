<?php
// DB CONNECTION
$conn = mysqli_connect("localhost", "root", "", "online_car_rental");

// CHECK CONNECTION
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// FETCH DATA
$sql = "SELECT * FROM cars";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cars Check</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        img {
            width: 100px;
        }
    </style>
</head>
<body>

<h2>Cars Table Data (Test Page)</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Model</th>
        <th>Type</th>
        <th>Price/Day</th>
        <th>Status</th>
        <th>Image</th>
        <th>Description</th>
    </tr>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['model']; ?></td>
        <td><?php echo $row['type']; ?></td>
        <td><?php echo $row['price_per_day']; ?></td>
        <td><?php echo $row['availability_status']; ?></td>
        <td>
            <img src="uploads/<?php echo $row['image_path']; ?>" alt="car">
        </td>
        <td><?php echo $row['description']; ?></td>
    </tr>

<?php
    }
} else {
    echo "<tr><td colspan='8'>No data found</td></tr>";
}
?>

</table>

</body>
</html>