<?php
session_start();


require("../libs/connect.class.php");
$db = new database();
$db->connect();

// Check admin privilege
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_SESSION['userTFC']."' and usertype = '002' and userstatus = 'Yes' and active_status = 'Yes'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "System privilege denines!";
  $db->disconnect();
  exit();
}

// Check duplicate license
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."'";
$result = $db->select($strSQL,false,true);
if(!$result){
  print "License not available!";
  $db->disconnect();
  exit();
}

// Update license
$strSQL = "UPDATE tfc_useraccount SET userstatus = '".$_POST['todo']."' WHERE username = '".$_POST['username']."'";
$result = $db->update($strSQL);

// Check updated license
$strSQL = "SELECT * FROM tfc_useraccount WHERE username = '".$_POST['username']."' and userstatus = '".$_POST['todo']."'";
$resultUpdate = $db->select($strSQL,false,true);
if($resultUpdate){
    print "Y";
}else{
  //print
  print "Can not update this user account status!";
  $db->disconnect();
  exit();
}

?>
