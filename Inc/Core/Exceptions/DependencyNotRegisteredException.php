<?php
namespace ContentPromoter\Core\Exceptions;

class DependencyNotRegisteredException extends \Exception
{
    public function __construct($dependency, $code = 0, Exception $previous = null)
    {
        $message = "Dependency {$dependency} is not registered";
        parent::__construct($message, $code, $previous);
    }
}