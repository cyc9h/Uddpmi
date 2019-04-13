<?php
/**
 *
 */
class registrasi
{

  function insert($arr){
    global $dbconn;
    $check = true;
    foreach ($arr as $key => $value) {
      if($key!='kondisi_registrasi'){
        if(ctype_space($value)||strlen($value)==0){
          $check = false;
        }else{
          $arr[$key] = trim($value);
        }
      }else{
        foreach ($value as $key2 => $value2) {
          if(ctype_space($value2)||strlen($value2)==0){
            $check = false;
          }
        }
      }
    }
    if($check){
      $sql = "INSERT INTO registrasi (nik, no_datang, jenis_id, status_id, tanggal)
      VALUES (
        '".$arr['nik']."',
        null,
        ".$arr['jenis_id'].",
        1,
        NOW()
      )";
      $result = pg_query($dbconn, $sql);
    }


      if(!$result){
        return 'Insert_Error';
      }else{
        return 'Insert_Success';
      }
  }

  // function select_all(){
  //   global $dbconn;
  //   $result = pg_query($dbconn, "SELECT * FROM jenis_kantong");
  //   if (!$result) {
  //       echo "An error occurred.\n";
  //       exit;
  //   }else{
  //     $i=0;
  //     $data = [];
  //     while($row = pg_fetch_array($result)){
  //       $data[$i]=$row;
  //       $i++;
  //     }
  //     return $data;
  //   }
  // }
  //
  // function delete($id){
  //   global $dbconn;
  //   $result = pg_query($dbconn, "DELETE FROM jenis_kantong WHERE jkantong_id = $id");
  //
  //   if(!$result){
  //     return 'Delete_Error';
  //   }else{
  //     return 'Delete_Success';
  //   }
  // }
}

?>
