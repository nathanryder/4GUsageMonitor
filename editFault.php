<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Add A Fault</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
      if (!isset($_GET['id'])) {
        header("Location: index.php");
        die();
      }
      $id = $_GET['id'];

      if (isset($_POST['submit'])) {
        $startDate = $_POST['startDate'];
        $startTime = $_POST['startTime'];
        $endDate = $_POST['endDate'];
        $endTime = $_POST['endTime'];
        $ongoing = isset($_POST['ongoing']) ? TRUE : FALSE;
        $desc = $_POST['desc'];

        $query = "UPDATE faults SET startDate='$startDate', startTime='$startTime', endDate='$endDate',
                endTime='$endTime', description='$desc', ongoing='$ongoing' WHERE ID='$id'";

        if (mysqli_query($con, $query) === FALSE) {
          echo '<center><div class="alert alert-danger" role="alert">Error: Failed to edit fault<br>'+mysqli_error($con)+'</div></center>';
        } else {
          echo '<center><div class="alert alert-success" role="alert">Successfully edited fault</div></center>';
        }
      }
      ?>
      <div class="col-md-2">
      </div>
      <div class="col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Edit A Fault
            </h3>
          </div>
          <div class="panel-body">
            <?php
              $data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM faults WHERE ID='" . $id . "'"));
              $ongoing = $data['ongoing'] == 1 ? "checked" : "";
            ?>

            <form action="editFault.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data">

              <label for="startDate">Start date:&nbsp;</label><input type="date" name="startDate" value="<?php echo $data['startDate'] ?>">
              <br><br>
              <label for="startTime">Start time:&nbsp;</label><input type="time" name="startTime" value="<?php echo $data['startTime'] ?>">
              <br><br><br>

              <label for="endDate">End date:&nbsp;</label><input type="date" name="endDate" value="<?php echo $data['endDate'] ?>">
              <br><br>
              <label for="endTime">End time:&nbsp;</label><input type="time" name="endTime" value="<?php echo $data['endTime'] ?>">
              <br><br>

              <label for="ongoing">Ongoing?&nbsp;&nbsp;</label><input type="checkbox" name="ongoing" <?php echo $ongoing ?>>
              <br><br>

              <strong>Description:</strong><br>
              <textarea name="desc" rows="5%" cols="82%"><?php echo $data['description'] ?></textarea>

              <br><br>
              <center><input type="submit" name="submit" value="Update"></center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
