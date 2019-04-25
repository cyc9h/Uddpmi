<?php
function report_a($month, $year){
  global $dbconn;
  $sql = "
  select
      CASE
  		WHEN age < 18 THEN '...-18'
  		WHEN age BETWEEN 18 AND 25 THEN '18-24'
  		WHEN age BETWEEN 25 AND 44 THEN '25-44'
  		WHEN age BETWEEN 45 AND 59 THEN '45-59'
  		WHEN age >= 60 THEN '60-...'
  	END AS ".'"Kelompok Umur"'.",
  	count(*) as ".'"Jumlah Donasi"'.",
  	SUM(CASE WHEN jenis_id = '1' AND no_plat IS null THEN 1 ELSE 0 END) AS ".'"Baru(Pusat)"'.",
  	SUM(CASE WHEN jenis_id = '2' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Ulang(Pusat)"'.",
  	SUM(CASE WHEN jenis_id = '3' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Pengganti(Pusat)"'.",
  	SUM(CASE WHEN jenis_id = '4' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Bayaran(Pusat)"'.",
  	SUM(CASE WHEN jenis_id = '1' AND no_plat is not null THEN 1 else 0 END) AS ".'"Baru(Kegiatan)"'.",
  	SUM(CASE WHEN jenis_id = '2' AND no_plat is not null THEN 1 else 0 END) AS ".'"Ulang(Kegiatan)"'.",
  	SUM(CASE WHEN jk = 'Pria' THEN 1 ELSE 0 END) AS ".'"Pria"'.",
  	SUM(CASE WHEN jk = 'Wanita' THEN 1 ELSE 0 END) AS ".'"Wanita"'.",
  	SUM(CASE WHEN gol_darah = 'O' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"O+"'.",
  	SUM(CASE WHEN gol_darah = 'O' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"O-"'.",
  	SUM(CASE WHEN gol_darah = 'A' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"A+"'.",
  	SUM(CASE WHEN gol_darah = 'A' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"A-"'.",
  	SUM(CASE WHEN gol_darah = 'B' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"B+"'.",
  	SUM(CASE WHEN gol_darah = 'B' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"B-"'.",
  	SUM(CASE WHEN gol_darah = 'AB' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"AB+"'.",
  	SUM(CASE WHEN gol_darah = 'AB' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"AB-"'."
    from (
      select
        EXTRACT(YEAR FROM NOW())-EXTRACT(YEAR FROM tanggal_lahir) AS age,
  	  jenis_donor.jenis_id,
  	  registrasi_event.no_plat,
  	  member.jenis_kelamin as jk,
  	  member.gol_darah,
  	  member.rh
      from
        registrasi
  			  inner join member on registrasi.nik = member.nik
  			  inner join jenis_donor on registrasi.jenis_id = jenis_donor.jenis_id
  			  left join registrasi_event on (registrasi.nik,registrasi.no_datang) = (registrasi_event.nik,registrasi_event.no_datang)
  	where
  	  EXTRACT(MONTH FROM tanggal) = $month
  	AND
  	  EXTRACT(YEAR FROM tanggal) = $year
  	AND status_id = '4'
    ) as x
    group by ".'"Kelompok Umur"'."
    UNION ALL
    SELECT
    	'Total',
  	COUNT(*),
      SUM(CASE WHEN registrasi.jenis_id = '1' AND no_plat IS null THEN 1 ELSE 0 END) AS ".'"Baru(Pusat)"'.",
  	SUM(CASE WHEN registrasi.jenis_id = '2' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Ulang(Pusat)"'.",
  	SUM(CASE WHEN registrasi.jenis_id = '3' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Pengganti(Pusat)"'.",
  	SUM(CASE WHEN registrasi.jenis_id = '4' AND no_plat is null THEN 1 ELSE 0 END) AS ".'"Bayaran(Pusat)"'.",
  	SUM(CASE WHEN registrasi.jenis_id = '1' AND no_plat is not null THEN 1 else 0 END) AS ".'"Baru(Kegiatan)"'.",
  	SUM(CASE WHEN registrasi.jenis_id = '2' AND no_plat is not null THEN 1 else 0 END) AS ".'"Ulang(Kegiatan)"'.",
      SUM(CASE WHEN jenis_kelamin = 'Pria' THEN 1 ELSE 0 END),
  	SUM(CASE WHEN jenis_kelamin = 'Wanita' THEN 1 ELSE 0 END),
  	SUM(CASE WHEN gol_darah = 'O' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"O+"'.",
  	SUM(CASE WHEN gol_darah = 'O' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"O-"'.",
  	SUM(CASE WHEN gol_darah = 'A' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"A+"'.",
  	SUM(CASE WHEN gol_darah = 'A' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"A-"'.",
  	SUM(CASE WHEN gol_darah = 'B' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"B+"'.",
  	SUM(CASE WHEN gol_darah = 'B' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"B-"'.",
  	SUM(CASE WHEN gol_darah = 'AB' AND rh = '+' THEN 1 ELSE 0 END) AS ".'"AB+"'.",
  	SUM(CASE WHEN gol_darah = 'AB' AND rh = '-' THEN 1 ELSE 0 END) AS ".'"AB-"'."
    FROM registrasi
    INNER JOIN member ON registrasi.nik = member.nik
    INNER JOIN jenis_donor ON registrasi.jenis_id = jenis_donor.jenis_id
    LEFT JOIN registrasi_event ON (registrasi.nik,registrasi.no_datang) = (registrasi_event.nik,registrasi_event.no_datang)
    WHERE EXTRACT(MONTH FROM tanggal)=$month AND EXTRACT(YEAR FROM tanggal)=$year AND status_id = '4'
    ORDER by ".'"Kelompok Umur"'." ASC
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

function report_b($month, $year){
  global $dbconn;
  $sql = "
  SELECT
  	keterangan AS ".'"Alasan Penolakan"'.",
  	SUM(CASE WHEN nik IS NOT NULL AND EXTRACT(MONTH FROM tanggal)=$month AND EXTRACT(YEAR FROM tanggal)=$year THEN 1 ELSE 0 END) AS ".'"Jumlah"'."
  FROM status_registrasi
  LEFT JOIN registrasi ON status_registrasi.status_id = registrasi.status_id
  WHERE status_registrasi.status_id>'4'
  GROUP BY keterangan
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

  function report_c($month, $year){
    global $dbconn;
    $sql = "
    SELECT
    	instansi.nama AS ".'"Instansi"'.",
    	waktu_mulai AS ".'"Tanggal"'.",
    	target AS ".'"Rencana Jumlah"'.",
    	kendaraan.nama AS ".'"Kendaraan"'."
    FROM kerjasama_instansi
    INNER JOIN instansi ON instansi.instansi_id = kerjasama_instansi.instansi_id
    INNER JOIN kendaraan ON kendaraan.no_plat = kerjasama_instansi.no_plat
    WHERE
    	EXTRACT(MONTH FROM waktu_mulai) = EXTRACT(MONTH FROM NOW()) AND
    	EXTRACT(YEAR FROM waktu_mulai) = EXTRACT(YEAR FROM NOW())
    ORDER BY ".'"Tanggal"'." ASC
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

?>
