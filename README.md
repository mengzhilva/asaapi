# asaapi
苹果asa数据报告获取apple_search_ads，php版接口

composer快速安装：

composer require ldg/asaapi


苹果文档地址：https://developer.apple.com/documentation/apple_search_ads/

使用方法

$orgid = '';

$client_id = '';

$team_id = '';

$key_id = '';	

$keypem = ''; 私钥

$asa = new asaapi($orgid, $client_id, $team_id, $key_id, $keypem);

$url = 'https://api.searchads.apple.com/api/v4/campaigns';

$cam = $asa->_geturl($url);

var_dump($cam);


