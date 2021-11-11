<?php

// SET PLACEKEYS
function setPlacekeys ($xhanString, $n = 0) {

  while (strpos($xhanString, 'PLACEKEY"') !== FALSE) {
    
    $offset = strpos($xhanString, '"PLACEKEY"');
    $xhanString = substr_replace($xhanString, '"PLACEKEY_'.$n.'"', $offset, 10);
    $n++;
  }
  
  return $xhanString;
}


// REMOVE PLACEKEYS
function removePlacekeys (&$xhanArray) {
  
  $Keys = array_keys($xhanArray);
  $Values = array_values($xhanArray);
  
  for ($i = 0; $i < count($Keys); $i++) {
    
    if (substr($Keys[$i], 0, 9) === 'PLACEKEY_') {
    
      array_splice($xhanArray, $i, 0, [$Values[$i]]);
      unset($xhanArray[$Keys[$i]]);
    }
  }
}


// POPULATE EMPTY PROPERTIES
function populateEmptyProperties (&$xhanArray) {
    
  // REMOVE PLACEKEYS
  removePlacekeys($xhanArray);

  // FIND AND POPULATE EMPTY PROPERTIES
  $Keys = array_keys($xhanArray);

  for ($i = 0; $i < count($Keys); $i++) {
      
    $Key = $Keys[$i];
    
    if (is_array($xhanArray[$Key])) {
      
      populateEmptyProperties($xhanArray[$Key]);
    }

    else if (isset($xhanArray[$Key])) {
    
      $xhanArray[$Key] = ($xhanArray[$Key] === '') ? $Key : $xhanArray[$Key];
    }
  }

  return $xhanArray;
}


// IDENTIFY ARRAYS (AND STRINGS)
function identifyArrays (&$xhanArray) {
  
  $Array_Identified = 0;
  $Keys = array_keys($xhanArray);
  $Values = array_values($xhanArray);

  for ($i = 0; $i < count($Keys); $i++) {
      
    if ($Keys[$i] === $Values[$i]) {
        
      array_splice($xhanArray, $i, 0, [$Values[$i]]);
      unset($xhanArray[$Keys[$i]]);
    }
    
    else {
    
      $Array_Identified++;
    }

    if (is_array($Values[$i])) {
    
      $xhanArray[$Keys[$i]] = identifyArrays($Values[$i]);
    }
  }

  switch (TRUE) {
  
    case ($Array_Identified > 0) : return $xhanArray;
    case (count($Keys) > 1) : return [...$Keys];
    default : return $Keys[0];
  }
}


// RE-LABEL INDEX KEYS
function relabelIndexKeys (&$xhanArray) {

  $Keys = array_keys($xhanArray);
  $Values = array_values($xhanArray);

  for ($i = 0; $i < count($Keys); $i++) {

    if (is_array($Values[$i])) {
    
      $xhanArray[$Keys[$i]] = relabelIndexKeys($Values[$i]);
    }

    if (is_numeric($Keys[$i]) === FALSE) continue;
  
    if ($Keys[$i] !== $i) {
    
      array_splice($xhanArray, $i, 0, [$Values[$i]]);
      unset($xhanArray[$Keys[$i]]);
    }
  }

  return $xhanArray;
}


function xhanStringToJSON ($xhanString) {

  $xhanString = preg_replace('/\s+/', '', $xhanString);
  $xhanString = str_replace('[', '{"', $xhanString);
  $xhanString = str_replace(']', '"}', $xhanString);
  $xhanString = str_replace('=', '": "', $xhanString);
  $xhanString = str_replace(',', '", "', $xhanString);
  $xhanString = str_replace('"{', '{', $xhanString);
  $xhanString = str_replace('}"', '}', $xhanString);
  $xhanString = preg_replace('/"{2,}/', '"', $xhanString);

  $xhanString = preg_replace('/([A-Za-z0-9-]")/', '$1: ""', $xhanString);
  $xhanString = str_replace(': "":', ':', $xhanString);
  $xhanString = preg_replace('/(: "[^"]+"): ""/', '$1', $xhanString);

  $xhanString = str_replace('{', '"PLACEKEY": {', $xhanString);
  $xhanString = str_replace(': "PLACEKEY": {', ': {', $xhanString);
  $xhanString = substr($xhanString, 12);
  $xhanString = setPlacekeys($xhanString);

  $xhanArray = json_decode($xhanString, TRUE);
  $xhanArray = populateEmptyProperties($xhanArray);
  $xhanArray = identifyArrays($xhanArray);
  $xhanArray = relabelIndexKeys($xhanArray);

  $myJSON = json_encode($xhanArray);

  return $myJSON;
}



$myXhan = '[[my="sophisticated", data=[structure, is, contained]], [within, this], xHAN]';
$myJSON = '[{"my":"sophisticated","data":["structure","is","contained"]},["within","this"],"JSON"]';
$convertedXhan = xhanStringToJSON($myXhan);

$myXhan2 = '[mixedArrayTest=[my="sophisticated", data=[structure, is, contained]], [within, this], xHAN]';
$myJSON2 = '{"mixedArrayTest":{"my":"sophisticated","data":["structure","is","contained"]},["within","this"],"JSON"}';
$convertedXhan2 = xhanStringToJSON($myXhan2);

$myXhan3 = '[[this=[more="sophisticated"], data=[structure, is, contained]], [within, this], xHAN, which="represents", a, mixed="array"]';
$convertedXhan3 = xhanStringToJSON($myXhan3);

echo 'XHAN'."\n";
echo $myXhan."\n\n";
echo 'JSON'."\n";
echo $myJSON."\n\n";
echo 'XHAN (converted to JSON)'."\n";
echo $convertedXhan."\n\n";

echo 'XHAN 2'."\n";
echo $myXhan2."\n\n";
echo 'JSON 2'."\n";
echo $myJSON2."\n\n";
echo 'XHAN 2 (converted to JSON)'."\n";
echo $convertedXhan2."\n\n";

echo 'XHAN 3'."\n";
echo $myXhan3."\n\n";
echo 'XHAN 3 (converted to JSON)'."\n";
echo $convertedXhan3."\n\n";

?>
