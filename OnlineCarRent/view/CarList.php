<?php

session_start();

require_once "../model/db.php";
require_once "../model/CarModel.php";


// ALL CARS

$cars = getAllCars($conn);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Car List</title>

</head>

<body>

    <h2>Car List</h2>

    <a href="AddCar.php">

        Add New Car

    </a>

    |

    <a href="AdminDashboard.php">

        Back to Dashboard

    </a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Model</th>
            <th>Type</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>

        </tr>

        <?php if (!empty($cars) && is_array($cars)): ?>
            <?php foreach($cars as $car){ ?>

            <tr>

                <td><?= htmlspecialchars($car['id']) ?></td>

                <td><?= htmlspecialchars($car['name']) ?></td>

                <td><?= htmlspecialchars($car['model']) ?></td>

                <td><?= htmlspecialchars($car['type']) ?></td>

                <td><?= htmlspecialchars($car['price_per_day']) ?></td>

                <td><?= htmlspecialchars($car['availability_status']) ?></td>

                <td>

                    <a href="EditCar.php?id=<?= urlencode($car['id']) ?>">

                        Edit

                    </a>

                    |

                    <a href="DeleteCar.php?id=<?= urlencode($car['id']) ?>">

                        Delete

                    </a>

                </td>

            </tr>

            <?php } ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">No cars found in the database.</td>
            </tr>
        <?php endif; ?>

    </table>

</body>

</html>