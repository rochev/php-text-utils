<?php

namespace Rochev\TextUtils\BlockText;

use Rochev\TextUtils\Core\AbstractBlockText;

/**
 * Class TextNormal
 */
class TextNormal extends AbstractBlockText
{
    /**
     * @inheritDoc
     */
    protected function getVerticalBorderWidth(): int
    {
        return 1;
    }

    /**
     * @inheritDoc
     */
    protected function getHorizontalBorderWidth(): int
    {
        return 2;
    }

    /**
     * @inheritDoc
     */
    protected function getVerticalGapWidth(): int
    {
        return 0;
    }

    /**
     * @inheritDoc
     */
    protected function getHorizontalGapWidth(): int
    {
        return 3;
    }
}
