<?php
include 'connect.php';
include 'header.php';
if(isset($_POST['post_id']))
{
    $sql="DELETE FROM posts WHERE posts.post_id = ".$_POST['post_id'];
    $result = mysqli_query($conn, $sql);
    // echo $result;
    // var_dump($result);
    if(!$result)
    {
        echo 'Something went wrong while deleting post. Please try again later.';
        echo mysqli_error($conn); //debugging purposes, uncomment when needed
    }
    else
    {
        echo 'Successfully deleted. <a href="index.php">Back to home page</a>  :-)';
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