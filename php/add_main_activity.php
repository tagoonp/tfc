<?php
session_start();

require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'YES' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denine!";
  $db->disconnect();
  exit();
}

// Check confirm manager password
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and password = '".$_POST['password2']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "Invalid password!";
  $db->disconnect();
  exit();
}

// Inser sub activity
$strSQL = "INSERT INTO tfc_main_activity VALUES ('','".$_POST['act_title']."', '".$_POST['coldate']."', '".$_POST['startTime']."', '".$_POST['endTime']."', '".$_POST['interval_val']."','".$_POST['acType']."','".$_POST['pname']."', '".$_POST['descs']."','".$_SESSION['userTFC']."')";
$resultInsert = $db->insert($strSQL,false,true);

if($resultInsert){
  print "Y";
}else{
  print "Can not create sub-activity! - Error code x1";
  $db->disconnect();
  exit();
}



?>
