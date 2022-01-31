<?php

namespace Dodocanfly\SolidEdgeBom;

class Str
{
    private const DEFAULT_INPUT_CHARSET = 'CP1250';
    private const DEFAULT_OUTPUT_CHARSET = 'UTF-8';


    /**
     * Convert string to desired character set
     * @param string $string input string
     * @param string $inputCharset (default CP1250)
     * @param string $outputCharset (default UTF-8)
     * @return string
     */
    public static function convert(
        string $string,
        string $inputCharset = self::DEFAULT_INPUT_CHARSET,
        string $outputCharset = self::DEFAULT_OUTPUT_CHARSET
    ): string {
        return iconv($inputCharset, $outputCharset, $string);
    }


    public static function cp1250ToUtf8(string $string): string
    {
        return self::convert($string, 'CP1250', 'UTF-8');
    }
}