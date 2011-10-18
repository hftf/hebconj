<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link href="/css.css" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
<title>Hebrew Verbs List</title>
<style type="text/css">
  table {border: 1px #bbd solid; }
  tr:nth-child(2n) { background: #eef; }
  th { cursor: pointer; letter-spacing: -1px; }
  td { padding: 1px 8px; }
  .c2, .c3 { text-align: right; font: 16px narkisim, inherit; }
</style>
<script type="text/javascript" src="http://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
</head><body>
<?php

$setup=false;
$semicolon=";";
$printer=false;
set_time_limit(0);

include("inc/db.php");

if ($setup) {
  mysql_query("DROP DATABASE IF EXISTS hebconj");
  mysql_query("CREATE DATABASE hebconj");
}
mysql_select_db("hebconj");
mysql_query("SET NAMES \"utf8\"");
if ($setup) {
  mysql_query("CREATE TABLE verbs (
    verb_id     INT NOT NULL AUTO_INCREMENT,
    table_id    INT NOT NULL,
    tense_id    INT NOT NULL,
    verb_root   VARCHAR(16) NOT NULL,
    verb_avar   VARCHAR(16) NULL,
    verb_prep   VARCHAR(16) NULL,
    PRIMARY KEY(verb_id))");
  mysql_query("CREATE TABLE tenses (
    tense_id    INT NOT NULL AUTO_INCREMENT,
    tense_name  VARCHAR(16) NOT NULL,
    PRIMARY KEY(tense_id))");
  mysql_query("CREATE TABLE tables (
    table_id    INT NOT NULL AUTO_INCREMENT,
    table_rule  VARCHAR(512) NOT NULL,
    PRIMARY KEY(table_id))");

$tenses=array();
$tense_indices=array(1,65,91,118,135,178,212,236);
for($index=1;$index<8;$index++)
  $tenses+=array_fill($tense_indices[$index-1],$tense_indices[$index]-$tense_indices[$index-1],$index);

$tense_names=array("פָּעַל","נִפְעַל","פִּעֵל","פֻּעַל","הִתְפַּעֵל","הִפְעִיל","הֻפְעַל");

include "hebconj-verbs.php";
include "hebconj-tables.php";

//echo "<h3>produces:</h3><pre style=\"margin-left:4em;line-height:1;\">";print_r($verbs);echo "</pre>";
if($printer) echo "<h3>SQL queries</h3><pre>";

if($printer) echo "DROP DATABASE IF EXISTS hebconj;
CREATE DATABASE hebconj;
USE hebconj;
SET NAMES \"utf8\";
CREATE TABLE verbs (
  verb_id     INT NOT NULL AUTO_INCREMENT,
  table_id    INT NOT NULL,
  tense_id    INT NOT NULL,
  verb_root   VARCHAR(16) NOT NULL,
  PRIMARY KEY(verb_id));
CREATE TABLE tenses (
  tense_id    INT NOT NULL AUTO_INCREMENT,
  tense_name  VARCHAR(16) NOT NULL,
  PRIMARY KEY(tense_id));\n\n";

foreach ($verbs as $table_index=>$table)
  foreach ($table as $verb_index=>$verb) {
    $query="INSERT INTO verbs (table_id,tense_id,verb_root) VALUES (".$table_index.",".$tenses[$table_index].",'".$verb."')".$semicolon;
    if($setup) $result=mysql_query($query) or die(mysql_error());
  if($printer) echo "\n$query",$semicolon;
}

foreach ($tense_names as $tense_id=>$tense_name) {
  $query="INSERT INTO tenses (tense_name) VALUES ('".$tense_name."')";
  if($setup) $result=mysql_query($query) or die(mysql_error());
  if($printer) echo "\n$query",$semicolon;
}

foreach ($table_rules as $table_id=>$table_rule) {
  $query="INSERT INTO tables (table_rule) VALUES ('".$table_rule."')";
  if($setup) $result=mysql_query($query) or die(mysql_error());
  if($printer) echo "\n$query",$semicolon;
}

if($printer) echo "</pre>";
}

?>

<h2>Hebrew Verbs List</h2>
<p>The <strong>Hebrew Verb Conjugator</strong> is a work in progress. The following table includes almost all Hebrew verbs in each of the seven <a href='http://en.wikipedia.org/wiki/Binyan'>constructions</a>. Click on a verb in the <code>verb_root</code> column to conjugate it. Click on a column header to <a href='http://www.kryogenix.org/code/browser/sorttable/'>sort</a>. Only verbs in <em>Tables 1 through <?php $r=mysql_fetch_row(mysql_query("select count(*) from tables")); echo $r[0]; ?></em> without a <a href='http://en.wikipedia.org/wiki/Final_form'>sofit</a> currently work as expected, and only about <em><?php $r=mysql_fetch_row(mysql_query("select count(*) from verbs")); echo $r[0]; ?> of 2500</em> verbs have been included. The verbs of the as yet empty tables will be inserted soon, and more functionality will continually be added, so return here in the near future to see updates. Please note that the verbs have been manually entered, and may contain errors; if you find any, contact me at <a href='mailto:hangfromthefloor+hvc@gmail.com'>hangfromthefloor+hvc@gmail.com</a>.</p>

<?php
display_db_query("SELECT verb_id, table_id, verb_root, tense_name, verbs.tense_id FROM verbs LEFT JOIN tenses ON (verbs.tense_id=tenses.tense_id)",$connection);

function display_db_query($query_string,$connection) {
  $result_id=mysql_query($query_string,$connection) or die(mysql_error());
  $column_count=mysql_num_fields($result_id) or die(mysql_error());
  echo "<table class=\"sortable\" border=\"1\" style=\"width:auto;margin-top:1em;\">\n<tr>";
    for($column_num=0;$column_num<$column_count;$column_num++)
      echo "<th>",mysql_field_name($result_id,$column_num),"</th>";
    echo "</tr>\n";
  while($row=mysql_fetch_row($result_id)) {
    echo "<tr>";
    for($column_num=0;$column_num<$column_count;$column_num++) {
      echo "<td class=\"c$column_num\">";
      if($column_num==2) echo "<a href=\"hebconj.php?verb_root=",urlencode($row[$column_num]),"&amp;tense_id={$row[4]}\">";
      echo $row[$column_num];
      if($column_num==2) echo "</a>";
      echo "</td>";
    }
    echo "</tr>\n";
  }
  echo "</table>\n";
}
mysql_close($connection); ?>
<?php include("inc/lm.php"); lmf(); include("inc/ga.php"); ?>
</body>
</html>