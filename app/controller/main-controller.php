<?php
namespace app\controller;
use core\dc\DC;
use core\dc\Controller;
use core\dc\Mailer;
use app\model\User;

class MainController extends BaseController
{
	public function actionVK()
	{
		$this->render('vk');
	}
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionUser()
	{
		$user = User::GetById($id);
		$this->render('index', ['user' => $user]);
	}
	public function actionReg()
	{
		$this->render('reg');
	}
	public function actionLogin()
	{
		$this->formatJson();
		$items = ['r' => 's'];
		$email = DC::$app->request->params['email'] ?? '';
		$password = DC::$app->request->params['password'] ?? '';
		$email = trim($email);
		$password = trim($password);
		$num = User::Login($email, $password);
		if($num == 1)
			$items = ['r' => 'f', 'text' => 'Неправильный логин или пароль'];
		else if($num == 2)
			$items = ['r' => 'f', 'text' => 'Пользователь удален'];
		else if($num == 3)
			$items = ['r' => 'f', 'text' => 'Пользователь не подтвержден'];
		return $items;
	}
	public function actionSignup()
	{
		$this->formatJson();
		$items = ['r' => 's'];
		$login = DC::$app->request->params['login'] ?? '';
		$email = DC::$app->request->params['email'] ?? '';
		$password = DC::$app->request->params['password'] ?? '';
		$login = trim($login);
		$email = trim($email);
		$password = trim($password);
		if(User::GetByLogin($login))
			$items = ['r' => 'f', 'name' => 'login', 'text' => 'Такой логин уже существует'];
		else if(mb_strlen($login) > 30)
			$items = ['r' => 'f', 'name' => 'login', 'text' => 'Логин не должен содержать более 30ти символов'];
		else if(substr_count($login, '@'))
			$items = ['r' => 'f', 'name' => 'login', 'text' => 'Логин не должен содержать символ @'];
		else if(User::GetByEmail($email))
			$items = ['r' => 'f', 'name' => 'email', 'text' => 'Такой e-mail уже зарегистрирован'];
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$items = ['r' => 'f', 'name' => 'email', 'text' => 'E-mail адрес указан неверно'];
		else
		{
			$user = User::Create($login, $email, $password, 2);
			if($user)
			{
				$h = 'http://' . DC::$app->GetRoot() . '/confirm?key=' . $user->id . '_' . $user->auth_key;
				$body = '<div>Здравствуйте, ' . $login . '. Вы были успешно зарегистрированы на сайте <a href="http://' . DC::$app->GetRoot() . '">Хронополис</a>. Для подтверждения регистрации перейдите по ссылке: </div><div><a href="' . $h . '">подтверждение регистрации</a></div>';
				Mailer::Send($email, 'Подтверждение регистрации', $body);
				$items['text'] = '<div class="alert success"><h2>Регистрация прошла успешно!</h2><div>На вашу почту <b>' . $email . '</b> отправлено письмо, содержащее ссылку для подтверждения регистрации.</div></div>';
			}
		}
		return $items;
	}
	public function actionConfirm()
	{
		$key = DC::$app->request->params['key'] ?? '';
		$r = '<div class="alert error">Неверный ключ доступа</div>';
		if($key)
		{
			$m = explode('_', $key);
			if(count($m) == 2)
			{
				$user = User::GetById((int)$m[0]);
				if(!$user)
					$r = '<div class="alert error">Пользователя, связанного с этим ключом, не существует</div>';
				else if($user->status == 1)
				{
					$user->Connect();
					$r = '<div class="alert warning">Пользователь уже подтвержден</div>';
				}
				else if($user->auth_key == $m[1])
				{
					//$user->auth_key = '';
					$user->status = 1;
					$user->Connect();
					$user->Update();
					$r = '<div class="alert success">Регистрация успешно завершена</div>';
				}
			}
		}
		$this->render('index', ['alert' => ('<div id="eReg">' . $r . '</div>')]);
	}
	public function actionLogout()
	{
		User::Logout();
		header('Location: /');
	}
}