<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add A Fault</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script></head>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/styles.css">
  </head>
  <body>
    <?php
    include("includes/connect.php");
    include("includes/navbar.php");
    ?>
    <div class="container" style="padding-top: 10px;">
      <?php
      if (isset($_POST['submit'])) {
        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];
        $endDate = $_POST['endDate'];
        $endTime = $_POST['endTime'];
        $ongoing = isset($_POST['ongoing']) ? 1 : 0;
        $desc = $_POST['desc'];

        $query = "INSERT INTO faults (startDate,startTime,endDate,endTime,description,ongoing)
                    VALUES ('$startDate', '$startTime', '$endDate', '$endTime', '$desc', '$ongoing')";

	if (mysqli_query($con, $query) === FALSE) {
          echo '<center><div class="alert alert-danger" role="alert">Error: Failed to add fault<br>'.mysqli_error($con).'</div></center>';
        } else {
          echo '<center><div class="alert alert-success" role="alert">Successfully added fault</div></center>';
        }
      }
      ?>
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Add A Fault
            </h3>
          </div>
          <div class="panel-body">
            <form action="addFault.php" method="POST" enctype="multipart/form-data">

              <label for="startDate">Start date:&nbsp;</label><input type="date" name="startDate">
              <br><br>
              <label for="startTime">Start time:&nbsp;</label><input type="time" name="startTime">
              <br><br><br>

              <label for="endDate">End date:&nbsp;</label><input type="date" name="endDate">
              <br><br>
              <label for="endTime">End time:&nbsp;</label><input type="time" name="endTime">
              <br><br>

              <label for="ongoing">Ongoing?&nbsp;&nbsp;</label><input type="checkbox" name="ongoing">
              <br><br>

              <strong>Description:</strong><br>
              <textarea name="desc" rows="5%" cols="82%"></textarea>

              <br><br>
              <center><input type="submit" name="submit" value="Submit"></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
