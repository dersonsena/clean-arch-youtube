<?php

declare(strict_types=1);

namespace App\Shared\Application;

use App\Shared\Application\Contracts\UseCaseBoundary;
use InvalidArgumentException;

/**
 * Class Boundary
 * @package App\Shared\Application
 * @author Kilderson Sena <dersonsena@gmail.com>
 */
abstract class Boundary implements UseCaseBoundary
{
    /**
     * Boundary constructor.
     * @param array $values
     * @throws InvalidArgumentException if any property doesn't exists
     */
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
     * Static method to create a Boundary (Input or Output)
     * @param array $values Associative array such as `'property' => 'value'`
     * @return UseCaseBoundary
     */
    public static function create(array $values): UseCaseBoundary
    {
        return new static($values);
    }

    /**
     * {@inheritdoc}
     */
    public function values(): array
    {
        return get_object_vars($this);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $property)
    {
        return $this->__get($property);
    }

    /**
     * Magic getter method to get a Boudary property value
     * @param string $name
     * @return mixed
     * @throws InvalidArgumentException if any property doesn't exists
     */
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
