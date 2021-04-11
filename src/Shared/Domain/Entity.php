<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use InvalidArgumentException;

abstract class Entity
{
    private function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if (mb_strstr($key, '_') !== false) {
                $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            }

            if (!property_exists($this, $key)) {
                throw new InvalidArgumentException("Property '{$key}' doesn't exists in Entity Class '" . get_class() . "'");
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

    /**
     * @param array $values
     */
    public function fill(array $values): void
    {
        foreach ($values as $key => $value) {
            if ($value === null) {
                unset($values[$key]);
            }
        }

        foreach ($values as $attribute => $value) {
            $setter = 'set' . str_replace('_', '', ucwords($attribute, '_'));

            if (method_exists($this, $setter)) {
                $this->$setter($value);
                continue;
            }

            $this->{$attribute} = $values;
        }
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
            throw new InvalidArgumentException("Property '{$name}' doesn't exists in Entity Class '" . get_class() . "'");
        }

        return $this->{$name};
    }
}
