<?php
//topic.php
include 'connect.php';
include 'header.php';
if(isset($_SESSION['signed_in']) == false)
{
    //the user is not signed in
    header("Location: signin.php");
    exit();
}
else{
//first select the topic based on $_GET['topic_id']
$sql = "SELECT
        user_name,
        user_phone,
        user_email
        FROM
        users
        WHERE
        users.user_id = " . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);

        

        if(!$result)
        {
            echo 'The User could not be displayed, please try again later.';
        }
        else
        {
            
                //prepare the table
                echo '<table border="1">
                <tr>
                <th>Name</th>
                <th>Phone no.</th>
                <th>Email</th>
                </tr>';
                
                while($row = mysqli_fetch_assoc($result))
                {
                    // var_dump($row);
                    echo '<tr>';
                        echo '<td >';
                            echo $row['user_name'];
                        echo '</td>';
                        echo '<td >';
                            echo $row['user_phone'];
                        echo '</td>';
                        echo '<td >';
                            echo $row['user_email'];
                        echo '</td>';
                       
                    echo '</tr>';
                

               
                
            
        }
    }
}

?>
<?php
include 'footer.php';
?>
