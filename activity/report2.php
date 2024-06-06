<?php
include "function.php";
$pagetitle = "Newb";
include "head.php";
include "header.php";

if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

// Fetch user data
$sql = "SELECT * FROM UserData ORDER BY username ASC"; // Order users alphabetically
$stmt = $dbh->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_OBJ);

$sql = "SELECT * FROM DailyReport WHERE Channelid = '2' ORDER BY date(created_at) ASC";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll();

$year = date('Y');
$month = date('m');
$today = date('j');

// Fumction to calculate active days for each user
function calculateActiveDays($userId, $reports)
{
    $activeDaysCount = 0;
    foreach ($reports as $report) {
        if ($report->userid == $userId && $report->active == true) {
            $activeDaysCount++;
        }
    }
    return $activeDaysCount;
}

// Function to check if a user was active on a specific day
function wasUserActive($userId, $day, $reports)
{
    foreach ($reports as $report) {
        // Check if the report matches the user ID and the date
        if ($report->userid == $userId && date('Y-m-d', strtotime($report->created_at)) == $day && $report->active == true) {
            return true; // User was active on the specified day
        }
    }
    return false; // User was not active on the specified day
}

echo "<h1>Beginner Help</h1>";
echo "<a href='add_report_channel2.php' class='add-report'>Add Report</a>";

// Display the detailed activity table
echo "<table border='1' style='margin-top:20px;'>";
echo "<tr>";
echo "<th>Date</th>";

// Display username as headers
foreach ($users as $user) {
    echo "<th>" . htmlspecialchars($user->username) . "</th>";
}
echo "</tr>";
echo "<tr>";
echo "<td> Total Active Days</td>";
foreach ($users as $user) {
    $activeDays = calculateActiveDays($user->userid, $reports);
    echo "<td>" . $activeDays . ' out of ' . $today . "</td>";

}
// Display the calendar from today's date to first
for ($day = $today; $day >= 1; $day--) {
    $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $formattedDate = date('F jS', strtotime($currentDate));
    echo "<tr>";
    echo "<td>" . $formattedDate . "</td>";

    foreach ($users as $user) {
        echo "<td>";
        if (wasUserActive($user->userid, $currentDate, $reports)) {
            echo "<span style='background-color: #B6E2A1'>✔</span>";
        } else {
            echo "<span style='background-color: #F7A4A4'>✘</span>";
        }
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>