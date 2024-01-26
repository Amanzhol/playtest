<?php

namespace App\For_Test;

class Container
{
    private array $bindings = [];
    private array $singletons = [];


    public function bind(string $key, $val, $shared = false)
    {
        $this->bindings[$key] = [
            'concrete' => $val,
            'shared' => $shared
        ];
    }

    public function singleton(string $key, $val)
    {
        $this->bind($key, $val, true);
    }

    public function get(string $key): mixed
    {
        if (! isset($this->bindings[$key]))
        {
            if (class_exists($key))
            {
                return $this->make($key);
            }

            throw new \Exception('Class not existed '.$key);
        }

        $binding = $this->bindings[$key];

        if ($binding['shared'] && isset($this->singletons[$key]))
        {
            return $this->singletons[$key];
        }

        if ($binding['concrete'] instanceof \Closure)
        {
            $binding['concrete'] = $binding['concrete']();

            if ($binding['shared'])
            {
                $this->singletons[$key] = $binding['concrete'];
            }

            return $binding['concrete'];
        }

        return $binding['concrete'];
    }

    /**
     * @param string $key
     * @return mixed|object|string|null
     * @throws \ReflectionException
     */
    public function make(string $key): mixed
    {
        $reflector = new \ReflectionClass($key);
        $constructor = $reflector->getConstructor();

        if (!isset($constructor)) return new $key;

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $dependency = $parameter->getType()->getName();
            $dependencies[] = $this->make($dependency);
        }

        return $reflector->newInstanceArgs($dependencies);
    }

}
