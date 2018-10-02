 
<?php
include ('../inc/config.php');
include ('../inc/conn.php');
include ('../inc/func.php');
include ('../inc/l_control.php');


$server_name=getParamUrl("server_name", "POST", "");
$date_entry= getParamUrl("date_entry", "POST", "");
$notes=getParamUrl("notes", "POST", "");
$id=getParamUrl("id", "POST", "");
$date_entry1 = date_create($date_entry)->format('Y-m-d');

if($session_type == 'admin')
{
    $sql ="SELECT email FROM admin WHERE id=$session_user_id";   
    $goster = mysql_query($sql,$connection);
    while ($row2 = mysql_fetch_array($goster)) {
        $email = $row2['email'];
    }
}
else
{
    $sql ="SELECT email FROM user WHERE id=$session_user_id";  
    $goster = mysql_query($sql,$connection);
    while ($row2 = mysql_fetch_array($goster)) {
        $email = $row2['email'];
    }
}

$param = 0;

if($id == "" && $server_name != "" && $date_entry1 != ""){
   $sql="INSERT INTO server_upload_log (server_name,date_entry,notes,user) VALUES ('$server_name','$date_entry1','$notes','$email')";
  
    $ekle = mysql_query($sql,$connection);
    if($ekle){
        $param = 1;
        header("Location:server_upload_list.php?m=$param");
    }
    else{
       header("Location:server_upload_log.php?m=$param");
    }
}
else if ($id != "" && $server_name != "" && $date_entry1 != ""){
  
  $sql="UPDATE server_upload_log SET server_name='$server_name', date_entry='$date_entry1', notes='$notes', user='$email' WHERE id=$id";
  $guncelle = mysql_query($sql,$connection);
        if($guncelle){
          $param = 1;
           header("Location:server_upload_list.php?m=$param");
        }
        else{
           header("Location:server_upload_log.php?m=$param&id=$id");
        } 
    }
    else{
        header("Location:server_upload_log.php?m=$param");
    }
?>