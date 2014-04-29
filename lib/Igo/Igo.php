<?php

namespace Igo;

defined('IGO_RETURN_AS_ARRAY')  or define('IGO_RETURN_AS_ARRAY', false);
defined('IGO_REDUCE_MODE')      or define('IGO_REDUCE_MODE', true);
defined('IGO_LITTLE_ENDIAN')    or define('IGO_LITTLE_ENDIAN', true);
defined('IGO_MB_DETECT_ORDER')  or define('IGO_MB_DETECT_ORDER', "ASCII,JIS,UTF-8,EUC-JP,SJIS");

class Igo {
	private $tagger;

	public function __construct($dataDir, $outputEncoding = null) {
		$this->tagger = new Tagger($dataDir, $outputEncoding);
	}

	public function wakati($text) {
		return $this->tagger->wakati($text);
	}

	public function parse($text) {
		return $this->tagger->parse($text);
	}
}