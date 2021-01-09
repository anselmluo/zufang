<?php
//永不超时
set_time_limit(0);
include __DIR__.'/function.php';
require '/vendor/autoload.php';

use QL\QueryList;

$db = new PDO('mysql:host=localhost;dbname=zufang.com;charts=usf8mb4','root','word567');

//内容页
$sql = "select id,url from articles where body = ''";
$rows = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $item){
    //todo：判断是否存在，存在则不存
    $id = $item['id'];
    $url = $item['url'];
    $html = http_request($url);
    //分析采集到的内容
    $ret = QueryList::Query($html,[
        'body'=>['.bd','href'],
    ])->data;
    //入库
    $sql = "update articles set body = ? where id=?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$body,$id]);
}

