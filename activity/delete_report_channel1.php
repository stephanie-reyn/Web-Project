<?php
include "function.php";
include "head.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sth = $dbh->prepare("DELETE FROM dailyreport WHERE channelid = 1 AND DATE(created_at) = :created_at");
        $sth->execute([':created_at' => $date]);

        header("Location: report1.php");
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="delete-report">
    <h1>Delete Report for <?php echo date('l, F jS, Y', strtotime($date)); ?></h1>
    <form action="delete_report_channel1.php?date=<?php echo $date; ?>" method="post">
        <p>Are you sure you want to delete the report for <?php echo date('l, F jS, Y', strtotime($date)); ?>?</p>
        <button type="submit">Yes, Delete</button>
        <a href="report1.php">Cancel</a>
    </form>
</div>