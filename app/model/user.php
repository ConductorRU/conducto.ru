<?php
namespace app\model;
use core\dc\Model;
use core\dc\DC;
class User extends Model
{
	const ENTITY_TYPE = 1;
	public static function Create($login, $email, $password, $status = 1)
	{
		$user = new User;
		$user->entity_id = Entity::CreateId();
		$user->login = $login;
		$user->email = $email;
		$user->status = $status;
		$user->setPassword($password);
		$user->generateAuthKey();
		$user->created_at = date('Y-m-d H:i:s');
		$user->updated_at = $user->created_at;
		$user->save();
		if($user->id)
			return $user;
		return null;
	}
	public function IsYou()
	{
		if(!DC::$app->user || DC::$app->user->id != $this->id)
			return 0;
		return 1;
	}
	public function setPassword($password)
	{
		$this->password_hash = hash('md5', $password);
	}
	public function generateAuthKey()
	{
		$this->auth_key = hash('md5', random_int(PHP_INT_MIN, PHP_INT_MAX));
	}
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = hash('md5', random_int(PHP_INT_MIN, PHP_INT_MAX)) . '_' . time();
	}
	public static function GetById($id)
	{
		return User::findWhere('id="' . $id . '"');
	}
	public static function GetByLogin($login)
	{
		return User::findWhere('login="' . DC::$app->db->e($login) . '"');
	}
	public static function GetByEmail($email)
	{
		return User::findWhere('email="' . DC::$app->db->e($email) . '"');
	}
	public static function GetByPassword($email, $password)
	{
		$user = User::findWhere('email="' . DC::$app->db->e($email) . '"');
		if($user && $user->password_hash == hash('md5', $password))
			return $user;
		return null;
	}
	public static function GetByHash($email, $hash)
	{
		$user = User::findWhere('email="' . DC::$app->db->e($email) . '"');
		if($user && $user->password_hash == $hash)
			return $user;
		return null;
	}
	public function Connect()
	{
		$time = time() + 60*60*24*365;
		setcookie('id', $this->id, $time);
		setcookie('email', $this->email, $time);
		setcookie('hash', $this->password_hash, $time);
		DC::$app->session->Set('id', $this->id);
		DC::$app->session->Set('email', $this->email);
		DC::$app->session->Set('password', $this->password_hash);
	}
	public static function Login($email, $password)
	{
		$user = static::GetByPassword($email, $password);
		if($user)
		{
			if($user->status == 0)
				return 2;
			if($user->status == 2)
				return 3;
			$user->Connect();
			return 0;
		}
		return 1;
	}
	public static function Logout()
	{
		$time = time() - 60*60;
		setcookie('id', 0, $time);
		setcookie('email', 0, $time);
		setcookie('password', 0, $time);
		DC::$app->session->Destroy();
		DC::$app->user = null;
	}
	public function GetUrl()
	{
		return '/id' . $this->id;
	}
	public static function MaxId()
	{
		return User::FindOne('MAX(id)');
	}
}