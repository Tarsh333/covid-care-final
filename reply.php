<?php
//reply.php
include 'connect.php';
include 'header.php';
if(isset($_SESSION['signed_in']) == false)
{
    //the user is not signed in
    header("Location: signin.php");
    exit();
}
else{
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
    echo 'This file cannot be called directly.';
}
else
{
    //check for sign in status
    if(!$_SESSION['signed_in'])
    {
        echo 'You must be signed in to post a reply.';
    }
    else
    {
        // echo($_POST['reply-content']);
        // echo(date("Y/m/d"));
        // echo(mysqli_real_escape_string($conn, $_GET['id']));
        //a real user posted a real reply
        $sql = "INSERT INTO
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by)
                VALUES ('" . $_POST['reply-content'] . "',
                        NOW(),
                        " . mysqli_real_escape_string($conn, $_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";

        $result = mysqli_query($conn, $sql);
        // var_dump($result);
        if(!$result)
        {
            // echo($result);
            echo 'Your resource post has not been saved, please try again later.';
        }
        else
        {
            echo 'Your resource post has been saved, check out <a href="topic.php?id=' . htmlentities($_GET['id']) . '">the topic</a>.';
        }
    }
}
}
?>
<?php
include 'footer.php';
?>
