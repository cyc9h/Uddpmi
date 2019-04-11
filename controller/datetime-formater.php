<?php
function format_local($datetime){
  return str_replace("T"," ",$datetime).":00";
}
?>
