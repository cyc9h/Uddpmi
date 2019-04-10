<?php

/**
 *
 */
class petugas_paramedik
{

  function promote($id){
    global $dbconn;
    $result = pg_query($dbconn, "INSERT INTO petugas_paramedik (paramedik_id) VALUES ($id)");

    if(!$result){
      return 'Insert_Error';
    }else{
      return 'Insert_Success';
    }
  }

  function demote($id){
    global $dbconn;
    $result = pg_query($dbconn, "DELETE FROM petugas_paramedik WHERE paramedik_id = $id");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }
}


?>
