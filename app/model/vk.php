<?php
namespace app\model;

class VK
{
	const VERSION = '5.5';
	private $appId;
	private $secret;
	private $scope = array();
	private $redirect_uri;
	private $responceType = 'code';
	private $accessToken;
	public function __construct(array $config)
	{
		if(isset($config['access_token']))
			$this->setAccessToken(json_encode(['access_token' => $config['access_token']]));
		if(isset($config['app_id']))
			$this->setAppId($config['app_id']);
		if(isset($config['secret']))
			$this->setSecret($config['secret']);
		if(isset($config['scopes']))
			$this->setScope($config['scopes']);
		if(isset($config['redirect_uri']))
			$this->setRedirectUri($config['redirect_uri']);
		if(isset($config['response_type']))
			$this->setResponceType($config['response_type']);
	}
	public function getUserId()
	{
		return $this->accessToken->user_id;
	}
	public function setAppId($appId)
	{
		$this->appId = $appId;
		return $this;
	}
	public function getAppId()
	{
		return $this->appId;
	}
	public function setSecret($secret)
	{
		$this->secret = $secret;
		return $this;
	}
	public function getSecret()
	{
		return $this->secret;
	}

	public function setScope(array $scope)
	{
		$this->scope = $scope;
		return $this;
	}
	public function getScope()
	{
		return $this->scope;
	}
	public function setRedirectUri($redirect_uri)
	{
		$this->redirect_uri = $redirect_uri;
		return $this;
	}
	public function getRedirectUri()
	{
		return $this->redirect_uri;
	}
	public function setResponceType($responceType)
	{
		$this->responceType = $responceType;
		return $this;
	}
	public function getResponceType()
	{
		return $this->responceType;
	}
	public function getLoginUrl()
	{
		return 'https://oauth.vk.com/authorize'
		. '?client_id=' . urlencode($this->getAppId())
		. '&scope=' . urlencode(implode(',', $this->getScope()))
		. '&redirect_uri=' . urlencode($this->getRedirectUri())
		. '&response_type=' . urlencode($this->getResponceType())
		. '&v=' . urlencode(self::VERSION);
	}
	public function isAccessTokenExpired()
	{
		return time() > $this->accessToken->created + $this->accessToken->expires_in;
	}
	public function authenticate($code = NULL)
	{
		$code = $code ? $code : $_GET['code'];
		$url = 'https://oauth.vk.com/access_token'
				. '?client_id=' . urlencode($this->getAppId())
				. '&client_secret=' . urlencode($this->getSecret())
				. '&code=' . urlencode($code)
				. '&redirect_uri=' . urlencode($this->getRedirectUri());
		$token = $this->curl($url);
		$data = json_decode($token);
		$data->created = time(); // add access token created unix timestamp
		$token = json_encode($data);
		$this->setAccessToken($token);
		return $this;
	}
	public function setAccessToken($token)
	{
		$this->accessToken = json_decode($token);
		return $this;
	}
	public function getAccessToken()
	{
		return json_encode($this->accessToken);
	}
	public function api($method, array $query = array())
	{
		/* Generate query string from array */
		$parameters = array();
		foreach($query as $param => $value)
		{
			$q = $param . '=';
			if(is_array($value))
				$q .= urlencode(implode(',', $value));
			else
				$q .= urlencode($value);
			$parameters[] = $q;
		}

		$q = implode('&', $parameters);
		if(count($query) > 0)
			$q .= '&'; // Add "&" sign for access_token if query exists
		$url = 'https://api.vk.com/method/' . $method . '?' . $q . 'access_token=' . $this->accessToken->access_token;
		$result = json_decode($this->curl($url));
		if(isset($result->response))
			return $result->response;
		return $result;
	}
	protected function curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$result = curl_exec($ch);
		if(!$result)
		{
			$errno = curl_errno($ch);
			$error = curl_error($ch);
		}
		curl_close($ch);
		if (isset($errno) && isset($error))
		{
			throw new \Exception($error, $errno);
		}
		return $result;
	}
	public function uploadFile($url, $path)
	{
		/*$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, ['photo' => "$path"]);
		$data = curl_exec($ch);
		curl_close($ch);
		return json_decode($data, true);*/
		
		exec("curl -X POST -F 'photo=@$path' '$url'", $output);
		var_dump($output);
    $response = json_decode($output[0]);
		return $response;
	}
	public function postToPublic($publicID, $text, $fullServerPathToImage, $tags = array())
	{
		$response = $this->api('photos.getWallUploadServer', ['group_id' => $publicID,]);
		/*
		 * public 'upload_url' => string 'http://cs618028.vk.com/upload.php?act=do_add&mid=76989657&aid=-14&gid=70941690&hash=0c9cdfa73779ea6c904c4b5326368700&rhash=ba9b60e61e258bf8fd61536e6683e3af&swfupload=1&api=1&wallphoto=1' (length=185)
					public 'aid' => int -14
					public 'mid' => int 76989657
		 *
		 *  */
		$uploadURL = $response->upload_url;
		$output = [];
		
		/*$myCurl = curl_init();
		$headers = [];
		curl_setopt($myCurl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($myCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($myCurl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data'));
		curl_setopt_array($myCurl, array(
			CURLOPT_URL => $uploadURL,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
		));
		curl_setopt($myCurl, CURLOPT_POSTFIELDS, ['photo' => "$fullServerPathToImage"]);
		$output = html_entity_decode(curl_exec($myCurl));
		$response = json_decode($output);*/
		
		$response = $this->uploadFile($uploadURL, $fullServerPathToImage);

		/*
		 *  public 'server' => int 618028
					public 'photo' => string '[{"photo":"96df595e0b:z","sizes":[["s","618028657","c5b1","RfjznPPyhxs",75,54],["m","618028657","c5b2","dQRTijvf4tE",130,93],["x","618028657","c5b3","-zUzUi-uOkU",604,432],["y","618028657","c5b4","FAAY0vnMSWc",807,577],["z","618028657","c5b5","OBZqwGjlO9s",900,644],["o","618028657","c5b6","Ku7Q6IqN5uc",130,93],["p","618028657","c5b7","0eFhSRrjxvU",200,143],["q","618028657","c5b8","F8E6QJg51o4",320,229],["r","618028657","c5b9","-a3oiI8SVOg",510,365]],"kid":"6bba9104fa05dd017597abce3ebeb215"}]' (length=496)
					public 'hash' => string 'd02d83e70eca1c0d756d1a5d51c2fbfb' (length=32)
		 */

		//var_dump($response);
		
		$response = $this->api('photos.saveWallPhoto', [
				'group_id' => $publicID,
				'photo' => $response->photo,
				'server' => $response->server,
				'hash' => $response->hash,
		]);
		//var_dump($response);
		/*
*
* array (size=1)
0 =>
object(stdClass)[93]
public 'pid' => int 333363577
public 'id' => string 'photo76989657_333363577' (length=23)
public 'aid' => int -14
public 'owner_id' => int 76989657
public 'src' => string 'http://cs618028.vk.me/v618028657/c5c4/CJkUGsTNMNc.jpg' (length=53)
public 'src_big' => string 'http://cs618028.vk.me/v618028657/c5c5/6G5kG2qrd0A.jpg' (length=53)
public 'src_small' => string 'http://cs618028.vk.me/v618028657/c5c3/NjaefgAEqFA.jpg' (length=53)
public 'src_xbig' => string 'http://cs618028.vk.me/v618028657/c5c6/dyX4tBB3yaI.jpg' (length=53)
public 'src_xxbig' => string 'http://cs618028.vk.me/v618028657/c5c7/r8xGBKsau9c.jpg' (length=53)
public 'width' => int 900
public 'height' => int 644
public 'text' => string '' (length=0)
public 'created' => int 1402950212
*
*/
		if($tags)
			$text .= "\n\n";
		foreach($tags as $tag)
			$text .= ' #' . str_replace(' ', '_', $tag);
		$text = html_entity_decode($text);
		$response = $this->api('wall.post',
		[
			'owner_id' => '-' . $publicID,
			'from_group' => 1,
			'message' => $text,
			'attachments' => $response[0]->id, // uploaded image is passed as attachment
		]);
		var_dump($response);
		return isset($response->post_id);
	}
}