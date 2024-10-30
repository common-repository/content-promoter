<?php
namespace ContentPromoter\Core\Interfaces;

if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}

interface ContainerInterface
{
    public function get($abstract);
    public function set($abstract, $concrete);
    public function has($abstract);
    public function concretize(String $entry);
    public function resolveParameter(\ReflectionParameter $parameters);
} 