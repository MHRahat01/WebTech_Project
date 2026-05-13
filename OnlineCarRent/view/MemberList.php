<?php

session_start();

if(!isset($_SESSION['role'])){
    header("Location: adminlogin.php");
    exit;
}

require_once "../model/db.php";
require_once "../model/UserModel.php";

$members = getAllMembers($conn);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Member List</title>
</head>
<body>
    <h2>Members</h2>

    <a href="AdminDashboard.php">Back to Dashboard</a>
    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>

        <?php if(!empty($members) && is_array($members)): ?>
            <?php foreach($members as $member): ?>
                <tr>
                    <td><?= htmlspecialchars($member['id']) ?></td>
                    <td><?= htmlspecialchars($member['name']) ?></td>
                    <td><?= htmlspecialchars($member['email']) ?></td>
                    <td><?= htmlspecialchars($member['phone']) ?></td>
                    <td><?= htmlspecialchars($member['address']) ?></td>
                    <td><?= htmlspecialchars($member['created_at']) ?></td>
                    <td>
                        <form method="POST" action="DeleteMember.php" onsubmit="return confirm('Delete this member and all related orders/blogs?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($member['id']) ?>">
                            <button type="submit" name="delete_member">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" style="text-align:center;">No members found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
