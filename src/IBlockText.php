<?php

namespace Rochev\TextUtils;

/**
 * Interface IBlockText
 */
interface IBlockText
{
    /** @var int */
    public const  ALIGN_LEFT = STR_PAD_RIGHT;
    /** @var int */
    public const ALIGN_CENTER = STR_PAD_BOTH;
    /** @var int */
    public const ALIGN_RIGHT = STR_PAD_LEFT;

    /** @var string */
    public const BORDER_CHAR = '#';
    /** @var string */
    public const SPACE_CHAR = ' ';

    /**
     * Build normal text block
     *
     * @param string $text Multiline text
     * @param int $align Text alignment (use IBlockText align constants)
     *
     * @return string
     */
    public static function build(string $text, int $align): string;

    /**
     * Build big text block
     *
     * @param string $text Multiline text
     * @param int $align Text alignment (use IBlockText align constants)
     *
     * @return string
     */
    public static function buildBig(string $text, int $align): string;
}
