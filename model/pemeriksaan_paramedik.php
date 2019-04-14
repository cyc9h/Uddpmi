<?php
/**
 *
 */
class pemeriksaan_paramedik
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
      $sql = "INSERT INTO pemeriksaan_paramedik (nik,no_datang,paramedik_id,tensi,suhu,nadi,riwayat_medis,jkantong_id,jumlah_pengambilan)
      VALUES (
        '".$arr['nik']."',
        ".$arr['no_datang'].",
        ".$arr['paramedik_id'].",
        ".$arr['tensi'].",
        ".$arr['suhu'].",
        ".$arr['nadi'].",
        '".$arr['riwayat_medis']."',
        ".$arr['jkantong_id'].",
        ".$arr['jumlah_pengambilan']."
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
  //   $result = pg_query($dbconn, "SELECT * FROM kondisi");
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
  //   $result = pg_query($dbconn, "DELETE FROM kondisi WHERE kondisi_id = $id");
  //
  //   if(!$result){
  //     return 'Delete_Error';
  //   }else{
  //     return 'Delete_Success';
  //   }
  // }
}

?>
