<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link href="/css.css" type="text/css" rel="stylesheet" />
<meta http-equiv="Content-Type" content="text/xhtml; charset=utf-8" />
<script type="text/javascript">
function strip_niqqud() {
  rep={'\n':'","','\u05B0':'','\u05B1':'','\u05B2':'','\u05B3':'','\u05B4':'','\u05B5':'','\u05B6':'','\u05B7':'','\u05B8':'','\u05B9':'','\u05BB':'','\u05BC':'','\u05BF':'','\u05C1':'','\u05C2':'',
       '\uFB30':'\u05D0','\uFB31':'\u05D1','\uFB32':'\u05D2','\uFB33':'\u05D3','\uFB35':'\u05D5','\uFB4B':'\u05D5','\uFB36':'\u05D6','\uFB38':'\u05D8','\uFB39':'\u05D9','\uFB3A':'\u05DA','\uFB3B':'\u05DB',
       '\uFB3C':'\u05DC','\uFB3E':'\u05DE','\uFB40':'\u05E0','\uFB41':'\u05E1','\uFB43':'\u05E3','\uFB44':'\u05E4','\uFB46':'\u05E6','\uFB47':'\u05E7','\uFB48':'\u05E8','\uFB2A':'\u05E9','\uFB2B':'\u05E9','\uFB2C':'\u05E9','\uFB2D':'\u05E9','\uFB49':'\u05E9','\uFB4A':'\u05EA'};
  document.getElementById("out").innerHTML=document.getElementById("inp").value.replace(
        /[\n\u05B0\u05B1\u05B2\u05B3\u05B4\u05B5\u05B6\u05B7\u05B8\u05B9\u05BB\u05BC\u05BF\u05C1\u05C2אּבּגּדּוּוֹזּטּיּךּכּלּמּנּסּףּפּצּקּרּשׁשׂשּׁשּׂשּתּ]/g,function(x){return rep[x]});
}
function fix_sofit(input) {
  sofit = {
            'm': 'M',
            '\u05DB': '\u05DA',
            '\u05DE': '\u05DD',
            '\u05E0': '\u05DF',
            '\u05E4': '\u05E3',
            '\u05E6': '\u05E5',
          };
  from1 = Object.keys(sofit).map(function(v,i){ return v + '(\\b)'; });
  to1 = Object.keys(sofit).map(function(v,i){ return sofit[v] + '$1'; });
  from2 = Object.keys(sofit).map(function(v,i){ return sofit[v] + '(\\B)'; });
  to2 = Object.keys(sofit).map(function(v,i){ return v + '$1'; });
  output = tr(tr(input, from1, to1), from2, to2);
  document.getElementById("out").innerHTML = output;
  return output;
}
function tr(str, from, to) {
    var subst;
    for (i = 0; i < from.length; i++) {
        subst = (to[i]) ? to[i] : to[to.length-1];
        str = str.replace(new RegExp(from[i], 'g'), subst);
    }
    return str;
}
</script>
<title>Regex Tester</title>
</head>
<body>
<p><textarea rows="16" cols="25" style="width:25em; height:16em;" id="inp">‫צֻפָּה ‫רֻמָּה ‫שֻׁנָּה ‫שֻׁסָּה</textarea></p>
<p><textarea rows="2" cols="20" id="out"></textarea></p>
<p><input type="button" onclick="strip_niqqud();" value="Strip Niqqud" /> <input type="button" onclick="fix_sofit(this.value);" value="Fix Sofit" /></p>
<?php include("inc/lm.php"); lmf(); include("inc/ga.php"); ?>
</body>
</html>
