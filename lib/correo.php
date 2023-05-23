<?php

function validarCorrecto($email){
    if(empty($email)){
        return true;
    }
    if (preg_match('/^[(a-z0-9\_\-\.)]+@[(a-z0-9\_\-\.)]+\.[(a-z)]{2,15}$/i',$email))
      return true;
    else
      return false;
  }

  ?>