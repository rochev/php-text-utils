<?php

namespace Rochev\TextUtils;

/**
 * Class BlockText
 */
class BlockText implements IBlockText
{
    /**
     * @inheritDoc
     */
    public static function build(string $text, int $align = self::ALIGN_CENTER): string
    {
        $block = new self($text, $align, false);

        return $block->process();
    }

    /**
     * @inheritDoc
     */
    public static function buildBig(string $text, int $align = self::ALIGN_CENTER): string
    {
        $block = new self($text, $align, true);

        return $block->process();
    }

    /**
     * @var string[]
     */
    private $lines;

    /**
     * @var int
     */
    private $align;

    /**
     * @var bool
     */
    private $is_big;

    /**
     * @var int
     */
    private $max_length = 0;

    /**
     * BlockText constructor.
     *
     * @param string $text
     * @param int $align Text alignment (use IBlockText align constants)
     * @param bool $is_big
     */
    private function __construct(string $text, int $align, bool $is_big)
    {
        $this->lines = explode(PHP_EOL, $text);
        $this->align = $align;
        $this->is_big = $is_big;
    }

    /**
     * @return string
     */
    private function process(): string
    {
        foreach ($this->lines as $line)
            $this->max_length = max($this->max_length, mb_strlen($line));

        $this->lines = array_map(function ($line) {
            return $this->textLine($line);
        }, $this->lines);

        $filled_line = $this->filledLine();
        $spaced_line = $this->spacedLine();

        $new_lines = [];
        for ($i = 0; $i < $this->getVerticalBorderWidth(); $i++)
            $new_lines[] = $filled_line;
        for ($i = 0; $i < $this->getVerticalGapWidth(); $i++)
            $new_lines[] = $spaced_line;
        foreach ($this->lines as $line)
            $new_lines[] = $line;
        for ($i = 0; $i < $this->getVerticalGapWidth(); $i++)
            $new_lines[] = $spaced_line;
        for ($i = 0; $i < $this->getVerticalBorderWidth(); $i++)
            $new_lines[] = $filled_line;

        return implode(PHP_EOL, $new_lines);
    }

    /**
     * @return string
     */
    private function filledLine(): string
    {
        $length = $this->getHorizontalBorderWidth()
            + $this->getHorizontalGapWidth()
            + $this->max_length
            + $this->getHorizontalGapWidth()
            + $this->getHorizontalBorderWidth();

        return str_repeat(self::BORDER_CHAR, $length);
    }

    /**
     * @return string
     */
    private function spacedLine(): string
    {
        $space_length = $this->getHorizontalGapWidth()
            + $this->max_length
            + $this->getHorizontalGapWidth();

        return str_repeat(self::BORDER_CHAR, $this->getHorizontalBorderWidth())
            . str_repeat(self::SPACE_CHAR, $space_length)
            . str_repeat(self::BORDER_CHAR, $this->getHorizontalBorderWidth());
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function textLine(string $line): string
    {
        return str_repeat(self::BORDER_CHAR, $this->getHorizontalBorderWidth())
            . str_repeat(self::SPACE_CHAR, $this->getHorizontalGapWidth())
            . str_pad($line, $this->max_length, self::SPACE_CHAR, $this->align)
            . str_repeat(self::SPACE_CHAR, $this->getHorizontalGapWidth())
            . str_repeat(self::BORDER_CHAR, $this->getHorizontalBorderWidth());
    }

    /**
     * @return int
     */
    private function getVerticalGapWidth(): int
    {
        return $this->is_big ? 1 : 0;
    }

    /**
     * @return int
     */
    private function getVerticalBorderWidth(): int
    {
        return $this->is_big ? 2 : 1;
    }

    /**
     * @return int
     */
    private function getHorizontalGapWidth(): int
    {
        return $this->is_big ? 6 : 3;
    }

    /**
     * @return int
     */
    private function getHorizontalBorderWidth(): int
    {
        return $this->is_big ? 4 : 2;
    }
}
