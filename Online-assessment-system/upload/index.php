<?php require '../config.php';
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: ../login_teacher.php");
} ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Upload Student Data</title>
  <link rel="stylesheet" href="../teachers/css/dash.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <style>
    .upload-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .upload-container h2 {
      margin-top: 0;
      font-size: 24px;
      text-align: center;
      margin-bottom: 20px;
    }

    .upload-form {
      text-align: center;
    }

    .upload-form input[type="file"] {
      display: none;
    }

    .upload-form label {
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .upload-form label:hover {
      background-color: #0056b3;
    }

    .upload-form button {
      margin-top: 20px;
      background-color: #28a745;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .upload-form button:hover {
      background-color: #218838;
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
        <a href="../teachers/dash.php">
          <i class='bx bx-grid-alt'></i>
          <span class="links_name">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="../teachers/exams.php">
          <i class='bx bx-book-content'></i>
          <span class="links_name">Exams</span>
        </a>
      </li>
      <li>
          <a href="./pracexam.php" >
            <i class='bx bx-book-content' ></i>
            <span class="links_name">Practical Exams</span>
          </a>
        </li>
      <li>
        <a href="../teachers/results.php">
          <i class='bx bxs-bar-chart-alt-2'></i>
          <span class="links_name">Results</span>
        </a>
      </li>
      <li>
        <a href="../teachers/records.php">
          <i class='bx bxs-user-circle'></i>
          <span class="links_name">Records</span>
        </a>
      </li>
      <li>
        <a href="../teachers/messages.php">
          <i class='bx bx-message'></i>
          <span class="links_name">Messages</span>
        </a>
      </li>
      <li>
        <a href="../teachers/settings.php">
          <i class='bx bx-cog'></i>
          <span class="links_name">Settings</span>
        </a>
      </li>
      <li>
        <a href="../upload/index.php" class="active">
          <i class='bx bx-file'></i>
          <span class="links_name">Upload</span>
        </a>
      </li>
      <li>
        <a href="../teachers/help.php">
          <i class='bx bx-help-circle'></i>
          <span class="links_name">Help</span>
        </a>
      </li>
      <li class="log_out">
        <a href="../logout.php">
          <i class='bx bx-log-out-circle'></i>
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
        <img src="<?php echo $_SESSION['img']; ?>" alt="pro">
        <span class="admin_name"><?php echo $_SESSION['fname']; ?></span>
      </div>
    </nav>
    <div class="home-content">

      <div class="stat-boxes">
        <div class="recent-stat box" style="width:100%">
          <div class="title">Upload Student Data</>
          </div>
          <div class="upload-container">
            <h2>Upload Student Data</h2>
            <form class="upload-form" action="" method="post" enctype="multipart/form-data">
              <input type="file" name="excel" id="excel" required>
              <label for="excel">Choose File</label>
              <button type="submit" name="import">Upload</button>
            </form>
          </div>
          <!-- <hr> -->
          <br><br>
          <table border=2>

            <tr>
              <td>#</td>
              <td>Name</td>
              <td>Passworde</td>
              <td>fname</td>
              <td>dob</td>
              <td>gender</td>
              <td>email</td>
            </tr>

            <?php
            $i = 1;
            $rows = mysqli_query($conn, "SELECT * FROM student");
            foreach ($rows as $row) :
            ?>
              <tr>
                <td> <?php echo $i++; ?> </td>
                <td> <?php echo $row["uname"]; ?> </td>
                <td> <?php echo $row["pword"]; ?> </td>
                <td> <?php echo $row["fname"]; ?> </td>
                <td> <?php echo $row["dob"]; ?> </td>
                <td> <?php echo $row["gender"]; ?> </td>
                <td> <?php echo $row["email"]; ?> </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>


    <!-- PHP CODE FOR UPLOAD FILE -->
    <?php
    if (isset($_POST["import"])) {
      $fileName = $_FILES["excel"]["name"];
      $fileExtension = explode('.', $fileName);
      $fileExtension = strtolower(end($fileExtension));
      $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

      $targetDirectory = "uploads/" . $newFileName;
      move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

      error_reporting(0);
      ini_set('display_errors', 0);

      require 'excelReader/excel_reader2.php';
      require 'excelReader/SpreadsheetReader.php';

      $reader = new SpreadsheetReader($targetDirectory);
      foreach ($reader as $key => $row) {
        $uname = $row[0];
        $pword = $row[1];
        $fname = $row[2];
        $dob = $row[3];
        $gender = $row[4];
        $email = $row[5];
        mysqli_query($conn, "INSERT INTO student VALUES('', '$uname', '$pword', '$fname', '$dob', '$gender', '$email')");
      }

      echo
      "
			<script>
			alert('Succesfully Imported');
			document.location.href = '';
			</script>
			";
    }
    ?>



    <script src="../js/script.js"></script>

</body>

</html>