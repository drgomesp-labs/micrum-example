<?php declare(strict_types=1);

namespace Mercur\Common\Traits;

use OutOfBoundsException;
use RuntimeException;

/**
 * Trait ArrayAccess
 *
 * @package Mercur\Common\Traits
 */
trait StdClassArrayAccess
{
    /**
     * @var \stdClass
     */
    protected $internal;

    public function offsetExists($offset)
    {
        return property_exists($this->internal, $offset);
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new OutOfBoundsException("Offset $offset does not exist");
        }

        return $this->internal->{$offset};
    }

    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            throw new RuntimeException("Offset $offset already exists");
        }

        $this->internal->{$offset} = $value;
    }

    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new OutOfBoundsException("Offset $offset does not exist");
        }

        unset($this->internal->{$offset});
    }
}
