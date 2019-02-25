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

require_once dirname(dirname(__FILE__))."/vendor/zhconverter/Zhconverter.php";
use Seta0909\Zhconverter;

$content = fopen(dirname(dirname(__FILE__))."/dict/dict-ex.txt", "r");
$zh_content = '';

while (($line = fgets($content)) !== false) {

    $zh_line = Zhconverter::translate($line,'TW');
    echo $zh_line;
    $zh_content = $zh_content.$zh_line;

}

file_put_contents(dirname(dirname(__FILE__))."/dict/dict-ex.zh.txt", $zh_content);
?>