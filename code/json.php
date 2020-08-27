<?php
include_once('utility/ArgsUtility.php');
include_once('utility/Curl.php');
include_once('utility/DownLoad.php');
include_once('utility/ArrayUtility.php');



//17020830
$parame = ['c' => 21343003, 'p' => 1, 'dir' => ''];
$args = getClientArgs();
//
$parame['c'] = empty($args['c']) ? 21343003 : $args['c']; //url上的专辑编号
$parame['p'] = empty($args['p']) ? 1 : $args['p'];        //页面的页码
$parame['dir'] = empty($args['dir']) ? "新下载" . time() : $args['dir']; //下载到的文件夹
//当前下载节目id
$trackId = 0;
$pagesize = 30;



echo "当前页码";
print_r($parame);

$serverUrl = "https://www.ximalaya.com/revision/album/v1/";
$pageUrl = "getTracksList?albumId=" . $parame['c'] . "&pageNum=" . $parame['p'] . "&pageSize" . $pageSize;


//$detailsUrl = "https://www.ximalaya.com/revision/play/v1/audio?id=" . $trackId . "&ptype=1";

$type = '';
$data = array();
$cookie = '';

$url = $serverUrl . $pageUrl;



$curl = new Curl($cookie);
$pageJson = $curl->call($url, $type, $data);



$content = json_decode($pageJson);
$contentArry = objectToarray($content);
//总数
$total = $contentArry['data']['trackTotalCount'];
//总页数
$totalPage = floor(($total + $pagesize - 1) / $pagesize);

$downLoad = new DownLoad();

$errorData = ['c' => $parame['c'], 'p' => $parame['p'], 'errData' => []];
$eData = ['title' => '', 'url' => ''];
foreach ($contentArry['data']['tracks'] as $data) {
    echo $data['title'];
    echo "----";
    echo $data['trackId'];
    echo "\n";
    $trackId = $data['trackId'];
    $newName = $data['title'];

    $detailsUrl = "https://www.ximalaya.com/revision/play/v1/audio?id=" . $trackId . "&ptype=1";

    $detailJson = $curl->call($detailsUrl, $type, $data);

    $detail = json_decode($detailJson, true);

    var_dump($detail['data']['src']);

    $src = $detail['data']['src'];

    $eData['title'] = $newName . "_" . $trackId;
    $eData['url'] = $src;

    try {
        $ret = $downLoad->load($src, $parame['dir'], $newName);
        if ($ret === true) {
            echo "ok";
            echo "\n";
        } else {
            print_r($eData);
            array_push($errorData['errData'], $eData);
        }
    } catch (Exception $e) {
        var_dump($eData);
    }
}

var_dump($totalPage);
print_r($errorData);
echo $parame['p'] . "/" . $totalPage;
//使用方法
//c资源id
//p页面页码
//dir保存目录
//  php json.php c=23363498 p=5 dir=一战全史-全景再现空前军事浩劫