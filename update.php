<?php
// Connect to the database
$server = mysqli_connect("localhost", "root", "", "todolist");
if (!$server) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if taskId is set
if (isset($_POST['taskId'])) {
    // Get taskId from POST request
    $taskId = $_POST['taskId'];
    
    // Update task in the database
    $sql = "UPDATE todolistcontents SET checked = 1 WHERE id = $taskId";
    if (mysqli_query($server, $sql)) {
        echo "success";
    } else {
        echo "Error updating record: " . mysqli_error($server);
    }
}

// Close connection
mysqli_close($server);
?>