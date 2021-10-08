<?php
//signup.php
include 'connect.php';
include 'header.php';


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
      echo '
          <section>
<div class="image">
<img src="e.jpg">
</div>
<div class="content">
<div class="form">
<h2>Signup</h2>
<form name="myForm" method="post" action="" onSubmit="return validateForm()">
<div class="inputx">
<span>Username</span>
<input type="text" name="user_name">
</div>
<div class="inputx">
<span>Email</span>
<input type="email" name="user_email">
</div>
<div class="inputx">
<span>Password</span>
<input type="password" name="user_pass">
</div>
<div class="inputx">
<span>Repeat Password</span>
<input type="password" name="user_pass_check">
</div>
<div class="inputx">
<span>Phone No:</span>
<input type="tel" name="user_phone">
</div>
<div class="inputx">
<span>Blood Group</span>
<select name="user_blood_group" >
            <option value="A+" selected>A+</option><option value="A-">A-</option>
            <option value="B+">B+</option><option value="B-">B-</option>
            <option value="O+">O+</option><option value="O-">O-</option>
            <option value="AB+">AB+</option><option value="AB-">AB-</option>
</select>
</div>
<br>
<div class="inputx">
<button class="submit-btn" type="submit">Sign Up</button>
</div>
<br>
<div class="inputx">
<p>Already have an account ? <a href="signin.php">Sign In</a></p>
</div>
</form>
</div>
</div>
</section>';
  
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data
    */
    $errors = array(); /* declare the array for later use */

    if(isset($_POST['user_name']))
    {
        //the user name exists
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }


    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
    $sql = "SELECT
    user_email
    FROM
    users
    WHERE
    user_email = '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) != 0) {
        echo("User already registered");
    }
    else if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo 'Some fields are not filled correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    }
    else
    {
        // var_dump($_POST);
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_phone,user_blood_group)
                VALUES('" . mysqli_real_escape_string($conn, $_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "',
                       '" . mysqli_real_escape_string($conn, $_POST['user_phone']) . "',
                       '" . mysqli_real_escape_string($conn, $_POST['user_blood_group']) . "'
                        )";

        $result = mysqli_query($conn ,$sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later.';
            echo mysqli_error($conn); //debugging purposes, uncomment when needed
        }
        else
        {
            echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
        }
    }
}
echo '<script>function validateForm() {
    var phoneno = /^\d{10}$/;
    let phone = document.forms["myForm"]["user_phone"].value;
    let p1 = document.forms["myForm"]["user_pass"].value;
    let p2 = document.forms["myForm"]["user_pass_check"].value;
    let email = document.forms["myForm"]["user_email"].value;
    if (!phone.match(phoneno)) {
      alert("Invalid Phone Number");
      return false;
    }
    else if(!(/^([A-Za-z0-9_\-\.])+\@([iiitdmj|IIITDMJ])+\.(ac)+\.(in)$/.test(email))){
        alert("Only IIITDMJ email Ids are accepted")
        return false;
  }
    else if(p1!=p2){
        alert("Passwords do not match")
        return false;
  }
}
 </script> '
?>
