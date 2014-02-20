<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <link href="/css.css" type="text/css" rel="stylesheet" />
  <link href="hebconj.css" type="text/css" rel="stylesheet" />
  <link href="colorful-diacritics/test.css" type="text/css" rel="stylesheet" />
  <meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
  <title>Hebrew Verb Conjugator</title>
 </head>
 <body>
<?php

//  str_replace(array('A', 'B', 'C'), array('C', 'D', 'E'), 'ABCABC')
//  str="ABCABC"; rep={A:'C', B:'D', C:'E'}; str.replace(/A|B|C/g, function(x){if(x in rep)return rep[x]})


include "inc/db.php";
mysql_select_db("hebconj");
mysql_query("SET NAMES 'utf8'");

include 'hebconj-functions.php';

$hspell_on = isset($_GET['hspell']);
$color_on = isset($_GET['color']);

$verb_root=escapedata(urldecode((isset($_GET["verb_root"]))?$_GET["verb_root"]:""));
$verb_root=fix_sofit($verb_root);
$tense_id= escapedata((isset($_GET["tense_id"]))?$_GET["tense_id"]:"");
$pronouns= array("אֲנִי<br /><br />","אַתָּה","אַתְּ","הוּא","הִיא","אֲנַחְנוּ<br /><br />","אַתֶּם","אַתֶּן","הֵם","הֵן");
$tenses=   array("הוֹוֶה","עָבָר","עָתִיד","צִוּוּי");
$tense_ops=array(
  1=>array("desc"=>"pa'al    - simple active"    ,"tense_name"=>"פָּעַל",  "hc"=>"קל"), //ʿ
  2=>array("desc"=>"nif'al   - simple passive"   ,"tense_name"=>"נִפְעַל", "hc"=>"נפ"),
  3=>array("desc"=>"pi'el    - intensive active" ,"tense_name"=>"פִּעֵל",  "hc"=>"פי"),
  4=>array("desc"=>"pu'al    - intensive passive","tense_name"=>"פֻּעַל",  "hc"=>"פו"),
  5=>array("desc"=>"hitpa'el - reflexive"        ,"tense_name"=>"הִתְפַּעֵל","hc"=>"הת"),
  6=>array("desc"=>"hif'il   - causative active" ,"tense_name"=>"הִפְעִיל", "hc"=>"הפ"),
  7=>array("desc"=>"huf'al   - causative passive","tense_name"=>"הֻפְעַל", "hc"=>"הו"));

?>
  <p><a href="index.php">Return</a> - <strong><a href="hebconj-list.php">List of Hebrew Verbs</a></strong></p>

  <form id="hebconj" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
   <p style="text-align:center;" lang="he">
    <span lang="he" class="tm">שֹׁרֶשׁ: </span>
    <input type="text" name="verb_root" id="verb_root" lang="he" value="<?php echo $verb_root; ?>" />

    <select name="tense_id" style="font-size:1.25em;">
<?php  foreach ($tense_ops as $tense_op_id=>$tense_op)
              echo "     <option value=\"$tense_op_id\"",($tense_id==$tense_op_id)?" selected=\"selected\"":"                    "," title=\"{$tense_op["desc"]}\">{$tense_op["tense_name"]}</option>\n";
?>
    </select>

    <input type="submit" value="Conjugate" /><br />
   </p>
  </form>
  
