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
 * Class VatColombia
 * @package Welhott\Vatlidator\Provider
 */
class VatColombia extends VatProvider
{
    /**
     * The ISO 3166-1 alpha-2 code that represents this country
     * @var string
     */
    private $country = 'CO';

    /**
     * The abbreviation of the VAT number according the the country's language.
     * @var string
     */
    private $abbreviation = 'NIT';

    /**
     * Each digit will be multiplied by a digit in this array in the equivalent position.
     * @var array
     */
    private $multipliers = [71, 67, 59, 53, 47, 43, 41, 37, 29, 23, 19, 17, 13, 7, 3];

    /**
     * I am having trouble finding sources about the length of the NIT number. The multiplication table goes up to 15
     * characters (excluding the check digit) and examples of read numbers that I was able to research were always
     * around 10 numbers.
     *
     * @return bool True if the number is valid, false if it's not.
     *
     * @see https://github.com/ghostride/NIT/blob/master/Calcular_NIT_DIAN/CalculoNit.vb
     * @see http://www.colconectada.com/digito-de-verificacion-dian/
     */
    public function validate() : bool
    {
        $calculatedCheckDigit = 0;

        if(mb_strlen($this->number) < 10 || mb_strlen($this->number) > 16) {
            return false;
        }

        if(!is_numeric($this->number)) {
            return false;
        }

        $paddedNumber = str_pad($this->number, 16, 0, STR_PAD_LEFT);

        for($i = 0; $i < 15; $i++) {
            $calculatedCheckDigit += $paddedNumber[$i] * $this->multipliers[$i];
        }

        $calculatedCheckDigit = $calculatedCheckDigit % 11;

        if($calculatedCheckDigit > 1) {
            $calculatedCheckDigit = 11 - $calculatedCheckDigit;
        }

        return $this->getCheckDigit() === $calculatedCheckDigit;
    }

    /**
     * Obtain the country code that represents this country.
     * @return string An ISO 3166-1 alpha-2 code that represents this country.
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getAbbreviation() : string
    {
        return $this->abbreviation;
    }
}
