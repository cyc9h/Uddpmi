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

  function select_by_primary($arr){
    global $dbconn;
    $sql = "
    SELECT member.*, kondisi.kondisi, pilihan_kondisi.keterangan, jenis_donor.nama AS nama_jenis, date_trunc('second',registrasi.tanggal), registrasi.status_id AS tanggal,pemeriksaan_hb.*, pemeriksaan_paramedik.*, donor.* FROM registrasi
    INNER JOIN member ON registrasi.nik=member.nik
    INNER JOIN kondisi_registrasi ON (registrasi.nik,registrasi.no_datang) = (kondisi_registrasi.nik,kondisi_registrasi.no_datang)
    INNER JOIN kondisi ON kondisi_registrasi.kondisi_id = kondisi.kondisi_id
    INNER JOIN pilihan_kondisi ON kondisi_registrasi.pilihan_id = pilihan_kondisi.pilihan_id
    INNER JOIN jenis_donor ON registrasi.jenis_id = jenis_donor.jenis_id
    LEFT JOIN registrasi_event ON (registrasi.nik,registrasi.no_datang) = (registrasi_event.nik,registrasi_event.no_datang)
    LEFT JOIN pemeriksaan_hb ON (registrasi.nik,registrasi.no_datang) = (pemeriksaan_hb.nik,pemeriksaan_hb.no_datang)
    LEFT JOIN pemeriksaan_paramedik ON (registrasi.nik,registrasi.no_datang) = (pemeriksaan_paramedik.nik,pemeriksaan_paramedik.no_datang)
    LEFT JOIN donor ON (registrasi.nik,registrasi.no_datang) = (donor.nik,donor.no_datang)
    WHERE registrasi.nik = '".$arr['nik']."' and registrasi.no_datang = ".$arr['no'];

    if(isset($_COOKIE['location1'])){
      $sql = $sql. " AND no_plat = '".$_COOKIE['location1']."' AND waktu_mulai = '". $_COOKIE['location2']."'";
    }else{
      $sql = $sql. " AND no_plat is null AND waktu_mulai is null";
    }

    $result = pg_query($dbconn, $sql);
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

  function select_by_status_id($status_id){
    global $dbconn;
    $sql = "
    SELECT registrasi.nik, registrasi.no_datang, member.nama, date_trunc('second',registrasi.tanggal) FROM registrasi
    INNER JOIN member ON registrasi.nik = member.nik
    LEFT JOIN registrasi_event ON (registrasi.nik, registrasi.no_datang) = (registrasi_event.nik, registrasi_event.no_datang)
    WHERE status_id = ".$status_id;
    if(isset($_COOKIE['location1'])){
      $sql = $sql. " AND no_plat = '".$_COOKIE['location1']."' AND waktu_mulai = '". $_COOKIE['location2']."'";
    }else{
      $sql = $sql. " AND no_plat is null AND waktu_mulai is null";
    }

    $result = pg_query($dbconn, $sql);
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

  function change_status($arr){
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
      $sql = "UPDATE registrasi SET status_id = ".$arr['status_id']." WHERE nik ='".$arr['nik']."' AND no_datang =".$arr['no_datang'];
      echo $sql;
      $result = pg_query($dbconn, $sql);
    }


      if(!$result){
        return 'Insert_Error';
      }else{
        return 'Insert_Success';
      }
  }
}

?>
