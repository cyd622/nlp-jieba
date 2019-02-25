#!/usr/bin/php
<?php
/**
 * @package: nlp-jieba
 * @author: Ciel (luffywang622@gmail.com)
 * @link:     https://github.com/cyd622/nlp-jieba
 * @created: 2018/12/29 0029 15:10
 * Created by PhpStorm.
 */

ini_set('memory_limit', '1024M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
require_once dirname(dirname(__FILE__))."/class/JiebaAnalyse.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
use NLP\Jieba\JiebaAnalyse;
Jieba::init(array('mode'=>'test','dict'=>'big'));
Finalseg::init();
JiebaAnalyse::init(array('dict'=>'big'));

$top_k = 10;
$content = file_get_contents(dirname(dirname(__FILE__))."/dict/lyric.txt", "r");

$tags = JiebaAnalyse::extractTags($content, $top_k);
var_dump($tags);

JiebaAnalyse::setStopWords(dirname(dirname(__FILE__)).'/dict/stop_words.txt');

$tags = JiebaAnalyse::extractTags($content, $top_k);
var_dump($tags);
?>