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
    );
    
    public function testNiqqudToKtivMale() {
        foreach ($this -> unit_tests as $input => $expected) {
            $output = niqqud_to_ktiv_male($input);
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