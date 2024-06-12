<?php 
session_start();
if (!isset($_SESSION["user_id"])){
	header("Location: ../login_teacher.php");
}
// include '../config.php';
error_reporting(0);
$exid=$_POST['exid'];

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_eval";

$conn = mysqli_connect($hostname, $username, $password, $database);


if(!$conn = mysqli_connect($hostname, $username, $password, $database)){

 die("Database connection failed");
}

$sql = "SELECT * FROM student_files";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Results</title>
    <link rel="stylesheet" href="css/dash.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bx-diamond'></i>
      <span class="logo_name">Welcome</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="dash.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="exams.php">
            <i class='bx bx-book-content' ></i>
            <span class="links_name">Exams</span>
          </a>
        </li>
        <li>
          <a href="./pracexam.php" >
            <i class='bx bx-bracket' ></i>
            <span class="links_name">Practical Exams</span>
          </a>
        </li>
        <li>
          <a href="#" class="active">
          <i class='bx bxs-bar-chart-alt-2'></i>
            <span class="links_name">Results</span>
          </a>
        </li>
        <li>
          <a href="records.php">
           <i class='bx bxs-user-circle'></i>
            <span class="links_name">Records</span>
          </a>
        </li>
        <li>
          <a href="messages.php">
            <i class='bx bx-message' ></i>
            <span class="links_name">Messages</span>
          </a>
        </li>
        <li>
          <a href="settings.php">
            <i class='bx bx-cog' ></i>
            <span class="links_name">Settings</span>
          </a>
        </li>
        <li>
          <a href="../upload/index.php">
            <i class='bx bx-file'></i>
            <span class="links_name">Upload</span>
          </a>
        </li>
        <li>
          <a href="help.php">
            <i class='bx bx-help-circle' ></i>
            <span class="links_name">Help</span>
          </a>
        </li>
        <li class="log_out">
        <a href="../logout.php">
            <i class='bx bx-log-out-circle' ></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Teacher's Dashboard</span>
      </div>
      <div class="profile-details">
      <img src="<?php echo $_SESSION['img'];?>" alt="pro">
        <span class="admin_name"><?php echo $_SESSION['fname'];?></span>

      </div>
    </nav>

    <div class="home-content">
      <div class="stat-boxes">
      <div class="recent-stat box" style="padding: 0px 0px;width:100%;">
      <table>
        <tr>
            <th>Student Name</th>
            <th>Student ID</th>
            <th>File Name</th>
            <th>Submission Time</th>
            <th>File Content</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["file_name"] . "</td>";
                echo "<td>" . $row["submission_time"] . "</td>";
                echo "<td><a href='../students/uploads/" . $row["file_name"] . "' target='_blank'>View File</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No files uploaded yet.</td></tr>";
        }
        ?>
    </table>
  
      </div>
      </div>
      </div>
      </section>

<script src="../js/script.js"></script>


</body>
</html>