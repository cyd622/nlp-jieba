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
require_once dirname(dirname(__FILE__))."/class/Posseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
use NLP\Jieba\Posseg;
Jieba::init(array('mode'=>'test','dict'=>'big'));
Finalseg::init();
Posseg::init();

$seg_list = Posseg::cut("这是一个伸手不见五指的黑夜。我叫孙悟空，我爱北京，我爱Python和C++。");
var_dump($seg_list);

$seg_list = Posseg::posTagReadable($seg_list);
var_dump($seg_list);

$seg_list = Posseg::cut("這是一個伸手不見五指的黑夜。我叫孫悟空，我愛北京，我愛Python和C++");
var_dump($seg_list);

$seg_list = Posseg::posTagReadable($seg_list);
var_dump($seg_list);

$seg_list = Posseg::cut("林志傑來到了網易杭研大廈", ['HMM' => false]);
var_dump($seg_list);

$seg_list = Posseg::posTagReadable($seg_list);
var_dump($seg_list);
?>