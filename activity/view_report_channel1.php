<?php
include "function.php";
include "head.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

$date = $_GET['date'];

try {
    $sth = $dbh->prepare("SELECT * FROM userdata");
    $sth->execute();
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth_report = $dbh->prepare("SELECT * FROM dailyreport WHERE channelid = 1 AND DATE(created_at) = :date");
    $sth_report->bindParam(':date', $date);
    $sth_report->execute();
    $reports = $sth_report->fetchAll(PDO::FETCH_ASSOC);

    if (count($reports) == 0) {
        echo "<p>No reports found for the selected date.</p>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<div class="view-report">
    <div class="view-details">
        <h2>Channel 1 Report for <?php echo date('l, F jS, Y', strtotime($date)); ?></h2>
        <table>
            <tr>
                <th>User</th>
                <th>Status</th>
            </tr>
            <?php
            foreach ($users as $user) {
                $userReports = array_filter($reports, function ($report) use ($user) {
                    return $report['userid'] === $user['userid'];
                });

                if (count($userReports) > 0) {
                    $report = array_values($userReports)[0];
                    echo "<tr>";
                    echo "<td>{$user['username']}</td>";
                    echo "<td>" . ($report['active'] ? 'Active' : 'Inactive') . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <a href="report1.php">Back to Report</a>
    </div>
</div>