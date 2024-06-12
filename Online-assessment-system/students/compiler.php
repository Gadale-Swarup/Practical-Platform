<?php 
session_start();
if (!isset($_SESSION["uname"])){
	header("Location: ../login_student.php");
}

include '../config.php';
error_reporting(0);

$sql="SELECT * FROM prac_list";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Exams</title>
    <link rel="stylesheet" href="css/dash.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <style>
        .exmbtn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #4CAF50; /* Green */
  color: white;
  text-align: center;
  text-decoration: none;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.button-link:hover {
  background-color: #45a049; /* Darker Green */
}

.button-link:active {
  background-color: #3e8e41; /* Green On Click */
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
          <a href="dash.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="./exams.php">
            <i class='bx bx-book-content' ></i>
            <span class="links_name">Exams</span>
          </a>
        </li>  <li>
          <a href="#" class="active">
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
       <div class="recent-stat box" style="padding: 0px 0px; width:90%">
               <table>
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>Exam Name</th>
                            <th>Description</th>
                            <th>Exam time</th>
                            <th>Submission time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $i=1;
                        if(mysqli_num_rows($result) > 0)        
                        {  
                            while($row = mysqli_fetch_assoc($result))
                            {
                                  $exid=$row['exid'];
                                  $uname=$_SESSION['uname'];
                                  $rqst="SELECT status FROM atmptprac_list WHERE uname='$uname' AND exid='$exid'";
                                  $ret = mysqli_query($conn, $rqst);
                                  $res = mysqli_fetch_assoc($ret);
                                  $status=$res['status'];
                                  if($status=='1'){
                                    continue;
                                  }
                                  else{
                                    echo '<tr>
                                    <td>' . $i . '</td>
                                    <td>' . $row['exname'] . '</td>
                                    <td>' . $row['desp'] . '</td>
                                    <td>' . $row['extime'] . '</td>
                                    <td>' . $row['subt'] . '</td>
          
                                    <td>
                                        <form action="./uploadfile.php" method="post">
                                            <input type="hidden" name="exid" value="' . $row['exid'] . '">
                                            <input type="hidden" name="nq" value="' . $row['nq'] . '">
                                            <input type="hidden" name="subject" value="' . $row['exname'] . '">
                                            <input type="hidden" name="desp" value="' . $row['desp'] . '">
                                            <a type="btn" class="exmbtn" style="" href="http://localhost:5173/">
                                            Start
                                            </a>
                                            <button type="submit" name="edit_btn" class ="exmbtn">Upload</button>                                         
                                        </form>
                                    </td>
                                </tr>';
                                  }
                          $i++;
                            } 
                        }
                        ?>
                    </tbody>
                  
                </table>
        </div>
      </div>
    </div>
  </section>

<script src="../js/script.js"></script>


</body>
</html>

