<?php
//永不超时
set_time_limit(0);
include __DIR__.'/function.php';
require '/vendor/autoload.php';

use QL\QueryList;

$db = new PDO('mysql:host=localhost;dbname=zufang.com;charts=usf8mb4','root','word567');

$range = range(1,2);//页码
foreach ($range as $page){
    $url = 'https://news.ke.com/sz/baike/0033/pg'.$page.'/';
    $html = http_request($url);

    $datalist = QueryList::Query($html,[
        'pic'=>['.lj-lazy','data-original','',function($item){
            //得到扩展名
            $ext = pathinfo($item,PATHINFO_EXTENSION);
            //生成文件名
            $filename = md5($item).'_'.time().'.'.$ext;
            //生成本地路径
            $filepath = dirname(__DIR__).'public/uploads/article/'.$filename;
            file_put_contents($filepath,http_request($item));
            return '/uploads/article/'.$filename;
        }],
        'title'=>['.item .text LOGCLICK','text'],
        'desn'=>['.item .text summary','text'],
        'url'=>['.item .text > a ','href'],
    ])->data;
    //入库
    foreach ($datalist as $val){
        $sql = "insert into articles (title,desn,pic,url,body) values (?,?,?,?,'')";
        $stmt = $db->prepare($sql);
        $stmt->execute([$val['title'],$val['desn'],$val['pic'],$val['url']]);
    }
}
