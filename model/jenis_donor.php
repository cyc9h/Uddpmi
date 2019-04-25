<?php
/**
 *
 */
class jenis_donor
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
      $sql = "INSERT INTO jenis_donor (jenis_id, nama)  VALUES (null,'".$arr['nama']."')";
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
    $result = pg_query($dbconn, "SELECT * FROM jenis_donor");
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
    $result = pg_query($dbconn, "DELETE FROM jenis_donor WHERE jenis_id = '$id'");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }
}

?>
