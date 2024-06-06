<?php 
include "function.php";
include "head.php";
$pagetitle = "Add Channel";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $channelname = $_POST['channelname'];
    $channeldescription = $_POST['channeldescription'];

    $sql = "INSERT INTO Channel (channelname, channeldescription) VALUES (:channelname, :channeldescription)";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([
        ':channelname' => $channelname,
        ':channeldescription' => $channeldescription
    ]);

    header('Location: channel.php');
    exit;
}
?>

<div class="add_channel">
    <h2>Add Channel</h2>
    <form action='add_channel.php' method="post">
        <input type="text" name="channelname" id="channelname" placeholder="Channelname">
        <br>
        <input type="channeldescription" name="channeldescription" id="channeldescription" placeholder="Describe Channel"></input>
        <br>
        <button type="submit">Add Channel</button>
    </form>
</div>

