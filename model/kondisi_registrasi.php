<?php
/**
 *
 */
class kondisi_registrasi
{

  function insert($nik,$arr){
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
      $search = "SELECT MAX(cast(no_datang as int)) as no_datang FROM registrasi WHERE nik='$nik'";
      $a = pg_query($dbconn, $search);

      $x = pg_fetch_array($a);
      $loop = 1;

      $sql = "INSERT INTO kondisi_registrasi(nik,no_datang,kondisi_id,pilihan_id) VALUES";
      foreach ($arr as $key => $value) {
        $b = "('".$nik."','".$x['no_datang']."','$key','$value')";
        if($loop != count($arr)){
          $b = $b.",";
        }
        $sql = $sql.$b;
        $loop++;
      }
      $result = pg_query($dbconn,$sql);

      if(isset($_COOKIE['location1'])){
        $sql = "INSERT INTO registrasi_event (nik,no_datang,no_plat,waktu_mulai,waktu_selesai)
        VALUES (
          '".$nik."',
          '".$x['no_datang']."',
          '".$_COOKIE['location1']."',
          '".$_COOKIE['location2']."',
          '".$_COOKIE['location3']."'
        )";
        pg_query($dbconn,$sql);
      }
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
