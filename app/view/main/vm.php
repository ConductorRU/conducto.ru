<?php
	use app\model\VK;
error_reporting(E_ALL);
ini_set('display_errors', 1);

$appId = 6199980;
$redirect = 'http://chronopolis.ru/vk';
$shildCode = '4dhUp6duyMJgJFuPEnrb';
$accessToken = 'f2d19306f2d19306f2d1930603f28f09aaff2d1f2d19306ab1dedd97a79a676dedad4b1';
if(!isset($_GET['code'])):
$myCurl = curl_init();
$url = 'https://oauth.vk.com/authorize?client_id=' . $appId . '&display=page&redirect_uri=' . $redirect . '&scope=friends,wall,photos&response_type=code&v=5.68';
?>
<a href="<?= $url ?>">Активировать приложение</a>
<?php
else:

	$url = 'https://oauth.vk.com/access_token?client_id=' . $appId . '&client_secret=' . $shildCode . '&redirect_uri=' . $redirect . '&code=' . $_GET['code'];

	$myCurl = curl_init();
	$headers = [];

	curl_setopt($myCurl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt_array($myCurl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => false,
	));
	$response = json_decode(html_entity_decode(curl_exec($myCurl)));
	$token = $response->access_token;
	curl_close($myCurl);
	
	$vkAPI = new VK(['access_token' => $token]);
	$photo = "/var/www/clients/client1/web8/web/app/web/img/koso.png";
	//$photo = "" . __DIR__ . "/why.jpg";
	//$photo = 'http://xn--45-6kca8af3a3a7b.xn--p1ai/local/php_interface/why.jpg';
	if($vkAPI->postToPublic(154138423, 'Text', $photo, ['вконтакте api', 'автопостинг', 'первые шаги']))
	{
		echo "Ура! Всё работает, пост добавлен\n";
	}
	else
	{
		echo "Фейл, пост не добавлен(( ищите ошибку\n";
	}

endif;