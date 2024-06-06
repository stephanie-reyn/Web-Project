<?php
include "function.php";
$pagetitle = "Dashboard";
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

// Fetch daily reports for a specific channel
$sql = "SELECT * FROM DailyReport WHERE channelid = '1' ORDER BY date(created_at) ASC"; // Order reports by date
$stmt = $dbh->prepare($sql);
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_OBJ);

// Get the current year, month, and today's day
$year = date('Y');
$month = date('m');
$today = date('j'); // Day of the month without leading zeros

// Function to calculate active days for each user
function calculateActiveDays($userId, $reports)
{
    $activeDaysCount = 0;
    foreach ($reports as $report) {
        // Check if the report matches the user ID and is active
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


echo "<h1>Dashboard</h1>";
echo "<a href='add_report_channel1.php' class='add-report'>Add Report</a>";

// Display the detailed activity table
echo "<table border='1' style='margin-top:20px;'>";
echo "<tr>";
echo "<th>Date</th>";

// Display usernames as table headers
foreach ($users as $user) {
    echo "<th>" . htmlspecialchars($user->username) . "</th>";
}
echo "</tr>";
echo "<tr>";
echo "<td>Total Active Days</td>";
foreach ($users as $user) {
    $activeDays = calculateActiveDays($user->userid, $reports);
    echo "<td>" . $activeDays . ' out of ' . $today . "</td>";
}

// Display the calendar from today's date to the 1st
for ($day = $today; $day >= 1; $day--) {
    $currentDate = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $formattedDate = date('F jS', strtotime($currentDate));
    echo "<tr>";
    echo "<td>" . $formattedDate . "</td>";

    // Check each user's activity for the current date
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