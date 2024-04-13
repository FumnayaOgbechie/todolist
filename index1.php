<?php
session_start();
$server = mysqli_connect("localhost","root","","todolist");
if(!$server){
    echo"Connection Failed";
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
</head>
<body>
    <div>
        <section>
            <h2><i class="fa-solid fa-rocket"></i>to<span>do</span></h2>
        </section>
        <?php
        if(isset($_POST['submit'])){
            $title = $_POST['title'];
            $sql = "INSERT INTO `todolistcontents`(`title`) VALUES ('$title')";
            $sql_query = mysqli_query($server,$sql);

        }
        ?>
        <div class="content">
            <div class="search">
                <form method="post">
                    <input type="text" name="title"placeholder="New Task?">
                    <button type="submit" name="submit">Add<i class="fa-solid fa-circle-plus"></i></button>
                </form>
            </div>
            <?php
            function getTotalTasks($server)
            {
                $sql = "SELECT COUNT(*) AS total FROM `todolistcontents`";
                $result = mysqli_query($server, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['total'];
            }
            
            function getCheckedTasks($server)
            {
                $sql = "SELECT COUNT(*) AS checked_stat FROM `todolistcontents` WHERE `checked` = 1";
                $result = mysqli_query($server, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['checked_stat'];
            }
            
            $totalTasks = getTotalTasks($server);
            $checkedTasks = getCheckedTasks($server);
            ?>
            ?>
            <div class="onediv">
                <div class="note">
                    <span class="span1">Number of Tasks <button><?php echo($totalTasks)?></button></span>
                    <span class="span2">Completed Tasks <button><?php echo($checkedTasks)?></button></span>
                </div>
                <hr>
                <div class="todos">
                    <?php
                    $sql_query = "SELECT * FROM `todolistcontents`";
                    $sql_query_run = mysqli_query($server, $sql_query);
                    $num_tables = mysqli_num_rows($sql_query_run);
                    if ($num_tables >= 1) {
                        while ($a = mysqli_fetch_assoc($sql_query_run)) {
                            $title = $a['title'];
                            $time = $a['date_time'];
                            $id = $a['id'];
                    ?>
                            <div class='card' id='task_<?php echo $id; ?>'>
                                <input type="checkbox" onclick="updateTask(<?php echo $id; ?>)">
                                <span><?php echo $title; ?></span>
                                <small>created: <?php echo $time; ?></small>
                                <a href='<?php echo("delete.php?delete=$id")?>'class='delete'><i class='fa-solid fa-trash-can'></i></a>
                                <br>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateTask(taskId) {
            var checkbox = document.getElementById('task_' + taskId).getElementsByTagName('input')[0];
            var title = document.getElementById('task_' + taskId).getElementsByTagName('span')[0];
            
            if (checkbox.checked) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText == 'success') {
                            title.style.textDecoration = 'line-through';
                        }
                    }
                };
                xhr.send('taskId=' + taskId);
            }
        }
    </script>
</body>
</html>