<?php 
include('../config.php');

if(isset($_POST['delete_btn1']))

if(isset($_POST['delete_btn1']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM prac_list WHERE exid='$id' ";
    $query_run = mysqli_query($conn, $query);

    $query = "DELETE FROM atmptprac_list WHERE exid='$id' ";
    $query_run = mysqli_query($conn, $query);
    
    if($query_run)
    {
        header('Location: pracexam.php'); 
    }
    else
    {
        echo "<script>alert('Your Data is NOT DELETED');</script>";      
        header('Location: pracexam.php'); 
    }   


}
?>
