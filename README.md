[NLP-Jieba](http://www.fukuball.com/jieba-php/)
=========
[![Build Status](https://travis-ci.org/fukuball/jieba-php.svg?branch=master)](https://travis-ci.org/fukuball/jieba-php)
[![codecov.io](http://codecov.io/github/fukuball/jieba-php/coverage.svg?branch=master)](http://codecov.io/github/fukuball/jieba-php?branch=master)
[![Latest Stable Version](https://poser.pugx.org/fukuball/jieba-php/v/stable.png)](https://packagist.org/packages/fukuball/jieba-php)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/9360ebe8fc2d47d8a64f49f57d2f016f)](https://www.codacy.com/app/fukuball/jieba-php)
[![Made with Love](https://img.shields.io/badge/made%20with-%e2%9d%a4-ff69b4.svg)](http://www.fukuball.com)

"结巴"中文分词：做最好的 PHP 中文分词、中文断词组件，目前翻译版本为 jieba-0.26 版本，未来再慢慢往上升级，效能也需要再改善，请有兴趣的开发者一起加入开发！若想使用 Python 版本请前往 [fxsjy/jieba](https://github.com/fxsjy/jieba)

现在已经可以支援繁体中文！只要将字典切换为 big 模式即可！

"Jieba" (Chinese for "to stutter") Chinese text segmentation: built to be the best PHP Chinese word segmentation module.

_Scroll down for English documentation._

线上展示
========
* 网站网址：[http://jieba-php.fukuball.com](http://jieba-php.fukuball.com)
* 网站原始码：[https://github.com/cyd622/nlp-jieba](https://github.com/cyd622/nlp-jieba)

Feature
========
* 支持三种分词模式：
 * 默认精确模式，试图将句子最精确地切开，适合文本分析；
 * 全模式，把句子中所有的可以成词的词语都扫描出来，但是不能解决歧义。（需要充足的字典）
 * 搜寻引擎模式，在精确模式的基础上，对长词再次切分，提高召回率，适合用于搜寻引擎分词。

* 支持繁体断词
* 支持自定义词典

Usage
========
* 自动安装：使用 composer 安装后，透过 autoload 引用

代码示例

```php
composer require cyd622/nlp-jieba:dev-master
```

代码示例

```php
require_once "/path/to/your/vendor/autoload.php";
```

* 手动安装：将 nlp-jieba 放置适当目录后，透过 require_once 引用

代码示例

```php
require_once "/path/to/your/vendor/multi-array/MultiArray.php";
require_once "/path/to/your/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once "/path/to/your/class/Jieba.php";
require_once "/path/to/your/class/Finalseg.php";
```

Algorithm
========
* 基于 Trie 树结构实现高效的词图扫描，生成句子中汉字所有可能成词情况所构成的有向无环图（DAG)
* 採用了动态规划查找最大概率路径, 找出基于词频的最大切分组合
* 对于未登录词，採用了基于汉字成词能力的 HMM 模型，使用了 Viterbi 算法
* BEMS 的解释 [https://github.com/fxsjy/jieba/issues/7](https://github.com/fxsjy/jieba/issues/7)

Interface
========
* 组件只提供 jieba.cut 方法用于分词
* cut 方法接受两个输入参数: 1) 第一个参数为需要分词的字符串 2）cut_all 参数用来控制分词模式
* 待分词的字符串可以是 utf-8 字符串
* jieba.cut 返回的结构是一个可迭代的 array

功能 1)：分词
============
* `cut` 方法接受想个输入参数： 1) 第一个参数为需要分词的字符串 2）cut_all 参数用来控制分词模式
* `cutForSearch` 方法接受一个参数：需要分词的字符串，该方法适合用于搜索引擎构建倒排索引的分词，粒度比较细
* 注意：待分词的字符串是 utf-8 字符串
* `cut` 以及 `cutForSearch` 返回的结构是一个可迭代的 array

代码示例 (Tutorial)

```php
ini_set('memory_limit', '1024M');

require_once "/path/to/your/vendor/multi-array/MultiArray.php";
require_once "/path/to/your/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once "/path/to/your/class/Jieba.php";
require_once "/path/to/your/class/Finalseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
Jieba::init();
Finalseg::init();

$seg_list = Jieba::cut("怜香惜玉也得要看对象啊！");
var_dump($seg_list);

$seg_list = Jieba::cut("我来到北京清华大学", true);
var_dump($seg_list); #全模式

$seg_list = Jieba::cut("我来到北京清华大学", false);
var_dump($seg_list); #默认精确模式

$seg_list = Jieba::cut("他来到了网易杭研大厦");
var_dump($seg_list);

$seg_list = Jieba::cutForSearch("小明硕士毕业于中国科学院计算所，后在日本京都大学深造"); #搜索引擎模式
var_dump($seg_list);
```

Output:

```php
array(7) {
  [0]=>
  string(12) "怜香惜玉"
  [1]=>
  string(3) "也"
  [2]=>
  string(3) "得"
  [3]=>
  string(3) "要"
  [4]=>
  string(3) "看"
  [5]=>
  string(6) "对象"
  [6]=>
  string(3) "啊"
}

Full Mode:
array(15) {
  [0]=>
  string(3) "我"
  [1]=>
  string(3) "来"
  [2]=>
  string(6) "来到"
  [3]=>
  string(3) "到"
  [4]=>
  string(3) "北"
  [5]=>
  string(6) "北京"
  [6]=>
  string(3) "京"
  [7]=>
  string(3) "清"
  [8]=>
  string(6) "清华"
  [9]=>
  string(12) "清华大学"
  [10]=>
  string(3) "华"
  [11]=>
  string(6) "华大"
  [12]=>
  string(3) "大"
  [13]=>
  string(6) "大学"
  [14]=>
  string(3) "学"
}

Default Mode:
array(4) {
  [0]=>
  string(3) "我"
  [1]=>
  string(6) "来到"
  [2]=>
  string(6) "北京"
  [3]=>
  string(12) "清华大学"
}
array(6) {
  [0]=>
  string(3) "他"
  [1]=>
  string(6) "来到"
  [2]=>
  string(3) "了"
  [3]=>
  string(6) "网易"
  [4]=>
  string(6) "杭研"
  [5]=>
  string(6) "大厦"
}
(此处，“杭研“并没有在词典中，但是也被 Viterbi 算法识别出来了)

Search Engine Mode:
array(18) {
  [0]=>
  string(6) "小明"
  [1]=>
  string(6) "硕士"
  [2]=>
  string(6) "毕业"
  [3]=>
  string(3) "于"
  [4]=>
  string(6) "中国"
  [5]=>
  string(6) "科学"
  [6]=>
  string(6) "学院"
  [7]=>
  string(9) "科学院"
  [8]=>
  string(15) "中国科学院"
  [9]=>
  string(6) "计算"
  [10]=>
  string(9) "计算所"
  [11]=>
  string(3) "后"
  [12]=>
  string(3) "在"
  [13]=>
  string(6) "日本"
  [14]=>
  string(6) "京都"
  [15]=>
  string(6) "大学"
  [16]=>
  string(18) "日本京都大学"
  [17]=>
  string(6) "深造"
}
```

功能 2)：添加自定义词典
====================

* 开发者可以指定自己自定义的词典，以便包含 jieba 词库裡没有的词。虽然 jieba 有新词识别能力，但是自行添加新词可以保证更高的正确率
* 用法： Jieba::loadUserDict(file_name) # file_name 为自定义词典的绝对路径
* 词典格式和 dict.txt 一样，一个词佔一行；每一行分为三部分，一部分为词语，一部分为词频，一部分为词性，用空格隔开
* 范例：

  云计算 5 n
  李小福 2 n
  创新办 3 n

  之前： 李小福 / 是 / 创新 / 办 / 主任 / 也 / 是 / 云 / 计算 / 方面 / 的 / 专家 /
  加载自定义词库后：　李小福 / 是 / 创新办 / 主任 / 也 / 是 / 云计算 / 方面 / 的 / 专家 /

说明："通过用户自定义词典来增强歧义纠错能力" --- https://github.com/fxsjy/jieba/issues/14

* 自定义词典：https://github.com/cyd622/jieba-php/blob/master/src/dict/user_dict.txt

功能 3)：关键词提取
==============
* JiebaAnalyse::extractTags($content, $top_k)
* content 为待提取的文本
* top_k 为返回几个 TF/IDF 权重最大的关键词，默认值为 20
* 可使用 setStopWords 增加自定义 stop words

代码示例 (关键词提取)

```php
ini_set('memory_limit', '600M');

require_once "/path/to/your/vendor/multi-array/MultiArray.php";
require_once "/path/to/your/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once "/path/to/your/class/Jieba.php";
require_once "/path/to/your/class/Finalseg.php";
require_once "/path/to/your/class/JiebaAnalyse.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
use NLP\Jieba\JiebaAnalyse;
Jieba::init(array('mode'=>'test','dict'=>'small'));
Finalseg::init();
JiebaAnalyse::init();

$top_k = 10;
$content = file_get_contents("/path/to/your/dict/lyric.txt", "r");

$tags = JiebaAnalyse::extractTags($content, $top_k);

var_dump($tags);

JiebaAnalyse::setStopWords('/path/to/your/dict/stop_words.txt');

$tags = JiebaAnalyse::extractTags($content, $top_k);

var_dump($tags);
```

Output:
```php
array(10) {
  '没有' =>
  double(1.0592831964595)
  '所谓' =>
  double(0.90795702553671)
  '是否' =>
  double(0.66385043195443)
  '一般' =>
  double(0.54607060161899)
  '虽然' =>
  double(0.30265234184557)
  '来说' =>
  double(0.30265234184557)
  '肌迫' =>
  double(0.30265234184557)
  '退缩' =>
  double(0.30265234184557)
  '矫作' =>
  double(0.30265234184557)
  '怯懦' =>
  double(0.24364586159392)
}
array(10) {
  '所谓' =>
  double(1.1569129841516)
  '一般' =>
  double(0.69579963754677)
  '矫作' =>
  double(0.38563766138387)
  '来说' =>
  double(0.38563766138387)
  '退缩' =>
  double(0.38563766138387)
  '虽然' =>
  double(0.38563766138387)
  '肌迫' =>
  double(0.38563766138387)
  '怯懦' =>
  double(0.31045198493419)
  '随便说说' =>
  double(0.19281883069194)
  '一场' =>
  double(0.19281883069194)
}
```

功能 4)：词性分词
==============
* 词性说明：[https://gist.github.com/luw2007/6016931](https://gist.github.com/luw2007/6016931)

代码示例 (Tutorial)

```php
ini_set('memory_limit', '600M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
require_once dirname(dirname(__FILE__))."/class/Posseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
use NLP\Jieba\Posseg;
Jieba::init();
Finalseg::init();
Posseg::init();

$seg_list = Posseg::cut("这是一个伸手不见五指的黑夜。我叫孙悟空，我爱北京，我爱Python和C++。");
var_dump($seg_list);
```

Output:
```php
array(21) {
  [0]=>
  array(2) {
    ["word"]=>
    string(3) "这"
    ["tag"]=>
    string(1) "r"
  }
  [1]=>
  array(2) {
    ["word"]=>
    string(3) "是"
    ["tag"]=>
    string(1) "v"
  }
  [2]=>
  array(2) {
    ["word"]=>
    string(6) "一个"
    ["tag"]=>
    string(1) "m"
  }
  [3]=>
  array(2) {
    ["word"]=>
    string(18) "伸手不见五指"
    ["tag"]=>
    string(1) "i"
  }
  [4]=>
  array(2) {
    ["word"]=>
    string(3) "的"
    ["tag"]=>
    string(2) "uj"
  }
  [5]=>
  array(2) {
    ["word"]=>
    string(6) "黑夜"
    ["tag"]=>
    string(1) "n"
  }
  [6]=>
  array(2) {
    ["word"]=>
    string(3) "。"
    ["tag"]=>
    string(1) "x"
  }
  [7]=>
  array(2) {
    ["word"]=>
    string(3) "我"
    ["tag"]=>
    string(1) "r"
  }
  [8]=>
  array(2) {
    ["word"]=>
    string(3) "叫"
    ["tag"]=>
    string(1) "v"
  }
  [9]=>
  array(2) {
    ["word"]=>
    string(9) "孙悟空"
    ["tag"]=>
    string(2) "nr"
  }
  [10]=>
  array(2) {
    ["word"]=>
    string(3) "，"
    ["tag"]=>
    string(1) "x"
  }
  [11]=>
  array(2) {
    ["word"]=>
    string(3) "我"
    ["tag"]=>
    string(1) "r"
  }
  [12]=>
  array(2) {
    ["word"]=>
    string(3) "爱"
    ["tag"]=>
    string(1) "v"
  }
  [13]=>
  array(2) {
    ["word"]=>
    string(6) "北京"
    ["tag"]=>
    string(2) "ns"
  }
  [14]=>
  array(2) {
    ["word"]=>
    string(3) "，"
    ["tag"]=>
    string(1) "x"
  }
  [15]=>
  array(2) {
    ["word"]=>
    string(3) "我"
    ["tag"]=>
    string(1) "r"
  }
  [16]=>
  array(2) {
    ["word"]=>
    string(3) "爱"
    ["tag"]=>
    string(1) "v"
  }
  [17]=>
  array(2) {
    ["word"]=>
    string(6) "Python"
    ["tag"]=>
    string(3) "eng"
  }
  [18]=>
  array(2) {
    ["word"]=>
    string(3) "和"
    ["tag"]=>
    string(1) "c"
  }
  [19]=>
  array(2) {
    ["word"]=>
    string(3) "C++"
    ["tag"]=>
    string(3) "eng"
  }
  [20]=>
  array(2) {
    ["word"]=>
    string(3) "。"
    ["tag"]=>
    string(1) "x"
  }
}
```

功能 5)：切换成繁体字典
==============

代码示例 (Tutorial)

```php
ini_set('memory_limit', '1024M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
Jieba::init(array('mode'=>'default','dict'=>'big'));
Finalseg::init();

$seg_list = Jieba::cut("怜香惜玉也得要看对象啊！");
var_dump($seg_list);

$seg_list = Jieba::cut("憐香惜玉也得要看對象啊！");
var_dump($seg_list);
```

Output:

```php
array(7) {
  [0]=>
  string(12) "怜香惜玉"
  [1]=>
  string(3) "也"
  [2]=>
  string(3) "得"
  [3]=>
  string(3) "要"
  [4]=>
  string(3) "看"
  [5]=>
  string(6) "对象"
  [6]=>
  string(3) "啊"
}
array(7) {
  [0]=>
  string(12) "憐香惜玉"
  [1]=>
  string(3) "也"
  [2]=>
  string(3) "得"
  [3]=>
  string(3) "要"
  [4]=>
  string(3) "看"
  [5]=>
  string(6) "對象"
  [6]=>
  string(3) "啊"
}
```


功能 6)：保留日语或者朝鲜语原文不进行过滤
==============

代碼示例 (Tutorial)

```php
ini_set('memory_limit', '1024M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
Jieba::init(array('cjk'=>'all'));
Finalseg::init();

$seg_list = Jieba::cut("한국어 또는 조선말은 제주특별자치도를 제외한 한반도 및 그 부속 도서와 한민족 거주 지역에서 쓰이는 언어로");
var_dump($seg_list);

$seg_list = Jieba::cut("日本語は、主に日本国内や日本人同士の間で使われている言語である。");
var_dump($seg_list);

// 加载日语词库可以对日语进行简单的分词
Jieba::loadUserDict("/path/to/your/japanese/dict.txt");
$seg_list = Jieba::cut("日本語は、主に日本国内や日本人同士の間で使われている言語である。");
var_dump($seg_list);
```

Output:

```php
array(15) {
  [0]=>
  string(9) "한국어"
  [1]=>
  string(6) "또는"
  [2]=>
  string(12) "조선말은"
  [3]=>
  string(24) "제주특별자치도를"
  [4]=>
  string(9) "제외한"
  [5]=>
  string(9) "한반도"
  [6]=>
  string(3) "및"
  [7]=>
  string(3) "그"
  [8]=>
  string(6) "부속"
  [9]=>
  string(9) "도서와"
  [10]=>
  string(9) "한민족"
  [11]=>
  string(6) "거주"
  [12]=>
  string(12) "지역에서"
  [13]=>
  string(9) "쓰이는"
  [14]=>
  string(9) "언어로"
}
array(21) {
  [0]=>
  string(6) "日本"
  [1]=>
  string(3) "語"
  [2]=>
  string(3) "は"
  [3]=>
  string(3) "主"
  [4]=>
  string(3) "に"
  [5]=>
  string(6) "日本"
  [6]=>
  string(6) "国内"
  [7]=>
  string(3) "や"
  [8]=>
  string(6) "日本"
  [9]=>
  string(3) "人"
  [10]=>
  string(6) "同士"
  [11]=>
  string(3) "の"
  [12]=>
  string(3) "間"
  [13]=>
  string(3) "で"
  [14]=>
  string(3) "使"
  [15]=>
  string(3) "わ"
  [16]=>
  string(6) "れて"
  [17]=>
  string(6) "いる"
  [18]=>
  string(6) "言語"
  [19]=>
  string(3) "で"
  [20]=>
  string(6) "ある"
}
array(17) {
  [0]=>
  string(9) "日本語"
  [1]=>
  string(3) "は"
  [2]=>
  string(6) "主に"
  [3]=>
  string(9) "日本国"
  [4]=>
  string(3) "内"
  [5]=>
  string(3) "や"
  [6]=>
  string(9) "日本人"
  [7]=>
  string(6) "同士"
  [8]=>
  string(3) "の"
  [9]=>
  string(3) "間"
  [10]=>
  string(3) "で"
  [11]=>
  string(3) "使"
  [12]=>
  string(3) "わ"
  [13]=>
  string(6) "れて"
  [14]=>
  string(6) "いる"
  [15]=>
  string(6) "言語"
  [16]=>
  string(9) "である"
}
```

功能 7)：返回词语在原文的起止位置
==============

代码示例 (Tutorial)

```php
ini_set('memory_limit', '1024M');

require_once dirname(dirname(__FILE__))."/vendor/multi-array/MultiArray.php";
require_once dirname(dirname(__FILE__))."/vendor/multi-array/Factory/MultiArrayFactory.php";
require_once dirname(dirname(__FILE__))."/class/Jieba.php";
require_once dirname(dirname(__FILE__))."/class/Finalseg.php";
use NLP\Jieba\Jieba;
use NLP\Jieba\Finalseg;
Jieba::init(array('mode'=>'test','dict'=>'big'));
Finalseg::init();

$seg_list = Jieba::tokenize("永和服装饰品有限公司");
var_dump($seg_list);
```

Output:

```php
array(4) {
  [0] =>
  array(3) {
    'word' =>
    string(6) "永和"
    'start' =>
    int(0)
    'end' =>
    int(2)
  }
  [1] =>
  array(3) {
    'word' =>
    string(6) "服装"
    'start' =>
    int(2)
    'end' =>
    int(4)
  }
  [2] =>
  array(3) {
    'word' =>
    string(6) "饰品"
    'start' =>
    int(4)
    'end' =>
    int(6)
  }
  [3] =>
  array(3) {
    'word' =>
    string(12) "有限公司"
    'start' =>
    int(6)
    'end' =>
    int(10)
  }
}
```

其他词典
========
1) 佔用内容较小的词典
https://github.com/cyd622/nlp-jieba/blob/master/src/dict/dict.small.txt

2) 支持繁体断词的词典
https://github.com/cyd622/nlp-jieba/blob/master/src/dict/dict.big.txt

常见问题
========
1) 模型的数据是如何生成的？ https://github.com/fxsjy/jieba/issues/7
2) 这个库的授权是？ https://github.com/fxsjy/jieba/issues/2



