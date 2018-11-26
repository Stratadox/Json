<?php

namespace Stratadox\Json;

use Throwable;

/**
 * Exception to throw when the Json is not valid.
 *
 * This can happen when a string cannot be parsed as json, or when the input
 * data cannot be serialised as json string.
 *
 * @author Stratadox
 */
interface InvalidJson extends Throwable
{
}
