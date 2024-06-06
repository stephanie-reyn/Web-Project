<?php
include "function.php";
include "head.php";
$pagetitle = "Login";

// Define fixed usernames and passwords
$users = array(
    "admin" => "asecret"
);

// Function to check if username and password match
function check_login($username, $password)
{
    global $users;
    return isset($users[$username]) && $users[$username] === $password;
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are correct
    if (check_login($username, $password)) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        // Redirect to login.php with an error message indicating login failure
        header('Location: login.php?error=login');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="login-form">
        <div class="login">
            <h2>Welcome</h2>
            <?php
            // Check if there is an error message for accessing a restricted page without login in the URL parameters
            if (isset($_GET['error']) && $_GET['error'] === 'access') {
                echo '<p>Login required. Please log in to access this page.</p>';
            } elseif (isset($_GET['error']) && $_GET['error'] === 'login') {
                // Check if there is an error message for incorrect login credentials in the URL parameters
                echo '<p>Login failed. Please try again.</p>';
            }
            ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
                <br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>

</body>

</html>