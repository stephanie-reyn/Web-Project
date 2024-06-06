<?php
include "function.php";
include "head.php";
$pagetitle = "Add User";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $description = $_POST['userdescription'];

    $sql = "INSERT INTO UserData (username, userdescription) VALUES (:username, :userdescription)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':userdescription' => $description
    ]);

    header('Location: profile.php');
    exit;
}
?>

<div class="add_user">
    <h2>Add User</h2>
    <form action='add_user.php' method="post">
        <input type="text" name="username" id="username" placeholder="Username">
        <br>
        <input type="userdescription" name="userdescription" id="userdescription" placeholder="Describe User"></input>
        <br>
        <button type="submit">Add User</button>
    </form>
</div>