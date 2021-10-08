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
        topic_id,
        topic_subject
        FROM
        topics
        WHERE
        topics.topic_id = " . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'The topic could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This topic does not exist.';
    }
    else
    {
        //display category data
        // echo(mysqli_num_rows($result));
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Posts in ' . $row['topic_subject'] . ' topic</h2>';
            $topic_id=$row['topic_id'];
            // var_dump($row);
        }

        //do a query for the posts
        $sql = "SELECT
                posts.post_id,
                posts.post_topic,
                posts.post_content,
                posts.post_date,
                posts.post_by,
                users.user_id,
                users.user_name
                FROM
                posts
                LEFT JOIN
                users
                ON
                posts.post_by = users.user_id
                WHERE
                posts.post_topic = " . mysqli_real_escape_string($conn, $_GET['id']);

        $result = mysqli_query($conn, $sql);
        // var_dump(mysqli_fetch_assoc($result));

        if(!$result)
        {
            echo 'The topic could not be displayed, please try again later.';
        }
        else
        {
            echo '<form class="vaccine-link" method="post" action="reply.php?id=' . $topic_id . '">
            <input name="reply-content" required placeholder="Enter Some detail"></input>
            <button type="submit" />Post Resource</button>
        </form>';
            if(mysqli_num_rows($result) == 0)
            {
                echo 'This topic is empty.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                <tr>
                <th>Post</th>
                <th>Date and user name</th>
                </tr>';
                
                while($row = mysqli_fetch_assoc($result))
                {
                    // var_dump($row);
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo $row['post_content'];
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['post_date']));
                            echo "\n";
                            echo '<a href="user.php?id='.$row['user_id'].'">'.$row['user_name'].'</a>';
                            // echo "userid".$row['user_id']."session id".$_SESSION['user_id'];
                            if ($row['user_id']==$_SESSION['user_id']) {
                                echo '<form class="display-inline"  method="post" action="delete.php">';
                                echo '<input type="hidden" name="post_id" value="'.$row['post_id'].'">';
                                echo '<button>Delete</button>';
                                echo '</form>';
                            }
                        echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';

               
                
            }
        }
    }
}
}
?>
<?php
include 'footer.php';
?>
