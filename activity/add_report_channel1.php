<?php
include "function.php";
include "head.php";

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php?error=access');
    exit;
}

// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Prepare SQL statement
        $sth = $dbh->prepare("INSERT INTO dailyreport (channelid, userid, active, created_at) VALUES (:channelid, :userid, :active, :created_at)");

        // Set the channelid (assuming channelid 1)
        $channelid = 1;

        // Set the created_at date
        $created_at = $_POST['created_at']; // Assuming you're sending the date from the form

        // Retrieve user data from the database
        $sth_user = $dbh->prepare("SELECT * FROM userdata");
        $sth_user->execute();
        $users = $sth_user->fetchAll(PDO::FETCH_ASSOC);

        // Iterate through each user and insert data into dailyreport
        foreach ($users as $user) {
            $userid = $user['userid'];
            // Check if the checkbox for this user is checked
            if (isset($_POST['user_activity'][$userid])) {
                // If checked, set active to 1
                $active = 1;
            } else {
                // If not checked, set active to 0
                $active = 0;
            }
            // Bind parameters
            $sth->bindParam(':channelid', $channelid);
            $sth->bindParam(':userid', $userid);
            $sth->bindParam(':active', $active);
            $sth->bindParam(':created_at', $created_at);

            // Execute the statement
            $sth->execute();
        }

        // Redirect after successful insertion
        header('Location: report1.php');
        exit;
    } catch (Exception $e) {
        if ($e->getCode() == '23000') {
            echo "You have already submitted a report for today.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>


<div class="add-report">
    <h1>Add Report Channel 1</h1>
    <form action="add_report_channel1.php" method="post" id="reportForm">
        <label>
            <input type="checkbox" id="selectAll"> Select All
        </label>
        <!-- Container for the selected users -->
        <ul id="selectedUsers"></ul>
        <!-- Container for the unselected users -->
        <ul id="unselectedUsers">
            <?php
            // Retrieve user data from the database
            $sth = $dbh->prepare("SELECT * FROM userdata");
            $sth->execute();
            $users = $sth->fetchAll(PDO::FETCH_ASSOC);

            echo "<input type='hidden' name='channelid' value='1'>";
            echo "<input type='date' name='created_at' value='" . date('Y-m-d') . "'>";

            // Display users with checkboxes for activity
            foreach ($users as $user) {
                echo '<li>';
                echo '<label>';
                echo '<input type="checkbox" class="userCheckbox" name="user_activity[' . $user['userid'] . ']" value="1"> ' . $user['username'];
                echo '</label>';
                echo '</li>';
            }
            ?>
        </ul>

        <button type="submit">Add Report</button>
        <button type="button" onclick="window.location.href='report1.php'">Cancel</button>
    </form>
</div>

