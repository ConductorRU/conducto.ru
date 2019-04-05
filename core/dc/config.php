<?php
namespace Core\DC;
class Config
{
  public $props = [];
  public $local = [];
  public static function Create($pathGlobal = '', $pathLocal = '')
	{
    $res = new Config();
    $res->Load($pathGlobal, false);
    $res->Load($pathLocal, true);
    return $res;
  }
  public function Load($path = '', $isLocal = false)
	{
    $props = [];
    include ($path);
		foreach($config as $key => $val)
		{
			$props[$key] = [];
			if(is_array($val))
			{
				foreach($val as $k => $v)
				{
          $m = $v;
					if($key == 'js' || $key == 'css')
					{
						$p = isset($config['web']) ? $config['web'] : '';
						if($p != '')
              $p .= '/';
            if(is_array($v))
              $m['/' . $p . $k] = $v;
            else
             $m = '/' . $p . $v;
					}
					if(is_integer($k))
            $props[$key][] = $m;
					else
            $props[$key][$k] = $m;
				}
			}
			else
        $props[$key] = $val;
    }
    if($isLocal)
      $this->local = $props;
    else
      $this->props = $props;
  }
  public function GetCSS()
	{
    $t = '?' . DC::$app->version;
    $res = [];
    $ar = [];
    if(isset($this->props['css']))
      $ar = $this->props['css'];
    if(isset($this->local['css']))
      $ar = array_merge($ar, $this->local['css']);
    foreach($ar as $css)
      $res[] = $css . $t;
    return $res;
  }
  public function GetJS($view = null)
	{
    $t = '?' . DC::$app->version;
    $res = [];
    $ar = [];
    if(isset($this->props['js']))
      $ar = $this->props['js'];
    if(isset($this->local['js']))
      $ar = array_merge($ar, $this->local['js']);
    foreach($ar as $k => $js)
      if(is_numeric($k) && ($view == null || $view == View::HEAD))
        $res[] = $js . $t;
      else if(isset($js['pos']) && $js['pos'] == $view)
        $res[] = $k . $t;
    return $res;
  }
  public function Get($name)
	{
    if(isset($this->local[$name]))
      return $this->local[$name];
		if(isset($this->props[$name]))
      return $this->props[$name];
		return '';
	}
}