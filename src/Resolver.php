<?php

namespace AceOugi;

class Resolver
{
    /**
     * Cast predisposed callable to callable
     * @param callable $callable
     * @throws \InvalidArgumentException
     * @return callable
     */
    public static function resolve($callable) : callable
    {
        if (is_string($callable))
        {
            if (class_exists($callable))
                return new $callable;

            if ($class = strstr($callable, '.', true) AND $method = substr(strstr($callable, '.'), 1))
                return [new $class, $method];
        }

        throw new \InvalidArgumentException();
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
