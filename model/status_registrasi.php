<?php
/**
 *
 */
class status_registrasi
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
      $sql = "INSERT INTO status_registrasi (status_id, keterangan)  VALUES (default,'".$arr['val']."')";
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
    $result = pg_query($dbconn, "SELECT * FROM status_registrasi");
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

  function select_in($arr){
    global $dbconn;
    $sql = "SELECT * FROM status_registrasi WHERE status_id IN (";
      foreach ($arr as $key => $value) {
        $sql = $sql.$value.",";
      }
    $sql = $sql.")";


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
    $result = pg_query($dbconn, "DELETE FROM status_registrasi WHERE status_id = $id");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }
}

?>
