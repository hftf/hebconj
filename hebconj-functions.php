<?php

function escapedata($data)  { return mysql_real_escape_string(trim(stripslashes($data))); }
function conjugate($row,$verb_root,$tense_index,$pron_index,$color = false) {
  $rulestext=$row["table_rule"];
  $rules=explode("|",$rulestext);
  $rule=@$rules[10*$tense_index+$pron_index];

  if (strpos($rule, '<br />') > 0) {
    $segs = explode('<br />', $rule);
    foreach ($segs as &$seg)
      $seg = conjugate_($seg, $verb_root, $tense_index, $pron_index, $color);
    return implode('<br />', $segs);
  }
  else
    return conjugate_($rule, $verb_root, $tense_index, $pron_index, $color);
}

function conjugate_($rule,$verb_root,$tense_index,$pron_index,$color = false) {
  switch (strlen($verb_root)/2) {
    case 5:
      $rep=array('פ'=>substr($verb_root,0,2),'ק'=>substr($verb_root,2,2),'ר'=>substr($verb_root,4,2),'ע'=>substr($verb_root,6,2),'ל'=>substr($verb_root,8,2));
      break;
    case 4:
      $rep=array('פ'=>substr($verb_root,0,2),'ק'=>substr($verb_root,2,2),'ע'=>substr($verb_root,4,2),'ל'=>substr($verb_root,6,2));
      break;
    case 3:
      $rep=array('פ'=>substr($verb_root,0,2),'ע'=>substr($verb_root,2,2),'ל'=>substr($verb_root,4,2));
      break;
  }
  $pos = array(); $rule_noMn = preg_replace('/\p{Mn}/u', '', $rule);
  foreach (array('פ', 'ק', 'ר', 'ע', 'ל') as $let) {
    $p = strpos($rule_noMn, $let);
    if ($p !== false)
      $pos[] = $p / 2;
  }
  $return = ($verb_root)?strtr($rule,$rep):"";
  if ($tense_index == 4 && $pron_index == 0) // Infinitive
    $return = strtr($return,array('L'=>'ל'));
  $return = fix_sofit($return);

  if ($color)
      $return = '<span class="positions" data-positions="' . implode(',', $pos) . '">' . $return . '</span>';
  return $return;
}
function fix_sofit($w) {
  global $sofit1, $sofit2;
  //echo '['.preg_replace(array_keys($sofit1), array_values($sofit1), $w).']<br>';
  return preg_replace(array_keys($sofit2), array_values($sofit2), preg_replace(array_keys($sofit1), array_values($sofit1), $w));
}
function strip_niqqud($w) {
  return strtr($w, $GLOBALS['rep2']);
}
function devocalize($word) {
  //$arg = escapeshellarg($word);
  $arg = $word;
  $q = "python Devocalizer/main.py -p '" . json_encode($arg) . "'";
  $s = shell_exec($q);
  return json_decode($s);
}

function niqqud_to_ktiv_male($w) {
  global $b, $d, $l;
  $r = preg_replace('/ֻ/', 'ו', $w);
  //echo str_replace('<br />', '/', $r) . ' &larr; ';
  $r = preg_replace('/([^ו])[ֹֺ]([אהו][\b' . $l . '])/u', '$1$2', $r);
  //echo str_replace('<br />', '/', $r) . ' &larr; ';
  $r = preg_replace('/([^ו])[ֹֺ]/u', '$1ו', $r);
  //echo str_replace('<br />', '/', $r) . ' &larr; ';
  $r = preg_replace('/[ֹֺ]/u', '', $r);
  //echo str_replace('<br />', '/', $r) . ' &larr; ';
  $r = preg_replace('/([' . $b . $l . $d . '])(י[' . $d . '])/u', '$1$2י', $r);
  //echo str_replace('<br />', '/', $r) . ' &larr; ';
  $r = preg_replace('/([^\x{05d9}])ִ([^\x{05d9}]([' . $d . ']*))/u', '$1י$2', $r);
  $r = strip_niqqud($r);
  //echo str_replace('<br />', '/', $r) . '<br>';
  return $r;
}

// For strip_niqqud
$rep = array('\u05B0' => '', '\u05B1' => '', '\u05B2' => '', '\u05B3' => '', '\u05B4' => '', '\u05B5' => '', '\u05B6' => '', '\u05B7' => '', '\u05B8' => '', '\u05B9' => '', '\u05BB' => '', '\u05BC' => '', '\u05BF' => '', '\u05C1' => '', '\u05C2' => '',
   '\uFB30' => '\u05D0', '\uFB31' => '\u05D1', '\uFB32' => '\u05D2', '\uFB33' => '\u05D3', '\uFB35' => '\u05D5', '\uFB4B' => '\u05D5', '\uFB36' => '\u05D6', '\uFB38' => '\u05D8', '\uFB39' => '\u05D9', '\uFB3A' => '\u05DA', '\uFB3B' => '\u05DB',
   '\uFB3C' => '\u05DC', '\uFB3E' => '\u05DE', '\uFB40' => '\u05E0', '\uFB41' => '\u05E1', '\uFB43' => '\u05E3', '\uFB44' => '\u05E4', '\uFB46' => '\u05E6', '\uFB47' => '\u05E7', '\uFB48' => '\u05E8', '\uFB2A' => '\u05E9', '\uFB2B' => '\u05E9', '\uFB2C' => '\u05E9', '\uFB2D' => '\u05E9', '\uFB49' => '\u05E9', '\uFB4A' => '\u05EA');
$rep2 = array();
foreach ($rep as $k => $v)
    $rep2[json_decode('"'.$k.'"')] = json_decode('"'.$v.'"');
    
// For fix_sofit
$sofit = array(
    "כ" => "ך",
    "מ" => "ם",
    "נ" => "ן",
    "פ" => "ף",
    "צ" => "ץ",
);
$sofit1 = array(); $sofit2 = array();
$b = '\p{L}';
$l = '\x{05D0}-\x{05EA}';
$d = '\x{0590}-\x{05C7}';
foreach ($sofit as $s => $S) {
    $sofit1['/' . $s . '([' . $d . ']*([^' . $b . $d . ']|$))/u'] = $S . '$1';
    $sofit2['/' . $S . '([' . $d . ']*[' . $b . '])/u'] = $s . '$1';
}


function he($data) { return urlencode(strrev(hebrev(iconv("UTF-8", "ISO-8859-8", $data)))); }

?>