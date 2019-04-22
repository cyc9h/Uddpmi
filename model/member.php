<?php
/**
 *
 */
class member
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
      $sql = "INSERT INTO member (nik,nama,jenis_kelamin,alamat,pekerjaan,tempat_lahir,tanggal_lahir,gol_darah,rh)
      VALUES (
        '".$arr['nik']."',
        '".$arr['nama']."',
        '".$arr['jenis_kelamin']."',
        '".$arr['alamat']."',
        '".$arr['pekerjaan']."',
        '".$arr['tempat_lahir']."',
        '".$arr['tanggal_lahir']."',
        '".$arr['gol_darah']."',
        '".$arr['rh']."'
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

  function select_by_nik($id){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM member WHERE nik = '$id'");
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

  // function delete($id){
  //   global $dbconn;
  //   $result = pg_query($dbconn, "DELETE FROM instansi WHERE instansi_id = '$id'");
  //
  //   if(!$result){
  //     return 'Delete_Error';
  //   }else{
  //     return 'Delete_Success';
  //   }
  // }

  // function select_by_id($id){
  //   global $dbconn;
  //   $result = pg_query($dbconn, "SELECT * FROM instansi where MD5(CAST(instansi_id AS CHARACTER VARYING)) = '$id'");
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

  function update($arr){
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
      $sql = "UPDATE member SET
                nama='".$arr['nama']."',
                jenis_kelamin='".$arr['jenis_kelamin']."',
                alamat='".$arr['alamat']."',
                pekerjaan='".$arr['pekerjaan']."',
                tempat_lahir='".$arr['tempat_lahir']."',
                tanggal_lahir='".$arr['tanggal_lahir']."',
                gol_darah = '".$arr['gol_darah']."',
                rh = '".$arr['rh']."'
	            WHERE nik='".$arr['nik']."'";
      echo $sql;
      $result = pg_query($dbconn, $sql);
    }


      if(!$result){
        return 'Update_Error';
      }else{
        return 'Update_Success';
      }
  }
}

?>
