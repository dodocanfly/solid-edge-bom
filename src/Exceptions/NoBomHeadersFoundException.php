<?php

namespace Dodocanfly\SolidEdgeBom\Exceptions;

class NoBomHeadersFoundException extends \Exception
{
    protected $message = 'No bill of materials headers found - check RTF content';
}
