<?php
include "function.php";
$pagetitle = "Users";
include "head.php";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

$sql = "SELECT * FROM UserData";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();
?>

<div class="users">
    <h2>Users</h2>

    <a href="add_user.php">Add User</a>

    <table>
        <tr>
            <th>Username</th>
            <th>Description</th>
        </tr>
        <?php
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user->username) . "</td>";
            echo "<td>" . htmlspecialchars($user->userdescription) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>