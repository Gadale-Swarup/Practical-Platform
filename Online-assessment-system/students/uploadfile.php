<?php 
date_default_timezone_set('Asia/Kolkata');
session_start();
if (!isset($_SESSION["uname"])){
	header("Location: ../login_student.php");
}

include '../config.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Exams</title>
    <link rel="stylesheet" href="css/dash.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>/* Style the form container */
form {
    width: 50%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style the form headings */
h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Style form labels */
label {
    display: block;
    margin-bottom: 5px;
}

/* Style form input fields */
input[type="text"], input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-sizing: border-box;
}

/* Style the submit button */
input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Style error messages */
.error {
    color: red;
    margin-top: 5px;
}
</style>
</head>
<body>
<div class="sidebar">
    <div class="logo-details">
      <i class='bx bx-diamond'></i>
      <span class="logo_name">Welcome</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="./dash.php">
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
          <!-- <a href="http://localhost:5173/" > -->
          <a href="./compiler.php" class="active" >
            <i class='bx bx-bracket' ></i>
            <span class="links_name">Compiler</span>
          </a>
        </li>
        <li>
          <a href="results.php">
          <i class='bx bxs-bar-chart-alt-2'></i>
            <span class="links_name">Results</span>
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
        <span class="dashboard">Student Dashboard</span>
      </div>
      <div class="profile-details">
        <img src="<?php echo $_SESSION['img'];?>" alt="pro">
        <span class="admin_name"><?php echo $_SESSION['fname'];?></span>
      </div>
    </nav>

    <div class="home-content">
      <div class="stat-boxes">
      <div class="recent-stat box">
   
      <form action="uploadfile.php" method="post" enctype="multipart/form-data">
        <label for="name">Student Name:</label><br>
        <input type="text" id="name" name="name"><br>
        
        <label for="student_id">Student ID:</label><br>
        <input type="text" id="student_id" name="student_id"><br>
        
        <label for="file">Select File:</label><br>
        <input type="file" id="file" name="file"><br><br>
        
        <input type="submit" value="Upload">
    </form>
      
        </div>
      </div>
    </div>
  </section>
  <?php
// Database connection
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $database = "db_eval";

// $conn = mysqli_connect($hostname, $username, $password, $database);


// if(!$conn = mysqli_connect($hostname, $username, $password, $database)){

//  die("Database connection failed");
// } 
// <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    
    // File upload
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    
    // Move uploaded file to desired directory
    $upload_dir = "../students/uploads/";
    $final_file_path = $upload_dir . $file_name;
    move_uploaded_file($file_tmp, $final_file_path);

    // Insert data into database
    $sql = "INSERT INTO student_files (student_name, student_id, file_name, submission_time)
            VALUES ('$name', '$student_id', '$file_name', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
// ?>


</body>
</html>

