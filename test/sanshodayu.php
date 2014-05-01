<?php
spl_autoload_register(function($class) {
    $parts = explode('\\', $class);

    # Support for non-namespaced classes.
    $parts[] = str_replace('_', DIRECTORY_SEPARATOR, array_pop($parts));

    //$path = implode(DIRECTORY_SEPARATOR, $parts);
    $path = '../lib/' . implode(DIRECTORY_SEPARATOR, $parts);

    $file = stream_resolve_include_path($path.'.php');
    if($file !== false) {
        require $file;
    }
});

use Igo\Tagger;

$encode = "UTF-8";
ini_set("memory_limit", "1073741824"); //1024^3

$text = file_get_contents("./yoshinoya.txt");

$igo = new Tagger(array('dict_dir'=>'../jdic', 'reduce_mode'  => false));

$bench = new benchmark();
$bench->start();
$result = $igo->parse($text);
$bench->end();
print_r("score: " . $bench->score);
print_r("\n");
$fp = fopen("./php-igo.result", "w");
foreach ($result as $res) {
	$buf = "";
	$buf .= $res->surface;
	$buf .= ",";
	$buf .= $res->feature;
	$buf .= ",";
	$buf .= $res->start;
	$buf .= "\r\n";
	fwrite($fp, $buf);
}
fclose($fp);
echo memory_get_peak_usage(), "\n";

class benchmark {

	var $start;
	var $end;
	var $score;

	function start() {
		$this->start = $this->_now();
	}
	function end() {
		$this->end = $this->_now();
		$this->score = round($this->end - $this->start, 5);
	}
	function _now() {
		list($msec, $sec) = explode(' ', microtime());
		return ((float) $msec + (float) $sec);
	}
}
?>
