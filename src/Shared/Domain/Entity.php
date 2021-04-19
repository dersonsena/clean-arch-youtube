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
            $this->setPropertyValue($key, $value);
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
        foreach ($values as $attribute => $value) {
            $this->setPropertyValue($attribute, $value);
        }
    }

    /**
     * Method that contains the property setter logic
     * @param string $property Object property name
     * @param mixed $value Value to be inserted in property
     * @return void
     */
    private function setPropertyValue(string $property, $value): void
    {
        if (mb_strstr($property, '_') !== false) {
            $property = lcfirst(str_replace('_', '', ucwords($property, '_')));
        }

        $setter = 'set' . str_replace('_', '', ucwords($property, '_'));

        if (method_exists($this, $setter)) {
            $this->{$setter}($value);
            return;
        }

        if (!property_exists($this, $property)) {
            throw new InvalidArgumentException("Property '{$property}' doesn't exists in Entity Class '" . get_class() . "'");
        }

        $this->{$property} = $value;
    }

    /**
     * Method used to create the entity validation. An example to create a validation:
     *
     * ```php
     * return [
     *     ...ValidationBuilder::field('property_name1')->required()->maxLength(25)->build(),
     *     ...ValidationBuilder::field('property_name2')->minLength(25)->build()
     *     ...ValidationBuilder::field('property_name3')->email()->build()
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

        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }

        if (!property_exists($this, $name)) {
            throw new InvalidArgumentException("Property '{$name}' doesn't exists in Entity Class '" . get_class() . "'");
        }

        return $this->{$name};
    }
}
