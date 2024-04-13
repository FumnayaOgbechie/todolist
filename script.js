function updateTask(taskId) {
    var checkbox = document.getElementById('task_' + taskId).getElementsByTagName('input')[0];
    var title = document.getElementById('task_' + taskId).getElementsByTagName('span')[0];
    
    // Check if the checkbox is checked
    if (checkbox.checked) {
        // Make AJAX request to update the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_task.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // If the update is successful, cross out the title
                if (xhr.responseText == 'success') {
                    title.style.textDecoration = 'line-through';
                }
            }
        };
        xhr.send('taskId=' + taskId);
    }
}
<?php
            function addTask($title) {
                global $server;
                $title = mysqli_real_escape_string($server, $title);
                $sql = "INSERT INTO `task_stat` (title) VALUES ('$title')";
                if (mysqli_query($server, $sql)) {
                    return true;
                } else {
                    return false;
                }
            }
            
            // Function to update a task as checked
            function updateTask($taskId) {
                global $server;
                $sql = "UPDATE task_stat SET checked_tasks = 1 WHERE id = $taskId";
                if (mysqli_query($server, $sql)) {
                    return true;
                } else {
                    return false;
                }
            }
            
            // Function to get the total number of tasks
            function getTotalTasks() {
                global $server;
                $sql = "SELECT COUNT(*) AS total FROM task_stat";
                $result = mysqli_query($server, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            }
            
            // Function to get the number of tasks checked
            function getCheckedTasks() {
                global $server;
                $sql = "SELECT COUNT(*) AS checked_stat FROM task_stat WHERE checked_tasks = 1";
                $result = mysqli_query($server, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['checked_stat'];
            }
            
            // Example usage:
            $totalTasks = getTotalTasks();
            $checkedTasks = getCheckedTasks();
            ?>