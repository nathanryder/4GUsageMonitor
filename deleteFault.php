<?php
include("includes/connect.php");
header('Content-Type: application/json');

$aResult = array();
$id = 0;

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }
if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }
if( !isset($aResult['error']) ) {
  switch($_POST['functionname']) {
     case 'delete':
        $aResult['result'] = "success ";
        if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 1)) {
            $aResult['error'] = 'Error in arguments!';
        } else {
            $aResult['result'] = $_POST['arguments'][0];
            $id = $_POST['arguments'][0];

            mysqli_query($con, "DELETE FROM faults WHERE ID='" . $id . "'");
        }
        break;
     default:
        $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
        break;
  }
}
echo json_encode($aResult);
?>
