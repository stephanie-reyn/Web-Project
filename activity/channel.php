<?php
include "function.php";
include "head.php";
$pagetitle = "Channel";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

$sql = "SELECT * FROM Channel";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$channels = $stmt->fetchAll();
?>

<div class="channel">
    <h2>Channel</h2>

    <a href="add_channel.php">Add Channel</a>

    <table>
        <tr>
            <th>Channelname</th>
            <th>Description</th>
        </tr>
        <?php
        foreach ($channels as $channel) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($channel->channelname). "</td>";
            echo "<td>" . htmlspecialchars($channel->channeldescription) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>