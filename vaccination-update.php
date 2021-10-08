<?php
include 'connect.php';
include 'header.php';
if(isset($_POST['certificate_link']))
{

$message_to_encrypt = $_POST['certificate_link'];
$encrypted_message =  base64_encode($message_to_encrypt); 
    $sql = "INSERT INTO
    approve_vaccination(user_id,certificate_link)
    VALUES('" . mysqli_real_escape_string($conn, $_SESSION['user_id']) . "',
                       '" . mysqli_real_escape_string($conn, $encrypted_message) . "'
                        )";
    $result = mysqli_query($conn, $sql);
    // echo $result;
    // var_dump($result);
    if(!$result)
    {
        echo 'Something went wrong while deleting post. Please try again later.';
        // echo mysqli_error($conn); //debugging purposes, uncomment when needed
    }
    else
    {
        echo 'Request Successfully Generated. It will be processed soon. <a href="index.php">Back to home page</a>  :-)';
    }
  }
  else{
    header("Location: index.php");
    exit();
  }
?>
<?php
include 'footer.php';
?>