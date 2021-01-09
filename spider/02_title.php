<?php
//永不超时
set_time_limit(0);
include __DIR__.'/function.php';
require '/vendor/autoload.php';
$url = 'https://news.ke.com/sz/baike/0033/';

$html = http_request($url);

use QL\QueryList;

$datalist = QueryList::Query($html,[
    'img'=>['.lj-lazy','data-original'],
    'title'=>['.item .text LOGCLICK','text'],
    'desn'=>['.item .text summary','text'],
    'href'=>['.item .text > a ','href'],
])->data;

//入库