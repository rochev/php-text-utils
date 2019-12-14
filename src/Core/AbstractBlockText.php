<?php

namespace Rochev\TextUtils\Core;

use Rochev\TextUtils\Enums\Align;
use Rochev\TextUtils\Enums\Chars;

/**
 * Class BlockText
 */
abstract class AbstractBlockText implements IBlockText
{
    /**
     * @inheritDoc
     */
    public static function build(string $text, int $align = Align::ALIGN_CENTER): string
    {
        $a = new static($text, $align);

        return $a->localBuild();
    }

    /**
     * @var string[]
     */
    protected $lines;

    /**
     * @var int
     */
    protected $align;

    /**
     * @var int
     */
    protected $max_length = 0;

    /**
     * BlockText constructor.
     *
     * @param string $text
     * @param int $align Text alignment (use IBlockText align constants)
     */
    protected function __construct(string $text, int $align)
    {
        $this->lines = explode(PHP_EOL, $text);
        $this->align = $align;
    }

    /**
     * @return string
     */
    private function localBuild(): string
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

        return str_repeat(Chars::BORDER_CHAR, $length);
    }

    /**
     * @return string
     */
    private function spacedLine(): string
    {
        $space_length = $this->getHorizontalGapWidth()
            + $this->max_length
            + $this->getHorizontalGapWidth();

        return str_repeat(Chars::BORDER_CHAR, $this->getHorizontalBorderWidth())
            . str_repeat(Chars::SPACE_CHAR, $space_length)
            . str_repeat(Chars::BORDER_CHAR, $this->getHorizontalBorderWidth());
    }

    /**
     * @param string $line
     *
     * @return string
     */
    private function textLine(string $line): string
    {
        return str_repeat(Chars::BORDER_CHAR, $this->getHorizontalBorderWidth())
            . str_repeat(Chars::SPACE_CHAR, $this->getHorizontalGapWidth())
            . str_pad($line, $this->max_length, Chars::SPACE_CHAR, $this->align)
            . str_repeat(Chars::SPACE_CHAR, $this->getHorizontalGapWidth())
            . str_repeat(Chars::BORDER_CHAR, $this->getHorizontalBorderWidth());
    }

    /**
     * @return int
     */
    protected abstract function getVerticalBorderWidth(): int;

    /**
     * @return int
     */
    protected abstract function getHorizontalBorderWidth(): int;

    /**
     * @return int
     */
    protected abstract function getVerticalGapWidth(): int;

    /**
     * @return int
     */
    protected abstract function getHorizontalGapWidth(): int;
}
