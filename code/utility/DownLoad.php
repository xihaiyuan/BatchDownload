<?php

class DownLoad
{

    function load($url, $book, $newName)
    {
        $eData = ['title' => '', 'url' => ''];

        $ret = true;
        // curl下载文件
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1200); //链接等待10秒如果10秒没有建立连接成功则断开       
        curl_setopt($ch, CURLOPT_TIMEOUT, 1200); //链接等待10秒如果10秒没有建立连接成功则断开       
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //喜马拉雅是get也许有需要post的打开注释
        //curl_setopt($ch, CURLOPT_POST, 1);

        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $mp3 = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno :' . curl_error($ch);
            $eData['title'] = $book . "_" . $newName;
            $eData['url'] = $url;
            return $eData;
        }

        curl_close($ch);
        // 保存文件到指定路径
        //$book = substr($newName, 0, strpos($newName, ' '));
        //var_dump($book);
        //exit;
        $path = "././" . $book . "/";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path . $newName . ".m4a", $mp3);
        unset($mp3);
        return $ret;
    }
}
