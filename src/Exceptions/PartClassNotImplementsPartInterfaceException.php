<?php

namespace Dodocanfly\SolidEdgeBom\Exceptions;

class PartClassNotImplementsPartInterfaceException extends \Exception
{
    public function __construct($className)
    {
        $message = 'Passed class (' . $className . ') not implements PartInterface';
        parent::__construct($message);
    }
}
