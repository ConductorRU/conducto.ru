<?php
	use app\model\VK;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$userId = 163756784;
$appId = 6199988;
$redirect = 'https://oauth.vk.com/blank.html';
$shildCode = 'D2u5rySNhdFlcgXsGUf9';
$accessToken = '3d991e83bbb5f397158b998e2d9a697bf8a2e19bb6392af8f688af8cac93a822ac4fd9b38975f489f1c99';

$code = '216c4e6f391fe8cce1';
if(!$accessToken && !$code && !isset($_GET['code'])):
$myCurl = curl_init();
$url = 'https://oauth.vk.com/authorize?client_id=' . $appId . '&display=page&redirect_uri=' . $redirect . '&scope=wall,photos&response_type=code&v=5.68';
?>
<a href="<?= $url ?>">Активировать приложение</a>
<?php
else:

	if(!$accessToken):
	$url = 'https://oauth.vk.com/access_token?client_id=' . $appId . '&client_secret=' . $shildCode . '&redirect_uri=' . $redirect . '&code=' . $code;
	$myCurl = curl_init();
	$headers = [];
	curl_setopt($myCurl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt_array($myCurl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => false,
	));
	$response = json_decode(html_entity_decode(curl_exec($myCurl)));
	$accessToken = $response->access_token;
	curl_close($myCurl);

	endif;
	
	
	$vkAPI = new VK(['access_token' => $accessToken]);
	$photo = "/var/www/clients/client1/web8/web/app/web/img/koso.png";
	//$photo = "" . __DIR__ . "/why.jpg";
	//$photo = 'http://xn--45-6kca8af3a3a7b.xn--p1ai/local/php_interface/why.jpg';
	if($postId = $vkAPI->postToPublic(154192232, 'Text', $photo, ['вконтакте api', 'автопостинг', 'первые шаги']))
	{
		echo "Ура! Всё работает, пост добавлен: ' . $postId . '\n";
	}
	else
	{
		echo "Фейл, пост не добавлен(( ищите ошибку\n";
	}

endif;