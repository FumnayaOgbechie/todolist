<?php
session_start();
$server = mysqli_connect("localhost","root","","todolist");
if(!$server){
    echo("<script>console.log('Connection Failed')");
}
if(isset($_GET['delete'])){
    $id =$_GET['delete'];

$thoni = "DELETE FROM `todolistcontents` WHERE `id` =$id";
$query = mysqli_query($server,$thoni);

if ($query){
    $_SESSION['success'] = "Record has been deleted";
    header("Location:index1.php");
    exit();
}else{
    $_SESSION['failure'] = " Could not delete record";
    header("Location:index1.php");
    exit();
}
}
?>