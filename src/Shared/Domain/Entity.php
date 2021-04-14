<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use InvalidArgumentException;

/**
 * Class Entity
 * @package App\Shared\Domain
 * @author Kilderson Sena <dersonsena@gmail.com>
 */
abstract class Entity
{
    /**
     * Entity constructor.
     * @param array $values
     * @throws InvalidArgumentException if any property doesn't exists
     */
    private function __construct(array $values)
    {
        foreach ($values as $key => $value) {
            if (mb_strstr($key, '_') !== false) {
                $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            }

            $setter = 'set' . str_replace('_', '', ucwords($key, '_'));

            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
                continue;
            }

            if (!property_exists($this, $key)) {
                throw new InvalidArgumentException("Property '{$key}' doesn't exists in Entity Class '" . get_class() . "'");
            }

            $this->{$key} = $value;
        }
    }

    /**
     * Static method to create an Entity
     * @param array $values
     * @return Entity
     */
    public static function create(array $values): self
    {
        return new static($values);
    }

    /**
     * Method for populate an Entity through array
     * @param array $values Associative array such as `'property' => 'value'`
     * @return void
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

    /**
     * Method used to create the entity validation. An example to create a validation:
     *
     * ```php
     * return [
     *     ...
     * ]
     * ```
     *
     * @return array List of validations settings to be used in validation process
     */
    public function validationRules(): array
    {
        return [];
    }

    /**
     * Magic getter method to get an Entity property value
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
            throw new InvalidArgumentException("Property '{$name}' doesn't exists in Entity Class '" . get_class() . "'");
        }

        return $this->{$name};
    }
}
