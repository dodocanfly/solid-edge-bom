<?php

namespace Dodocanfly\SolidEdgeBom\Exceptions;

class NoBomItemsFoundException extends \Exception
{
    protected $message = 'No bill of materials items found - check RTF content';
}
