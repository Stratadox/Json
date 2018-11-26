<?php

namespace Stratadox\Json;

use Throwable;

/**
 * Exception to throw when the requested offset is not available.
 *
 * This happens when requesting data from a location that does not exist.
 *
 * @author Stratadox
 */
interface InvalidOffset extends Throwable
{
}
