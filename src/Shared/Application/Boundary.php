<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Application\Contracts\UseCaseBoundary;
use InvalidArgumentException;

abstract class Boundary implements UseCaseBoundary
{
    private function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if (mb_strstr($key, '_') !== false) {
                $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            }

            if (!property_exists($this, $key)) {
                throw new InvalidArgumentException("Property '{$key}' doesn't exists in Boundary Class '" . get_class() . "'");
            }

            $this->{$key} = $value;
        }
    }

    /**
     * @param array $values
     * @return static
     */
    public static function create(array $values): self
    {
        return new static($values);
    }

    public function values(): array
    {
        return get_object_vars($this);
    }

    public function get(string $key)
    {
        return $this->{$key};
    }

    public function __get(string $name)
    {
        $getter = "get" . ucfirst($name);

        if (mb_strstr($name, '_') !== false) {
            $getter = "get" . str_replace('_', '', ucwords($name, '_'));
        }

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (!property_exists($this, $name)) {
            throw new InvalidArgumentException("Property '{$name}' doesn't exists in Boundary Class '" . get_class() . "'");
        }

        return $this->{$name};
    }
}
