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
	public $code = ['', ''];
	private function printAdds($n)
	{
		$t = '?' . DC::$app->version;
		foreach($this->adds[$n] as $c)
		{
			if($c['type'] == 'css')
				echo '<style type="text/css">' . $c['text'] . '</style>';
			if($c['type'] == 'css_file')
				echo '<link rel="stylesheet" type="text/css" href="'. '/css/' . $c['text'] . $t . '">';
			if($c['type'] == 'js')
				echo '<script>' . $c['text'] . '</script>';
			if($c['type'] == 'js_file')
				echo '<script src="' . '/js/' . $c['text'] . $t . '"></script>';
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
		$js = DC::$app->config->GetJS(View::HEAD);
		$css = DC::$app->config->GetCSS();
		foreach($js as $f)
			echo '<script src="' . $f . '"></script>' . "\n";
		foreach($css as $f)
			echo '<link rel="stylesheet" type="text/css" href="' . $f . '">' . "\n";	
		$this->printAdds(0);
	}
	public function beginBody()
	{
		$this->printAdds(1);
		echo $this->code[0];
	}
	public function endBody()
	{
		echo $this->code[1];
		$this->printAdds(2);
		$js = DC::$app->config->GetJS(View::END);
		foreach($js as $f)
			echo '<script src="' . $f . '"></script>' . "\n";
		/*if(count($this->ready))
		{
			echo '<script> $(document).ready(function() {' . "\n\r";
			foreach($this->ready as $c)
				echo $c . "\n\r";
			echo '});</script>';
		}*/
	}
	public function addCode($code, $isEnd = 1)
	{
		$this->code[$isEnd] = $code;
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
		$path = $this->path;
		$fname = $this->path . $file . '.php';
		$this->path = dirname(realpath($fname)) . '/';
		include $fname;
		$this->path = $path;
	}
	public function renderBuffer($file, $vars = [])
	{
		ob_start();
		$this->render($file, $vars);
		return ob_get_clean();
	}
}