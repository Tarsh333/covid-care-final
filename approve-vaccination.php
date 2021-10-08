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
approve_vaccination.user_id,
approve_vaccination.certificate_link,
users.user_email,
users.user_name,
users.user_vaccination
FROM
approve_vaccination
LEFT JOIN
users
ON
approve_vaccination.user_id = users.user_id";

         

$result = mysqli_query($conn, $sql);

echo '<h1>Approve Vaccines</h1>';
if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo '<h1>No vaccinations to approve currently</h1>';
    }
    else
    {
        echo '<table border="1">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Link</th>
          <th>Doses</th>
          <th>Approve</th>
          <th>Discard</th>
        </tr>';

  while($row = mysqli_fetch_assoc($result))
  {
      $certificate=base64_decode ($row['certificate_link'])  ;
      echo '<tr>';
          echo '<td >';
              echo  $row['user_name'];
          echo '</td>';
          echo '<td >';
              echo  $row['user_email'];
          echo '</td>';
          echo '<td >';
              echo  '<a target="_blank" href='.$certificate.'>'.$certificate.'</a>';
          echo '</td>';
          echo '<td >';
              echo  $row['user_vaccination'];
          echo '</td>';
          echo '<td >';
          echo  '<form method="post" action="update-vaccination.php">';
          echo '<input type="hidden" name="user_id" value="'.$row['user_id'].'"></input>';
              echo  '<button>Approve</button>';
              echo  '</form>';
          echo '</td>';
          echo '<td >';
          echo  '<form method="post" action="discard-vaccination.php">';
          echo '<input type="hidden" name="user_id" value="'.$row['user_id'].'"></input>';
              echo  '<button>Discard</button>';
              echo  '</form>';
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