<!doctype html>
<html>

<head>
<title>Covid-Care</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
      <header>
        <div class="logo">
          <a href="index.php"><img src="virus.png" height="60px"/><span>Covid Care</span></a>
</div>
        <div class="links">

          
          
          <?php
      session_start();
      // var_dump($_SESSION);
      // echo $_SESSION['user_level'];
      if (isset($_SESSION['user_level'])) {
        echo ' <a class="item" href="index.php"> Home </a>
        <a class="item" href="category.php?id=8">Resources</a>';?><?php
        if (isset($_SESSION['user_level'])&&$_SESSION['user_level']==1) {
          echo '<a class="item" href="vaccination.php">View Vaccinations</a>';
          echo '<a class="item" href="approve-vaccination.php">Approve Vaccination Status</a>';}
          echo '<a class="item" href="institute-vaccination-chart.php">Institute Vaccination Chart</a>';
          echo '</div>
          <div><a href="signout.php">Sign out</a><div>';
        }
        else{
          echo '<a class="item" href="institute-vaccination-chart.php">Institute Vaccination Chart</a></div><div><a href="signup.php">SignUp</a><a href="signin.php">Login</a></div>';
        }
        
      
      ?>
      </div>
    </header>
    <div class="container">
    



