<?php

namespace AceOugi;

class Resolver
{
    public static function callable() : callable
    {
        return __CLASS__.'::resolve';
    }

    /**
     * Cast predisposed callable to callable
     * @param callable $callable
     * @return callable
     */
    public static function resolve($callable) : callable
    {
        if (is_callable($callable))
            return $callable;

        if (is_string($callable))
        {
            // String class ==> 'Namespace\\Class' or Namespace\Class::class
            if (class_exists($callable))
                return new $callable;
            // String class.method ==> 'Namespace\\Class.method'
            if ($class = strstr($callable, '.', true) AND
                $method = strstr($callable, '.') AND
                $method = substr($method, 1)
            )
                return [new $class, $method];
        }

        throw new \InvalidArgumentException('Unrecognized callable');
    }

    /**
     * Alias of static::resolve()
     * @param callable $callable
     * @return callable
     */
    public function __invoke($callable) : callable
    {
        return $this->resolve($callable);
    }
}
