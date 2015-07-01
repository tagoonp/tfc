<?php
session_start();

require("../libs/connect.class.php");
$db = new database();
$db->connect();


$addDate = date('Y-m-d');

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'YES' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denine!";
  $db->disconnect();
  exit();
}

$strSQL = "SELECT * FROM tfc_vehicle_grouping WHERE vg_mac_id = '".$_POST['mac_id']."' and vg_iconname = '".$_POST['icon']."'";
$resultCheck = $db->select($strSQL,false,true);
if($resultCheck){
  print "Duplicate group [Checked by icon]!";
  $db->disconnect();
  exit();
}

// Inser sub activity
$strSQL = "INSERT INTO tfc_vehicle_grouping (vg_title, vg_add_date, vg_iconname, vg_mac_id, vg_username) VALUES ('".$_POST['grouptitle']."', '".$addDate."', '".$_POST['icon']."', '".$_POST['mac_id']."', '".$_SESSION['userTFC']."')";
$resultInsert = $db->insert($strSQL,false,true);

if($resultInsert){

  $strSQL = "SELECT vg_id FROM tfc_vehicle_grouping WHERE vg_title = '".$_POST['grouptitle']."' and vg_iconname = '".$_POST['icon']."' and vg_mac_id = '".$_POST['mac_id']."' and vg_add_date = '".$addDate."' ";
  $resultChecgvgid = $db->select($strSQL,false,true);

  if($resultChecgvgid){
    foreach($_POST['vehicleList'] as $v){
      $strSQL = "INSERT INTO tfc_grouping_description (vg_id, vehicle_id) VALUES ('".$resultChecgvgid[0]['vg_id']."','".$v."')";
      $resultInsert2 = $db->insert($strSQL,false,true);
    }

    print "Y";
    // print $_POST['vehicleList'][1];
    exit();
  }else{
    print "Can not create vehicle group! - Error code x2";
    exit();
  }
}else{
  print "Can not create vehicle group! - Error code x1";
  $db->disconnect();
  exit();
}



?>
