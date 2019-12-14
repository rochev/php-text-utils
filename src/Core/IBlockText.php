<?php

namespace Rochev\TextUtils\Core;

/**
 * Interface IBlockText
 */
interface IBlockText
{
    /**
     * Build normal text block
     *
     * @param string $text Multiline text
     * @param int $align Text alignment (use IBlockText align constants)
     *
     * @return string
     */
    public static function build(string $text, int $align): string;
}
