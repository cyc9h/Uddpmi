<?php
/**
 *
 */
class User
{

  var $user_id;
  var $nama;
  var $jenis_kelamin;
  var $no_handphone;
  var $username;
  var $password;

  function Login($username,$password){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM users WHERE username='$username' AND password=MD5('$password')");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }else{
      $data = pg_fetch_array($result);
      if($data['user_id']==1){
        $_SESSION['data'] = $data;
      }
      return $data;
    }
  }

  function select_all(){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT * FROM users");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }else{
      $i=0;
      while($row = pg_fetch_array($result)){
        $data[$i]=$row;
        $i++;
      }
      return $data;
    }
  }

  function delete_by_id($id){
    global $dbconn;
    $result = pg_query($dbconn, "DELETE FROM users WHERE user_id = $id");

    if(!$result){
      return 'Delete_Error';
    }else{
      return 'Delete_Success';
    }
  }

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
      $sql = "INSERT INTO users (user_id, nama, jenis_kelamin, no_handphone, username, password)  VALUES (default,'".$arr['nama']."','".$arr['jenis_kelamin']."','".$arr['no_handphone']."','".$arr['username']."',md5('".$arr['password']."'))";
      $result = pg_query($dbconn, $sql);
    }


      if(!$result){
        return 'Insert_Error';
      }else{
        return 'Insert_Success';
      }
  }

  function select_all_with_role(){
    global $dbconn;
    $result = pg_query($dbconn, "SELECT users.*,hb_id,aftap_id,paramedik_id from users
      LEFT JOIN petugas_hb ON user_id=hb_id
      LEFT JOIN petugas_aftap ON user_id=aftap_id
      LEFT JOIN petugas_paramedik ON user_id=paramedik_id");
    if (!$result) {
        echo "An error occurred.\n";
        exit;
    }else{
      $i=0;
      while($row = pg_fetch_array($result)){
        $data[$i]=$row;
        $i++;
      }
      return $data;
    }
  }
}

?>
