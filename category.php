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
else{
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);

if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This category does not exist.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h1>' . $row['cat_name'] . '</h1>';
        }

        //do a query for the topics
        $sql = "SELECT
                    topic_id,
                    topic_subject,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($conn, $_GET['id']);

        $result = mysqli_query($conn, $sql);

        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'There are no topics in this category yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                      <tr>
                        <th>Topic</th>
                      </tr>';

                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h5><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h5>';
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
