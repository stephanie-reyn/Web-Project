<?php
include "function.php";
$pagetitle = "Report";
include "header.php";
include "head.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

try {
    $sth = $dbh->prepare("SELECT * FROM userdata");
    $sth->execute();
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth_report = $dbh->prepare("SELECT * FROM dailyreport WHERE channelid = 1 AND DATE(created_at) >= DATE_TRUNC('month', CURRENT_DATE)");
    $sth_report->execute();
    $reports = $sth_report->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

<div class="report">
    <div class="channel1">
        <a href="add_report_channel1.php" class="add-report">Add Report</a>
        <h2>Channel 1 Report</h2>
        <?php
        $currentMonth = date('m');
        $currentYear = date('Y');
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf("%d-%02d-%02d", $currentYear, $currentMonth, $day);
            $formattedDate = date('l, F jS, Y', strtotime($date));
            echo "<h3>{$formattedDate}</h3>";
            echo "<div class='report-date'>";


            $activeCount = 0;
            $totalUsers = count($users);
            if (count($reports) > 0) {
                echo "<ul>";
                foreach ($users as $user) {
                    $userReports = array_filter($reports, function ($report) use ($user, $date) {
                        return $report['userid'] === $user['userid'] && substr($report['created_at'], 0, 10) === $date;
                    });

                    if (count($userReports) > 0) {
                        $report = array_values($userReports)[0];
                        if ($report['active']) {
                            $activeCount++;
                        }
                    } else {
                        $report = null;
                    }
                }
                echo "</ul>";
            } else {
                echo "<p>No reports available for this date.</p>";
            }

            echo "<p>Total active users: {$activeCount} / {$totalUsers}</p>";
            echo "<a href='view_report_channel1.php?date={$date}'>View Report</a>";
            echo "<a href='edit_report_channel1.php?date={$date}'>Edit Report</a>";
            echo "<a href='delete_report_channel1.php?date={$date}'>Delete Report</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>