<?php
//index.php
include 'connect.php';
include 'header.php';

$sql = "SELECT  *
   FROM categories
   INNER JOIN topics
   ON categories.cat_id = topics.topics_cat;";


$result = mysqli_query($conn, $sql);
if(isset($_SESSION['signed_in']) == false)
{
    //the user is not signed in
    header("Location: signin.php");
    exit();
}
else{
    $sql_vaccine = "SELECT  user_vaccination
   FROM users
    WHERE users.user_id=".$_SESSION['user_id']
    ;
    $result_vaccine=mysqli_query($conn, $sql_vaccine);
    $row_vaccine = mysqli_fetch_assoc($result_vaccine);
    echo("<h1>Welcome ".$_SESSION['user_name']. "</h1>");
    if ($row_vaccine['user_vaccination']==2) {
        echo "<h3 class='sub-head'>Your vaccination status: You are fully vaccinated</h3>";
    } else {
        echo "<h3 class='sub-head'>Your vaccination status : " . $row_vaccine['user_vaccination']." doses.\n";
        echo "Get your vaccination status updated</h3>";
        echo '<form class="vaccine-link" method="post" action="vaccination-update.php"><input  name="certificate_link" required type="url" placeholder="Add link to your vaccination certificate uploaded on google drive"></input><button type="submit">Submit</button></form>';
    }
    
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        // echo '<h1>Discover Resources</h1>';
        echo '<table border="1">
              <tr>
                <th>Category</th>
                <th>Topic</th>
              </tr>';

        while($row = mysqli_fetch_assoc($result))
        {
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo '<h5><a href="category.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h5>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                            echo '<h5><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h5>';;
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
