<?php
/**
 *
 */
class instansi
{
  function insert($arr){
    global $dbconn;
    $check = true;
    foreach ($arr as $key => $value) {
      if(ctype_space($value)||strlen($value)==0){
        $check = false;
      }else{
        $arr[$key] = trim($value);
      }
    }
    if($check){
      $sql = "INSERT INTO instansi (instansi_id,nama,latitude,longitude)  VALUES (null,'".$arr['nama']."',".$arr['lat'].",".$arr['long'].")";
      $result = pg_query($dbconn, $sql);
    }


      if(!$result){
        return 'Insert_Error';
      }else{
        return 'Insert_Success';
      }
  }

  function select_all(){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM instansi");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }else{
      $i=0;
      $data = [];
      while($row = pg_fetch_array($result)){
        $data[$i]=$row;
        $i++;
      }
      return $data;
    }
  }

  function delete($id){
    global $dbconn;
    $result = pg_query($dbconn, "DELETE FROM instansi WHERE instansi_id = '$id'");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }

  function select_by_id($id){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM instansi where MD5(CAST(instansi_id AS CHARACTER VARYING)) = '$id'");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }else{
      $i=0;
      $data = [];
      while($row = pg_fetch_array($result)){
        $data[$i]=$row;
        $i++;
      }
      return $data;
    }
  }
}

?>
