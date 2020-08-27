<?php
include_once('utility/ArgsUtility.php');
include_once('utility/Curl.php');
include_once('utility/DownLoad.php');

$url = "https://www.ximalaya.com/xiangsheng/21343003/";
$playUrl = "";
$detailsUrl = "https://www.ximalaya.com/";
$type = '';
$data = array();
$cookie = '';

$curl = new Curl($cookie);
$html = $curl->call($url, $type, $data);

//获取文档元素
//表达式是W3C标准的XPath表达式
//https://www.w3school.com.cn/xpath/index.asp
//https://www.awaimai.com/2113.html
function getDOMDocument($html)
{
    $dom = new DOMDocument();
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);
    $nodeList = $xpath->query('//*[contains(@class, "text _Vc")]');
    $pageDatas = [];
    foreach ($nodeList as $node) {

        $pageData = ['title' => "", 'urlName' => ""];

        $links = $node->getElementsByTagName('a');

        foreach ($links as $a) {
            //echo $a->getAttribute('title') . "\n";
            $pageData['title'] = $a->getAttribute('title');
            $pageData['urlName'] = $a->getAttribute('href');

            array_push($pageDatas, $pageData);
        }
    }

    return $pageDatas;
}
$marks = getDOMDocument($html);
echo '本页信息';
print_r($mark);

foreach ($marks as $mark) {
    $url2 = $detailsUrl . $mark['urlName'];
    $html2 = $curl->call($url2, $type, $data);
    print_r($html2);
    exit;
    $download = new DownLoad();
}




//$args = getClientArgs();
//print_r($args);