<?php

  if (empty($verb_root) || empty($tense_id))
    echo "  <p><strong>Please enter a verb to conjugate.</strong></p>\n";
  else {
    $result=mysql_query("SELECT verb_id,verbs.table_id,verbs.tense_id,tense_name,verb_root,table_rule FROM tenses,verbs LEFT OUTER JOIN tables ON verbs.table_id=tables.table_id WHERE verbs.tense_id=$tense_id AND verbs.tense_id=tenses.tense_id AND verb_root LIKE '$verb_root'"); 
    $row=mysql_fetch_assoc($result);
    if (empty($row))
      echo "  <p><strong>The verb you entered was not found, or possibly has not yet been inserted in the database.</strong> ",mysql_error(),"</p>\n";
    else if (empty($row['table_rule']))
      echo "  <p><strong>The conjugation rules for the verb you entered has not yet been inserted in the database.</strong></p>\n";
    else {
      echo "  <div style=\"position:absolute;\"><p>Verb ID: <strong>{$row["verb_id"]}</strong><br />Table ID: <strong>{$row["table_id"]}</strong><br />Tense ID: <strong>{$row["tense_id"]}</strong></p>\n";

    $verbs_in_same_table = mysql_query('SELECT verb_id, verb_root, tense_id FROM verbs WHERE table_id = "' . $row['table_id'] . '" AND verb_id != "' . $row['verb_id'] . '" ORDER BY verb_id');
    if ($n = mysql_num_rows($verbs_in_same_table)) {
        echo '<hr style="border-bottom: 0;" /><div style="font-size: 0.9em;"><p>Other verbs in this table:</p>';
        echo '<ul lang="he" style="list-style: none; margin-left: 0; padding-left: 0; direction: rtl; -webkit-column-count: 3; -moz-column-count: 3;">';
        $i = 0;
        while (($v = mysql_fetch_assoc($verbs_in_same_table)) && $i++ < 27) {
            echo '<li><a href="hebconj.php?verb_root=' . urlencode($v['verb_root']) . '&amp;tense_id=' . $v['tense_id'] . '">' . $v['verb_root'] . '</a></li>';
        }
        echo '</ul>';
        if ($n - $i) echo '<p>&hellip;plus ' . ($n - $i) . ' more</p>';
        echo '</div>';
    }
    echo '</div>';
    
?>
  <div lang="he" class="nohover">
  <table id="table" cellspacing="0" cellpadding="0" border="0">
   <caption><?php echo conjugate($row,$verb_root,4,0, $color_on); ?></caption>
   <tr id="first">
    <th id="shoresh">שֹׁרֶשׁ:&nbsp;<strong><?php echo $verb_root; ?></strong></th>
    <th id="gizrah" colspan="3">גִזְרָה</th>
    <th id="binyan">בִּנְיָן:&nbsp;<strong><?php echo $row["tense_name"]; ?></strong></th>
   </tr>
   <tr>
    <th></th>
    <th>הוֹוֶה</th>
    <th>עָבָר</th>
    <th>עָתִיד</th>
    <th>צִוּוּי</th>
   </tr>
<?php

if ($hspell_on) {
    $hspell_url = "http://wassist.cs.technion.ac.il/~danken/cgi-bin/cilla.cgi?root=".he($verb_root)."&binyan=".he($tense_ops[$tense_id]["hc"]);
    $html=iconv("ISO-8859-8","UTF-8",file_get_contents($hspell_url));
    $table = substr($html,strpos($html,"<TABLE"),strpos($html,"</TABLE")-strpos($html,"<TABLE")+8);

    // Make a 2-D array
    $result = array();
    for ($i = 1; $i <= 10; $i ++) {
      $result[$i] = array();
      for ($j = 0; $j < 5; $j ++) {
        $result[$i][$j] = '';
      }
    }
    // Fix invalid table HTML
    $table = preg_replace('#</td><tr>#si','</td></tr>',$table);
    $table = preg_replace('#(?<=.)(?<!</td>)</tr>#mi','</td></tr>',$table);
    // Swap avar and hoveh table cells
    $table = preg_replace('#<tr><td>(.*?)</td><td>(.*?)</td><td>(.*?)</td>#mi','<tr><td>$1</td><td>$3</td><td>$2</td>',$table);
    // Put link in first cell
    $table = preg_replace('#<tr><td></td>#','<tr><td><a style="font: 0.7em Lucida Grande;" href="' . $hspell_url . '">Hspell</a></td>',$table);
    
    
    // Scrape table cells into array
    preg_match_all('#(?<=<tr>).*?(?<=</tr>)#si',$table,$trarray);
    for ($i = 1; $i < count($trarray[0]); $i++) {
      preg_match_all('#(?<=<td>)[^<]*(?=</td>)#i',$trarray[0][$i],$rowarray);
      for ($j = 0; $j < count($rowarray[0]); $j++) {
        // The code below not needed since now swapping avar and hoveh table cells
        //if ($j == 2) $jj = 1;
        //else if ($j == 1) $jj = 2;
        //else
          $jj = $j;
        $result[$i][$j]=$rowarray[0][$jj];
      }
    }
    $result[1][1] = $result[2][1] . '<br />' . $result[3][1];
    $result[4][1] = $result[2][1];
    $result[5][1] = $result[3][1];
    $result[6][1] = $result[7][1] . '<br />' . $result[8][1];
    $result[9][1] = $result[7][1];
    $result[10]=array('',$result[8][1],$result[9][2],$result[8][3],'');
}

      foreach ($pronouns as $pron_index=>$pronoun) {
        echo "   <tr>\n     <th>$pronoun</th>\n";
        foreach ($tenses as $tense_index=>$tense) {
          //echo "    <td id=\"v$tense_index$pron_index\">",conjugate($row,$verb_root,$tense_index,$pron_index),"</td>\n";
          $my_conjugated = conjugate($row,$verb_root,$tense_index,$pron_index);
          $my_conjugated_color = conjugate($row,$verb_root,$tense_index,$pron_index, $color_on);
          if ($hspell_on)
            $hspell_conjugated = $result[$pron_index+1][$tense_index+1];
          $class = '';
          $devocalized_my_conjugated = niqqud_to_ktiv_male($my_conjugated);
          //$devocalized_my_conjugated = devocalize($my_conjugated);
          if ($hspell_on && $devocalized_my_conjugated != $hspell_conjugated && str_replace('<br />', '', $hspell_conjugated) != '')
            $class .= ' hspell-nomatch';
          $meat = $my_conjugated_color;
          if ($hspell_on)
            $meat = '<span class=\"a\">" . $meat . "</span><span class=\"b\">" . $hspell_conjugated . "</span>';
          echo "    <td id=\"v$tense_index$pron_index\" class=\"" . $class . "\" title=\"" . str_replace('<br />',"\n",$devocalized_my_conjugated) . "\">$meat</td>\n";
        }
       echo "   </tr>\n";
      }

?>
  </table>
  <p><br /></p>

<?php
  if ($hspell_on) echo $table;
?>
  </div>
  <script type="text/javascript" src="colorful-diacritics/test.js"></script>
<?php }} include("inc/lm.php"); /*lmp("hebconj.php");*/ include("inc/ga.php"); ?>
</body>
</html>
