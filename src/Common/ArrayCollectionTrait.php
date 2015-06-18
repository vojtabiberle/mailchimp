<?php

namespace Mailchimp\Common;

use ArrayAccess;
use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;

trait ArrayCollectionTrait
{
    private $__elements;

    private function setElements($elements)
    {
        $this->__elements = $elements;
    }

    public function toArray()
    {
        return $this->__elements;
    }

    public function first()
    {
        return reset($this->__elements);
    }

    public function last()
    {
        return end($this->__elements);
    }

    public function key()
    {
        return key($this->__elements);
    }

    public function next()
    {
        return next($this->__elements);
    }

    public function current()
    {
        return current($this->__elements);
    }

    public function remove($key)
    {
        if ( ! isset($this->__elements[$key]) && ! array_key_exists($key, $this->__elements)) {
            return null;
        }

        $removed = $this->__elements[$key];
        unset($this->__elements[$key]);

        return $removed;
    }

    public function removeElement($element)
    {
        $key = array_search($element, $this->__elements, true);

        if ($key === false) {
            return false;
        }

        unset($this->__elements[$key]);

        return true;
    }

    public function offsetExists($offset)
    {
        return $this->containsKey($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        if ( ! isset($offset)) {
            return $this->add($value);
        }

        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }

    public function containsKey($key)
    {
        return isset($this->__elements[$key]) || array_key_exists($key, $this->__elements);
    }

    public function contains($element)
    {
        return in_array($element, $this->__elements, true);
    }

    public function exists(Closure $p)
    {
        foreach ($this->__elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }

        return false;
    }

    public function indexOf($element)
    {
        return array_search($element, $this->__elements, true);
    }

    public function get($key)
    {
        return isset($this->__elements[$key]) ? $this->__elements[$key] : null;
    }

    public function getKeys()
    {
        return array_keys($this->__elements);
    }

    public function getValues()
    {
        return array_values($this->__elements);
    }

    public function count()
    {
        return count($this->__elements);
    }

    public function set($key, $value)
    {
        $this->__elements[$key] = $value;
    }

    public function add($value)
    {
        $this->__elements[] = $value;

        return true;
    }

    public function isEmpty()
    {
        return 0 === count($this->__elements);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->__elements);
    }

    public function map(Closure $func)
    {
        $obj = new static($this->getWorker());
        $obj->setElements(array_map($func, $this->__elements));
        return $obj;
    }

    public function filter(Closure $p)
    {
        $obj = new static($this->getWorker());
        $obj->setElements(array_filter($this->__elements, $p));
        return $obj;
    }

    public function forAll(Closure $p)
    {
        foreach ($this->__elements as $key => $element) {
            if ( ! $p($key, $element)) {
                return false;
            }
        }

        return true;
    }

    public function partition(Closure $p)
    {
        $matches = $noMatches = array();

        foreach ($this->__elements as $key => $element) {
            if ($p($key, $element)) {
                $matches[$key] = $element;
            } else {
                $noMatches[$key] = $element;
            }
        }

        $match = new static($this->getWorker());
        $match->setElements($matches);

        $noMatch = new static($this->getWorker());
        $noMatch->setElements($noMatches);

        return array($match, $noMatch);
    }

    public function __toString()
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    public function clear()
    {
        $this->__elements = array();
    }

    public function slice($offset, $length = null)
    {
        return array_slice($this->__elements, $offset, $length, true);
    }
}