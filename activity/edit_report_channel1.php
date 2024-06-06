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
        $dbh->beginTransaction();

        $sth = $dbh->prepare("SELECT * FROM dailyreport WHERE channelid = 1 AND DATE(created_at) = :created_at");
        $sth->execute([':created_at' => $date]);
        $reports = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($reports)) {
            // Update existing reports
            foreach ($_POST['user_activity'] as $userid => $active) {
                $sth = $dbh->prepare("UPDATE dailyreport SET active = :active WHERE channelid = 1 AND userid = :userid AND DATE(created_at) = :created_at");
                $sth->execute([':active' => $active, ':userid' => $userid, ':created_at' => $date]);
            }
        } else {
            // Insert new reports
            $sth = $dbh->prepare("INSERT INTO dailyreport (channelid, userid, active, created_at) VALUES (:channelid, :userid, :active, :created_at)");

            foreach ($_POST['user_activity'] as $userid => $active) {
                $sth->execute([':channelid' => 1, ':userid' => $userid, ':active' => $active, ':created_at' => $date]);
            }
        }

        $dbh->commit();
        header("Location: report1.php");
        exit;
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

$sth_user = $dbh->prepare("SELECT * FROM userdata");
$sth_user->execute();
$users = $sth_user->fetchAll(PDO::FETCH_ASSOC);

$reportMap = [];
if (!empty($reports)) {
    foreach ($reports as $report) {
        $reportMap[$report['userid']] = $report;
    }
}
?>

<div class="add-report">
    <h1>Edit Report for <?php echo date('l, F jS, Y', strtotime($date)); ?></h1>
    <form action="edit_report_channel1.php?date=<?php echo $date; ?>" method="post">
        <ul>
            <?php
            foreach ($users as $user) {
                $userid = $user['userid'];
                $isActive = isset($reportMap[$userid]) ? $reportMap[$userid]['active'] : 0;
                $checked = $isActive ? 'checked' : '';
                echo '<li>';
                echo '<label>';
                echo '<input type="checkbox" name="user_activity[' . $userid . ']" value="1" ' . $checked . '> ' . $user['username'];
                echo '</label>';
                echo '</li>';
            }
            ?>
        </ul>
        <button type="submit">Save Report</button>
    </form>
</div>