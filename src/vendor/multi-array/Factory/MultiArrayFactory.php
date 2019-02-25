<?php
/**
 * File MultiArrayFactory.php
 */

namespace NLP\Tebru\Factory;

use NLP\Tebru\MultiArray;

/**
 * Class MultiArrayFactory
 *
 * @author Nate Brunette <n@tebru.net>
 */
class MultiArrayFactory
{
    public function make($jsonOrArray, $delimiter = '.')
    {
        return new MultiArray($jsonOrArray, $delimiter);
    }
}
