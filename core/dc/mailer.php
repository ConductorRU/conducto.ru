<?php
namespace Core\DC;
class Mailer
{
	public static function Send($to, $subject, $body)
	{
		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: Хронополис <no-reply@chronopolis.ru>\r\n";
		$message = '
		<html>
			<head>
				<title>'.$subject.'</title>
			</head>
			<body>' . $body . '</body>
		</html>';
		return mail($to, $subject, $message, $headers);
	}
}