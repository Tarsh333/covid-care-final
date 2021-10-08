<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
include 'header.php';
include 'connect.php';
$sql = "SELECT
            user_vaccination
        FROM
            users";
$doses0=0;
$doses1=0;
$doses2=0;
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result))
        {
            if ($row['user_vaccination']==0) {
              $doses0++;
            }
            if ($row['user_vaccination']==1) {
              $doses1++;
            }
            if ($row['user_vaccination']==2) {
              $doses2++;
            }
        }
echo "
<div class='pie'><div id='piechart'></div></div>
<script type='text/javascript'>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Doses', 'No of people'],
  ['0 dose (".$doses0.")', ".$doses0."],
  ['1 dose (".$doses1.")', ".$doses1."],
  ['2 doses (".$doses2.")', ".$doses2."]
]);

  var options = {'title':'Institute Vaccination Report (Total ".$doses0+$doses1+$doses2.")', 'width':700, 'height':550};

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>";
include 'footer.php';
?>