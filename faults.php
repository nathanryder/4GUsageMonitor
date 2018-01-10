<?php
$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}
if ($page < 1) {
  $page = 1;
}

$bil = ($page-1)*15;
$til = $page*15;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Faults</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="includes/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/styles.css">
    <link rel="stylesheet" type="text/css" href="includes/sweetalert.css">
  </head>
  <body>
    <?php
    include("includes/navbar.php");
    include("includes/connect.php");
    ?>

  <center>
    <div class="container" style="padding-top: 10px;">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              Faults
              <div style="padding-left: 77%;" class="btn-group" role="group">
                <a href="addFault.php">
                  <button type="button" class="btn btn-primary">Add A Fault</button>
                </a>
              </div>
            </h3>
          </div>
          <div class="panel-body">
            <table width="100%" class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Start</th>
                  <th>End</th>
                  <th>Description</th>
                  <th>Down time</th>
                  <th>&nbsp;</th>
                 </tr>
               </thead>
               <?php
                $data = mysqli_query($con, "SELECT * FROM faults LIMIT ". $bil. "," . $til);
                while ($row = mysqli_fetch_assoc($data)) {
                  $startDate = $row['startDate'];
                  $startTime = $row['startTime'];
                  $endDate = $row['endDate'];
                  $endTime = $row['endTime'];
                  $desc = $row['description'];
                  $id = $row['ID'];

                  $dateOne = date_create("$startDate $startTime");
                  $dateTwo = date_create("$endDate $endTime");
                  $end = NULL;

                  if ($row['ongoing'] == 1) {
                    $dateTwo = date_create("now");
                    $end = "On going";
                  }

                  $diff = date_diff($dateOne, $dateTwo);
                  echo "<tr>
                  <td width='25%'>" . $startDate . "</td>
                  <td width='25%'>" . ($end === NULL ? $endDate : $end) . "</td>
                  <td width='25%'>" . $desc . "</td>
                  <td>" . $diff->format('%a days %h hours') . "</td>
                  <td>
                    <a style='padding-right:2px;' href='editFault.php?id=" . $row['ID'] . "'>
                      <img class='actionBtn' width=16 height=16 src='includes/images/editIcon.png'>
                    </a>
                    <a style='padding-left:2px;' onclick='del(" . $row['ID'] . ");' href='#'>
                      <!-- https://www.vivus.es/assets/icons/do_not.svg -->
                      <img class='actionBtn' width=16 height=16 src='includes/images/deleteIcon.svg'>
                    </a>
                  </td>
                  </tr>";
                }
               ?>
              </table>
              <nav aria-label="Page navigation">
                <ul class="pagination">
                  <?php
                  $pages = ceil(mysqli_num_rows(mysqli_query($con, "SELECT * FROM faults"))/15);
                  if ($page <= 1) {
                    echo '<li class="disabled">
                      <a aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>';
                  } else {
                    echo '<li>
                      <a href="faults.php?page=' . ($page-1) . '" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>';
                  }

                  for ($i=1; $i <= $pages; $i++) {
                    if ($i == $page) {
                      echo '<li class="active"><a href="faults.php?page=' . $id . '">' . $i . '</a></li>';
                    } else {
                      echo '<li><a href="faults.php?page=' . $i . '">' . $i . '</a></li>';
                    }
                  }

                  if ($page+1 > $pages) {
                    echo '<li class="disabled">
                      <a aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>';
                  } else {
                    echo '<li>
                      <a href="faults.php?page=' . ($page+1) . '" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>';
                  }
                  ?>
              </ul>
            </nav>
          </div>
        </div>
      </div>
  </center>

  <script type="text/javascript">
    function del(id) {
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this fault!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
      },
      function(){
        swal("Deleted!", "Fault has been successfully deleted.", "success");
        jQuery.ajax({
          type: "POST",
          url: 'deleteFault.php',
          dataType: 'json',
          data: {functionname: 'delete', arguments: [id]},
          success: function (obj, textstatus) {
            if(!('error' in obj)) {
                r = obj.result;
                console.log(r);
                location.reload();
                setTimeout(function(){
                },1000);
            } else {
                console.log(obj.error);
            }
          }
        });
      });
    }
  </script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
</html>
