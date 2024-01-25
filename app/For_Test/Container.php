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
            throw new \Exception('No binding registered for '.$key);
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

}
