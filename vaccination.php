<?php
//category.php
include 'connect.php';
include 'header.php';
if(isset($_SESSION['signed_in']) == false)
{
    //the user is not signed in
    header("Location: signin.php");
    exit();
}
elseif ($_SESSION['user_level']==0) {
    header("Location: index.php");
    exit();
}
else{
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            user_name,
            user_email,
            user_phone,
            user_vaccination
        FROM
            users";
         
         
         $result = mysqli_query($conn, $sql);
         
         echo '<h1>Vaccination Status</h1>';
if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<h1>No users to show</h1>';
    }
    else
    {
        echo '<table border="1">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone No</th>
          <th>Doses</th>
        </tr>';

  while($row = mysqli_fetch_assoc($result))
  {
      echo '<tr>';
          echo '<td >';
              echo  $row['user_name'];
          echo '</td>';
          echo '<td >';
              echo  $row['user_email'];
          echo '</td>';
          echo '<td >';
              echo  $row['user_phone'];
          echo '</td>';
          echo '<td >';
              echo  $row['user_vaccination'];
          echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
    }
}
}
?>
<?php
include 'footer.php';
?>

