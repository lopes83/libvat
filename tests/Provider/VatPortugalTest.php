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
namespace Welhott\Vatlidator\Tests\Provider;

use PHPUnit_Framework_TestCase;
use Welhott\Vatlidator\Provider\VatPortugal;

/**
 * Class HexadecimalToBase64Test
 * @package Welhott\Vatlidator\Provider\Tests
 */
class VatPortugalTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $country = 'PT';

    /**
     * @dataProvider getValidVatNumbers
     */
    public function testValidPortugueseVat($number)
    {
        $validator = new VatPortugal($number);

        $this->assertTrue($validator->validate());
        $this->assertEquals($this->country, $validator->getCountry());
        $this->assertEquals($number, $validator->getNumber());
    }

    /**
     * @dataProvider getInvalidVatNumbers
     */
    public function testInvalidPortugueseVat($number)
    {
        $validator = new VatPortugal($number);

        $this->assertFalse($validator->validate());
        $this->assertEquals($this->country, $validator->getCountry());
        $this->assertEquals($number, $validator->getNumber());
    }

    /**
     * @return array
     */
    public function getValidVatNumbers()
    {
        return [
            [123456789],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidVatNumbers()
    {
        return [
            [919191919],
        ];
    }
}
