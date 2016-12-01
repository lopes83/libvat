<?php
/*
 * The MIT License (MIT)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Welhott\Vatlidator\Provider;

use Welhott\Vatlidator\VatProvider;

/**
 * Class VatPortugal
 * @package Welhott\Vatlidator\Provider
 */
class VatPortugal extends VatProvider
{
    /**
     * @var string
     */
    private $country = 'PT';

    /**
     * @var array
     */
    private $digits = [1, 2, 5, 6, 7, 8, 9];

    /**
     * Portugal constructor.
     * @param string $number
     */
    public function __construct(string $number)
    {
        parent::__construct($number);
    }

    /**
     * TODO Explain the algorithm
     */
    public function validate() : bool
    {
        if (!is_numeric($this->number) || strlen($this->number) !== 9) {
            return false;
        }

        if(!in_array($this->number[0], $this->digits)) {
            return false;
        }

        $checkDigit = 0;

        for($i = 0, $j = 9; $i < 8; $i++, $j--) {
            $checkDigit += $this->number[$i] * $j;
        }

        $checkDigit = 11 - ($checkDigit % 11);
        $checkDigit = ($checkDigit >= 10) ? 0 : $checkDigit;

        if($checkDigit == $this->number[8]) {
            return true;
        }

        return false;

    }

    /**
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }
}