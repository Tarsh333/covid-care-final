<?php
//signin.php
include 'connect.php';
include 'header.php';


//first, check if the user is already signed in. If that is the case, there is no need to display this page
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
echo '
          <section>
<div class="image">
<img src="cv.png">
</div>
<div class="content">
<div class="form">
<h2>Login</h2>
<form method="post" action="">
<div class="inputx">
<span>Email</span>
<input type="email" name="user_email">
</div>
<div class="inputx">
<span>Password</span>
<input type="password" name="user_pass">
</div>
<br>
<div class="inputx">
<button class="submit-btn" type="submit">Sign In</button>
</div>
<br>
<div class="inputx">
<p>Do not have an account ? <a href="signup.php">Sign Up</a></p>
</div>
</form>
</div>
</div>
</section>';
        // echo '<form method="post" action="">
        //     Email: <input type="email" name="user_email" />
        //     <br>
        //     Password: <input type="password" name="user_pass">
        //     <br>
        //     <input type="submit" value="Sign in" />
        //  </form>';
    }
    else
    {
        /* so, the form has been posted, we'll process the data in three steps:
            1.  Check the data
            2.  Let the user refill the wrong fields (if necessary)
            3.  Varify if the data is correct and return the correct response
        */
        $errors = array(); /* declare the array for later use */

        if(!isset($_POST['user_email']))
        {
            $errors[] = 'The username field must not be empty.';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'The password field must not be empty.';
        }

        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
            echo '<ul>';
            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
            {
                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
            }
            echo '</ul>';
        }
        else
        {
            //the form has been posted without errors, so save it
            //notice the use of mysql_real_escape_string, keep everything safe!
            //also notice the sha1 function which hashes the password
            $sql = "SELECT
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_email = '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";

            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'Something went wrong while signing in. Please try again later.';
                echo mysqli_error($conn); //debugging purposes, uncomment when needed
            }
            else
            {
                //the query was successfully executed, there are 2 possibilities
                //1. the query returned data, the user can be signed in
                //2. the query returned an empty result set, the credentials were wrong
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'You have supplied a wrong user/password combination. Please try again.';
                }
                else
                {
                    //set the $_SESSION['signed_in'] variable to TRUE
                    $_SESSION['signed_in'] = true;

                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
}

?>

