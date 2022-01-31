<?php

namespace Dodocanfly\SolidEdgeBom\Exceptions;

class MappedHeaderNotFoundException extends \Exception
{
    public function __construct($header)
    {
        $message = 'Mapped header "' . $header . '" not found in RTF content - check RTF/headers map.';
        parent::__construct($message);
    }
}