詞性說明
==============
```
a 形容词 (取英语形容词 adjective 的第 1 个字母。)
  ad 副形词 (直接作状语的形容词，形容词代码 a 和副词代码 d 并在一起。)
  ag 形容词性语素 (形容词性语素，形容词代码为 a，语素代码 ｇ 前面置以 a。)
  an 名形词 (具有名词功能的形容词，形容词代码 a 和名词代码 n 并在一起。)
b 区别词 (取汉字「别」的声母。)
c 连词 (取英语连词 conjunction 的第 1 个字母。)
d 副词 (取 adverb 的第 2 个字母，因其第 1 个字母已用于形容词。)
  df 副词*
  dg 副语素 (副词性语素，副词代码为 d，语素代码 ｇ 前面置以 d。)
e 叹词 (取英语叹词 exclamation 的第 1 个字母。)
eng 外语
f 方位词 (取汉字「方」的声母。)
g 语素 (绝大多数语素都能作为合成词的「词根」，取汉字「根」的声母。)
h 前接成分 (取英语 head 的第 1 个字母。)
i 成语 (取英语成语 idiom 的第 1 个字母。)
j 简称略语 (取汉字「简」的声母。)
k 后接成分
l 习用语 (习用语尚未成为成语，有点「临时性」，取「临」的声母。)
m 数词 (取英语 numeral 的第 3 个字母，n，u 已有他用。)
  mg 数语素
  mq 数词*
n 名词 (取英语名词 noun 的第 1 个字母。)
  ng 名语素 (名词性语素，名词代码为 n，语素代码 ｇ 前面置以 n。)
  nr 人名 (名词代码n和「人(ren)」的声母并在一起。)
  nrfg 名词*
  nrt 名词*
  ns 地名 (名词代码 n 和处所词代码 s 并在一起。)
  nt 机构团体 (「团」的声母为 t，名词代码 n 和 t 并在一起。)
  nz 其他专名 (「专」的声母的第 1 个字母为 z，名词代码 n 和 z 并在一起。)
o 拟声词 (取英语拟声词 onomatopoeia 的第 1 个字母。)
p 介词 (取英语介词 prepositional 的第 1 个字母。)
q 量词 (取英语 quantity 的第 1 个字母。)
r 代词 (取英语代词 pronoun的 第 2 个字母，因 p 已用于介词。)
  rg 代词语素
  rr 代词*
  rz 代词*
s 处所词 (取英语 space 的第 1 个字母。)
t 时间词 (取英语 time 的第 1 个字母。)
  tg 时语素 (时间词性语素，时间词代码为 t，在语素的代码 g 前面置以 t。)
u 助词 (取英语助词 auxiliary 的第 2 个字母，因 a 已用于形容词。)
  ud 助词*
  ug 助词*
  uj 助词*
  ul 助词*
  uv 助词*
  uz 助词*
v 动词 (取英语动词 verb 的第一个字母。)
  vd 副动词 (直接作状语的动词，动词和副词的代码并在一起。)
  vg 动语素
  vi 动词*
  vn 名动词 (指具有名词功能的动词，动词和名词的代码并在一起。)
  vq 动词*
w 标点符号
x 非语素字 (非语素字只是一个符号，字母 x 通常用于代表未知数、符号。)
y 语气词 (取汉字「语」的声母。)
z 状态词 (取汉字「状」的声母的前一个字母。)
  zg 状态词*
```


License
=========
The MIT License (MIT)

Copyright (c) 2015 fukuball

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
