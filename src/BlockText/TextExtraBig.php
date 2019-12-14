<?php

namespace Rochev\TextUtils\BlockText;

use Rochev\TextUtils\Core\AbstractBlockText;

/**
 * Class TextExtraBig
 */
class TextExtraBig extends AbstractBlockText
{
    /**
     * @inheritDoc
     */
    protected function getVerticalBorderWidth(): int
    {
        return 3;
    }

    /**
     * @inheritDoc
     */
    protected function getHorizontalBorderWidth(): int
    {
        return 6;
    }

    /**
     * @inheritDoc
     */
    protected function getVerticalGapWidth(): int
    {
        return 3;
    }

    /**
     * @inheritDoc
     */
    protected function getHorizontalGapWidth(): int
    {
        return 12;
    }
}
