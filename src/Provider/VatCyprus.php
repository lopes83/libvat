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
 * Class VatCyprus
 * @package Welhott\Vatlidator\Provider
 */
class VatCyprus extends VatProvider
{
    /**
     * The ISO 3166-1 alpha-2 code that represents this country
     * @var string
     */
    private $country = 'CY';

    /**
     * The abbreviation of the VAT number according the the country's language.
     * @var string
     */
    private $abbreviation = 'ΦΠΑ';

    /**
     * @var array
     */
    private $translation = [
        0 => 1,
        1 => 0,
        2 => 5,
        3 => 7,
        4 => 9,
    ];

    /**
     * @var string
     */
    private $pattern = '![12]|[0-59]\d{7}[A-Z]';

    /**x
     * @return bool True if the number is valid, false if it's not.
     */
    public function validate() : bool
    {
        if(!$this->matchesPattern($this->pattern)) {
            return false;
        }

        $checksum = 0;

        for($i = 0; $i < 8; $i++) {
            if(($i % 2) !== 0) {
                $checksum += $this->cleanNumber[$i];
                continue;
            }

            if(!array_key_exists($this->cleanNumber[$i], $this->translation)) {
                $checksum += ($this->cleanNumber[$i] * 2) + 3;
                continue;
            }

            $checksum += $this->translation[$this->cleanNumber[$i]];
        }

        $checkchar = chr(($checksum % 26) + 65);
        return $checkchar === $this->getCheckChar();
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
