<?php
function report_01($month, $year){
  global $dbconn;
  $sql = "
  select concat(10*floor(age/10), '-', 10*CEILING(age/10)) as range,
    jenis_kelamin,
    count(*) as count
  from (
    select
      *,
      EXTRACT(YEAR FROM NOW())-EXTRACT(YEAR FROM tanggal_lahir) AS age
    from
      registrasi inner join member on registrasi.nik = member.nik
	where
	  EXTRACT(MONTH FROM tanggal) =$month
	AND
	  EXTRACT(YEAR FROM tanggal) =$year
  ) as t
	  group by range, jenis_kelamin ORDER BY range;
  ";
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

function report_02($month, $year){
  global $dbconn;
  $sql = "
  select
    concat(10*floor(age/10), '-', 10*CEILING(age/10)) as range,
	nama as jenis_donor,
	CASE WHEN no_plat IS NULL THEN 'Pusat'
		 ELSE 'Event'
		 END AS lokasi,
    count(*) as count
  from (
    select
      registrasi.*,
	  member.tanggal_lahir,
	  jenis_donor.*,
	  registrasi_event.no_plat,
      EXTRACT(YEAR FROM NOW())-EXTRACT(YEAR FROM tanggal_lahir) AS age
    from
      registrasi
			  inner join jenis_donor on (registrasi.jenis_id) = (jenis_donor.jenis_id)
			  inner join member on registrasi.nik = member.nik
			  left join registrasi_event ON
        (registrasi.nik,registrasi.no_datang) = (registrasi_event.nik,registrasi_event.no_datang)
	where
	  EXTRACT(MONTH FROM tanggal) = $month
	AND
	  EXTRACT(YEAR FROM tanggal) = $year
  ) as t
	  group by range,lokasi,jenis_donor  ORDER BY range;
  ";

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

function report_03($month, $year){
  global $dbconn;
  $sql = "
  select
    concat(10*floor(age/10), '-', 10*CEILING(age/10)) as range,
    count(*) as count
  from (
    select
      registrasi.*,
	  member.tanggal_lahir,
      EXTRACT(YEAR FROM NOW())-EXTRACT(YEAR FROM tanggal_lahir) AS age
    from
      registrasi
			  inner join member on registrasi.nik = member.nik
	where
	  EXTRACT(MONTH FROM tanggal) = $month
	AND
	  EXTRACT(YEAR FROM tanggal) = $year
  ) as t
	  group by range  ORDER BY range
  ;";

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

function report_04($month, $year){
  global $dbconn;
  $sql = "
  select
    concat(10*floor(age/10), '-', 10*CEILING(age/10)) as range,
	gol_darah,
	rh,
    count(*) as count
  from (
    select
      registrasi.*,
	  member.*,
	  pemeriksaan_hb.gol_darah,
	  pemeriksaan_hb.rh,
      EXTRACT(YEAR FROM NOW())-EXTRACT(YEAR FROM tanggal_lahir) AS age
    from
      registrasi
			  inner join member on registrasi.nik = member.nik
			  inner join pemeriksaan_hb on
        (registrasi.nik,registrasi.no_datang) = (pemeriksaan_hb.nik,pemeriksaan_hb.no_datang)
	where
	  EXTRACT(MONTH FROM tanggal) = $month
	AND
	  EXTRACT(YEAR FROM tanggal) = $year
  ) as t
	  group by range,gol_darah, rh  ORDER BY range;	  ";

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

function report_05($month, $year){
  global $dbconn;
  $sql = "SELECT status_registrasi.keterangan,COUNT (*) AS COUNT
          FROM
	         registrasi
          INNER JOIN status_registrasi ON registrasi.status_id = status_registrasi.status_id
          WHERE
            registrasi.status_id >4 AND
            EXTRACT(MONTH FROM tanggal) = $month AND
            EXTRACT(YEAR FROM tanggal) = $year
          GROUP BY status_registrasi.keterangan	  ";

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

function report_06($month, $year){
  global $dbconn;
  $sql = "
SELECT instansi.nama as Nama_Instansi, kerjasama_instansi.waktu_mulai as Tanggal,
kerjasama_instansi.target as Rencana_Jumlah, kendaraan.nama AS Kendaraan FROM kerjasama_instansi
INNER JOIN instansi ON kerjasama_instansi.instansi_id = instansi.instansi_id
INNER JOIN kendaraan ON kerjasama_instansi.no_plat = kendaraan.no_plat
WHERE EXTRACT(MONTH FROM waktu_mulai)=$month AND EXTRACT(YEAR FROM waktu_mulai)=$year";

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

?>
