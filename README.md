# 苹果asa数据报告获取apple_search_ads
苹果asa数据报告获取apple_search_ads，php版接口

composer快速安装：

composer require ldg/asaapi

内置请求方法：

GET: _geturl    获取数据

POST:_posturl   提交数据

PUT:_puturl     修改数据

DELETE:_deleteurl 删除数据

（传入参数请用数组json_encode）

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


