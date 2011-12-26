<?php

require_once 'hebconj-functions.php';

require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');

class TestOfNiqqudToKtivMale extends UnitTestCase {
    public $unit_tests = array(
        'סוֹגְרִים' => 'סוגרים',
        'סוֹגְרוֹת' => 'סוגרות',
        'אוֹהֵב' => 'אוהב',
        'אֹהַב' => 'אוהב',
        'אֱכֹל' => 'אכול',
        'תֹּאכַל' => 'תאכל',
        'עָיֵף' => 'עייף',
        'יְשֵנִים/יְשֵנוֹת' => 'ישנים/ישנות',
        'יִפֹּל' => 'יפול',
        'בִּעֲתֻנִי' => 'ביעתוני',
        'מֻכְמָן' => 'מוכמן',
        'בִּמְנֹד' => 'במנוד',
        'אַפַּיִם' => 'אפיים',
        'נַלֹּשׁ' => 'נלוש',
        'לִרְוָחָה' => 'לרווחה',
        'הִנֵּה' => 'הנה',
        'דִּמְיוֹן' => 'דמיון',
        'תִּשָּׁמֵר' => 'תישמר',
        'מְכֻוָּן' => 'מכוון',
        'הִתְחַתַּנּוּ' => 'התחתנו',
        'וּוָוֹו' => 'וווו',
        'אַתְּ' => 'את',
        'מִגְדָּל' => 'מגדל',
        'מֶרְכָּבָה' => 'מרכבה',
        'מַחְשֵב' => 'מחשב',
        'תָּכְנִית' => 'תכנית',
        'לֵשֵב' => 'לישב',
        'תָּו' => 'תו',
        'אַוָּז' => 'אווז',
        'תִּוֵּךְ' => 'תיווך',
        'תִּקְוָה' => 'תקווה',
        'הַוַעַד' => 'הוועד',
        'וָתִיק' => 'ותיק',
        'כִּסְלֵו' => 'כסלו',
        'לָאו' => 'לאו',
        'יַחְדָּו' => 'יחדיו',
        'יֹאהַב' => 'יאהב',
        'תֹאהַבְנָה' => 'תאהבנה',
        'נֹאבֶה' => 'נאבה',
        'נֹאחַז' => 'נאחז',
        'עָשֹה' => 'עשה',
        'הָפְקַד' => 'הופקד',
        'מָשְחָת' => 'מושחת',
        'מֹאזְנֲיִם' => 'מאזניים',
        'כֹּה' => 'כה',
        'בֹּקֶר' => 'בוקר',
        'לִשְׁמֹר' => 'לשמור',
        'חֳדָשִׁים' => 'חודשים',
        'יְצוּר' => 'יצור',
        'מִיָּדִי' => 'מידי',
        'דַּיָּהּ' => 'דייה',
        'דְּבָרַיִךְ' => 'דברייך',
        'לְיַצֵּר' => 'ליצר',
        'הָיְתָה' => 'היתה',
        'רְאָיָה' => 'ראיה',
        'גִּלּוּיוֹ' => 'גילויו',
        'שַׁיִט' => 'שיט',
        'יְיַסֵּד' => 'ייסד',
        'סִכּוּיַי' => 'סיכויי',
        'לֻוּו' => 'לוו',
        'שׂוּלְטָאן' => 'שולטאן',
        'סֻפַּר' => 'סופר',
        'תֵּהָנֶה' => 'תיהנה',
        'חֵמָה' => 'חמה',
        'לֵידַע' => 'לידע',
        'הֶכֵּר' => 'היכר',
        'הֶשֵּׂג' => 'הישג',
        'הֶשֵּׂג' => 'הישג',
        'הֶקֵּשׁ' => 'היקש',
        'הֶשֵּׂגִיּוּת' => 'הישגיות',
        'הֶכֵּרוּת' => 'היכרות',
        'הִנְנוֹ' => 'הננו',
        'הֶסֵּטוּת' => 'היסטות',
        'הִנָּן' => 'הנן',
        'הִנְּכֶם' => 'הנכם',
        'מִמֶּנּוּ' => 'ממנו',
        'הִכָּה' => 'הכה',
        'הִתִּיר' => 'התיר',
        'הִצִּיעוּ' => 'הציעו',
        'דִּיּוּן' => 'דיון',
        'רְאִיּוֹת' => 'ראיות',
        'רְאִיּוֹתַיו' => 'ראיותיו',
        'מִקֵּץ' => 'מקץ',
        'שִׂמְחָה' => 'שמחה',
        'מִלְוֶה' => 'מלווה',
        'מִנְהָל' => 'מנהל',
        'פִּקֵּח' => 'פיקח',
        'סִבָּה' => 'סיבה',
        'רְאִיָּה' => 'ראייה',
    );
    
    public function testNiqqudToKtivMale() {
        /*
        foreach ($this -> unit_tests as $input => $expected) {
            $output = niqqud_to_ktiv_male($input);
            $this -> assertIdentical($output, $expected, '<span lang="he">' . $input . '</span> &rarr; <span lang="he">' . $output . '</span> ' . ($output == $expected ? '=' : '&ne;') . ' <span lang="he">' . $expected . '</span>');
        }*/
        $inputs = array_keys($this -> unit_tests);
        $outputs = devocalize($inputs);
        print_r($outputs);
        $expecteds = array_values($this -> unit_tests);
        foreach ($outputs as $i => $output) {
            $input = $inputs[$i];
            $expected = $expecteds[$i];
            $this -> assertIdentical($output, $expected, '<span lang="he">' . $input . '</span> &rarr; <span lang="he">' . $output . '</span> ' . ($output == $expected ? '=' : '&ne;') . ' <span lang="he">' . $expected . '</span>');
        }
    }
}

class ShowPasses extends HtmlReporter {
    function ShowPasses($character_set = 'ISO-8859-1') {
        $this -> HtmlReporter($character_set);
    }
    function paintHeader($test_name) {
        $this->sendNoCacheHeaders();
        print "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">";
        print "<html>\n<head>\n<title>$test_name</title>\n";
        print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=" .
                $this->_character_set . "\">\n";
        print "<style type=\"text/css\">\n";
        print $this->_getCss() . "\n";
        print "</style>\n";
        print "</head>\n<body>\n";
        print "<h1>$test_name</h1>\n";
        flush();
    }
    
    function paintPass($message) {
        $this -> _passes++;
        print '<strong class="pass">Pass</strong>: ';
        $breadcrumb = $this -> getTestList();
        array_shift($breadcrumb);
        //print implode(' &rarr; ', $breadcrumb);
        //print ': ' . /*$this -> _htmlEntities*/($message) . "<br />\n";
        print $message . "<br />\n";
    }
    
    function paintFail($message) {
        $this -> _fails++;
        print '<strong class="fail">Fail</strong>: ';
        $breadcrumb = $this -> getTestList();
        array_shift($breadcrumb);
        //print implode(' &rarr; ', $breadcrumb);
        //print ': ' . /*$this -> _htmlEntities*/($message) . "<br />\n";
        print $message . "<br />\n";
    }
    
    function _getCss() {
        return parent::_getCss() . ' body { font-family: Consolas, monospace; } [lang="he"] { unicode-bidi: embed; font-family: "SBL Hebrew", "Narkisim" }';
    }
}

$test = new TestOfNiqqudToKtivMale();
$test -> run(new ShowPasses('UTF-8'));

?>