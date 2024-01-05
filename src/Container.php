<?php

namespace VasilDakov\Container;

use Psr\Container\ContainerInterface;
use VasilDakov\Container\Exception\NotFoundException;

class Container implements ContainerInterface
{
    private array $entries = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException("Entry not found: $id");
        }

        $factory = $this->entries[$id];
        return $factory($this);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->entries);
    }

    public function add($id, callable|string $factory): void
    {
        if (is_callable($factory)) {
            $this->entries[$id] = $factory;
        }

        if (is_string($factory)) {
            $this->entries[$id] = new $factory();
        }
    }
}
