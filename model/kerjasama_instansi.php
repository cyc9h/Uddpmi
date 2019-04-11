<?php
/**
 *
 */
class kerjasama_instansi
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
      $sql =  "INSERT INTO kerjasama_instansi (
        no_plat,
        waktu_mulai,
        waktu_selesai,
        instansi_id,
        target,
        latitude,
        longitude)
      VALUES (
        '".$arr['no_plat']."',
        '".$arr['waktu_mulai']."',
        '".$arr['waktu_selesai']."',
        '".$arr['instansi_id']."',
        '".$arr['target']."',
        '".$arr['latitude']."',
        '".$arr['longitude']."'
      )";
      echo $sql;
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
    $result = pg_query($dbconn, "SELECT * FROM kerjasama_instansi");
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

  function select_all_by_instansi($id){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM kerjasama_instansi WHERE MD5(CAST(instansi_id AS CHARACTER VARYING)) = '$id'");
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

  function delete($arr){
    global $dbconn;
    $result = pg_query($dbconn, "DELETE FROM kerjasama_instansi WHERE no_plat = '".$arr['no_plat']."' AND waktu_mulai = '".$arr['waktu_mulai']."'");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }

  function select_by_id($arr){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM kerjasama_instansi WHERE no_plat = '".$arr['no_plat']."' AND waktu_mulai = '".$arr['waktu_mulai']."'");
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
