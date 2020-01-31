<?php


namespace Badcow\DNS\Server;

use Badcow\DNS\Classes;
use Badcow\DNS\Rdata\RdataTrait;
use Badcow\DNS\Rdata\Types;
use Badcow\DNS\Rdata\UnsupportedTypeException;
use Badcow\DNS\Validator;
use InvalidArgumentException;

class Question
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $class;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function setName($name)
    {
        if (!Validator::fullyQualifiedDomainName($name)) {
            throw new InvalidArgumentException(sprintf('"%s" is not a fully qualified domain name.', $name));
        }

        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getType():int
    {
        return $this->type;
    }

    /**
     * @param string|int $type
     * @throws UnsupportedTypeException
     */
    public function setType($type)
    {
        if (is_string($type)) {
            $this->type = Types::getTypeCode($type);
        } elseif (is_int($type)) {
            $this->type = $type;
        } else {
            throw new UnsupportedTypeException(sprintf('Library does not support type "%s".', $type));
        }
    }

    /**
     * @return int
     */
    public function getClass(): int
    {
        return $this->class;
    }

    /**
     * @param string|int $class
     */
    public function setClass($class):void
    {
        if (is_string($class)) {
            $this->class = Classes::getClassId($class);
        } elseif (Validator::isUnsignedInteger($class, 16)) {
            $this->class = $class;
        } else {
            throw new InvalidArgumentException(sprintf('Invalid class: "%s".', $class));
        }
    }

    /**
     * @return string
     */
    public function toWire(): string
    {
        return RdataTrait::encodeName($this->name).pack('nn', $this->type, $this->class);
    }
}