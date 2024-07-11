<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Common\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    public const SERVER_ERROR = 500;

    /**
     * @Message("System parameter error")
     */
    const SYSTEM_INVALID = 700;

    /**
     * @Message("Not found")
     */
    const SERVER_NOT_FOUND = 404;

    /**
     * @Message("Request parameter error")
     */
    const INVALID_REQUEST = 400;
}
