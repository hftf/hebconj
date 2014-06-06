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
<script type="text/javascript" src="/inc/st.js"></script>
</head><body>
<?php

set_time_limit(0);

include("inc/db.php");

mysql_select_db("hebconj");
mysql_query("SET NAMES \"utf8\"");

?>

<h2>Hebrew Verbs List</h2>
<p>The <strong>Hebrew Verb Conjugator</strong> is a work in progress. The following table includes almost all Hebrew verbs in each of the seven <a href='http://en.wikipedia.org/wiki/Binyan'>constructions</a>. Click on a verb in the <code>verb_root</code> column to conjugate it. Click on a column header to <a href='http://www.kryogenix.org/code/browser/sorttable/'>sort</a>. Only verbs in <em>Tables 1 through <?php $r=mysql_fetch_row(mysql_query("select count(*) from tables")); echo $r[0]; ?></em> without a <a href='http://en.wikipedia.org/wiki/Final_form'>sofit</a> currently work as expected, and only about <em><?php $r=mysql_fetch_row(mysql_query("select count(*) from verbs where verb_root != ''")); echo $r[0]; ?> of 2500</em> verbs have been included. The verbs of the as yet empty tables will be inserted soon, and more functionality will continually be added, so return here in the near future to see updates. Please note that the verbs have been manually entered, and may contain errors; if you find any, contact me at <a href='mailto:hangfromthefloor+hvc@gmail.com'>hangfromthefloor+hvc@gmail.com</a>.</p>

<?php
display_db_query("SELECT verb_id, verbs.table_id, verb_root, tense_name, verbs.tense_id, LENGTH(table_rule) FROM verbs LEFT JOIN tenses ON (verbs.tense_id=tenses.tense_id) LEFT JOIN tables ON (verbs.table_id = tables.table_id)",$connection);

function display_db_query($query_string,$connection) {
  $result_id=mysql_query($query_string,$connection) or die(mysql_error());
  $column_count=mysql_num_fields($result_id) or die(mysql_error());
  echo "<table class=\"sortable\" border=\"1\" style=\"width:auto;margin-top:1em;\">\n<tr>";
    for($column_num=0;$column_num<$column_count-1;$column_num++)
      echo "<th>",mysql_field_name($result_id,$column_num),"</th>";
    echo "</tr>\n";
  while($row=mysql_fetch_row($result_id)) {
    echo "<tr>";
    for($column_num=0;$column_num<$column_count-1;$column_num++) {
      echo "<td class=\"c$column_num\">";
      if($column_num==2) echo "<a href=\"hebconj.php?verb_root=",urlencode($row[$column_num]),"&amp;tense_id={$row[4]}\">";
      if($column_num==1 && empty($row[5])) echo '<del>';
      echo $row[$column_num];
      if($column_num==1 && empty($row[5])) echo '</del>';
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