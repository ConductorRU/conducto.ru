<?php
namespace Core\DC;
use app\controller\MainController;
class View
{
	const HEAD = 0;
	const BEGIN = 1;
	const END = 2;
	public $controller = null;
	public $view = 'index';
	public $title = '';
	public $path = '';
	public $adds = [];
	public $ready = [];
	private function printAdds($n)
	{
		$web = DC::$app->GetConfig('web');
		if($web != '')
			$web = '/' . $web;
		foreach($this->adds[$n] as $c)
		{
			if($c['type'] == 'css')
				echo '<style type="text/css">' . $c['text'] . '</style>';
			if($c['type'] == 'css_file')
				echo '<link rel="stylesheet" type="text/css" href="' . $web . '/css/' . $c['text'] . '">';
			if($c['type'] == 'js')
				echo '<script>' . $c['text'] . '</script>';
			if($c['type'] == 'js_file')
				echo '<script src="' . $web . '/js/' . $c['text'] . '"></script>';
		}
	}
	public function __construct($cn, $view)
	{
		$this->controller = $cn;
		$cn->view = $this;
		$this->file = $view;
		$this->path = DC::$app->root . DC::$app->path . '/view/' . $cn->path;
		for($i = 0; $i < 3; ++$i)
			$this->adds[$i] = [];
	}
	public function head()
	{
		if(isset(DC::$app->config['js']))
			foreach(DC::$app->config['js'] as $js)
				echo '<script src="' . $js . '"></script>' . "\n";
		if(isset(DC::$app->config['css']))
			foreach(DC::$app->config['css'] as $css)
				echo '<link rel="stylesheet" type="text/css" href="' . $css . '">' . "\n";	
		$this->printAdds(0);
	}
	public function beginBody()
	{
		$this->printAdds(1);
	}
	public function endBody()
	{
		$this->printAdds(2);
		if(count($this->ready))
		{
			echo '<script> $(document).ready(function() {' . "\n\r";
			foreach($this->ready as $c)
				echo $c . "\n\r";
			echo '});</script>';
		}
	}
	public function addJs($code, $pos = View::END)
	{
		$this->adds[$pos][] = ['type' => 'js', 'text' => $code];
	}
	public function addCss($code, $pos = View::END)
	{
		$this->adds[$pos][] = ['type' => 'css', 'text' => $code];
	}
	public function addJsFile($code, $pos = View::END)
	{
		$this->adds[$pos][] = ['type' => 'js_file', 'text' => $code];
	}
	public function addCssFile($code, $pos = View::END)
	{
		$this->adds[$pos][] = ['type' => 'css_file', 'text' => $code];
	}
	public function addReady($code)
	{
		$this->ready[] = $code;
	}
	public function renderPage($vars = [])
	{
		ob_start();
		$this->renderPartial($vars);
		$content = ob_get_clean();
		$this->path = DC::$app->root . DC::$app->path . '/layout/';
		include $this->path . DC::$app->layout . '.php';
	}
	public function renderPartial($vars = [])
	{
		foreach($vars as $key => $var)
		{
			global $$key;
			$$key = $var;
		}
		include $this->path . $this->file . '.php';
	}
	public function renderVar($vars = [])
	{
		$p = [];
		ob_start();
		$this->renderPartial($vars);
		$p['text'] = ob_get_clean();
		$p['title'] = $this->title;
		$p['script'] = $this->ready;
		ob_start();
		$this->printAdds(0);
		$this->printAdds(1);
		$this->printAdds(2);
		$c = ob_get_clean();
		$p['codes'] = $c;
		return $p;
	}
	public function renderJson($vars = [])
	{
		$p = $this->renderVar($vars);
		header("Content-type: application/json");
		echo json_encode($p);
	}
	public function render($file, $vars = [])
	{
		foreach($vars as $key => $var)
		{
			global $$key;
			$$key = $var;
		}
		include $this->path . $file . '.php';
	}
}