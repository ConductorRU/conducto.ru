<?php
namespace core\dc;
class Session
{
	public function __construct()
	{
		session_start();
	}
	public function __destruct()
	{
		$this->Close();
	}
	public function Open()
	{
		if(session_id() == '')
			session_start();
	}
	public function GetId()
	{
		return session_id();
	}
	public function Is($key)
	{
		return isset($_SESSION[$key]) ? true : false;
	}
	public function Set($key, $val)
	{
		$_SESSION[$key] = $val;
	}
	public function Get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
	}
	public function Close()
	{
		if(session_id() != '')
			session_write_close();
	}
	public function Destroy()
	{
		if(session_id() != '')
			session_destroy();
	}
}