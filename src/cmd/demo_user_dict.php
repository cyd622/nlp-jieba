#!/usr/bin/php
<?php
/**
 * @package: nlp-jieba
 * @author: Ciel (luffywang622@gmail.com)
 * @link:     https://github.com/cyd622/nlp-jieba
 * @created: 2018/12/29 0029 15:10
 * Created by PhpStorm.
 */

ini_set('memory_limit', '600M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
Jieba::init(array('mode'=>'test','dict'=>'samll'));
Finalseg::init();

$seg_list = Jieba::cut("李小福是创新办主任也是云计算方面的专家");
var_dump($seg_list);

Jieba::loadUserDict(dirname(dirname(__FILE__)).'/dict/user_dict.txt');

$seg_list = Jieba::cut("李小福是创新办主任也是云计算方面的专家");
var_dump($seg_list);

$seg_list = Jieba::cut("easy_install is great");
var_dump($seg_list);

$seg_list = Jieba::cut("python 的正则表达式是好用的");
var_dump($seg_list);
?>