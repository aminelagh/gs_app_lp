<?php

if(!function_exists('formatDate')){
  function formatDate($date){
    if($date == null)
    return '';
    else return Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date)->format("d/m/Y");
  }
}

if(!function_exists('formatDate2')){
  function formatDate2($date){
    if($date == null)
    return '';
    else return Carbon\Carbon::createFromFormat('Y-m-d',$date)->format("d/m/Y");
  }
}


if(!function_exists('formatDateTime')){
  function formatDateTime($date){
    if($date == null)
    return '';
    return Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date)->format("d/m/Y H:i:s");
  }
}
