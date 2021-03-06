<?php

declare(strict_types=1);

/*
 * This file is part of Badcow DNS Server.
 *
 * (c) Samuel Williams <sam@badcow.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Badcow\DNS\Server;

use Badcow\DNS\Rdata\UnsupportedTypeException;
use Badcow\DNS\ResourceRecord;
use Badcow\DNS\UnsetValueException;

class Message
{
    /**
     * ID.
     *
     * @var int
     */
    private $id;

    /**
     * QR.
     *
     * @var bool
     */
    private $isResponse;

    /**
     * OPCODE.
     *
     * @var int
     */
    private $opcode;

    /**
     * AA.
     *
     * @var bool
     */
    private $isAuthoritative;

    /**
     * TC.
     *
     * @var bool
     */
    private $isTruncated;

    /**
     * RD.
     *
     * @var bool
     */
    private $isRecursionDesired;

    /**
     * RA.
     *
     * @var bool
     */
    private $isRecursionAvailable;

    /**
     * A.
     *
     * @var int
     */
    private $z = 0;

    /**
     * RCODE.
     *
     * @var int
     */
    private $rcode;

    /**
     * @var Question[]
     */
    private $questions = [];

    /**
     * @var ResourceRecord[]
     */
    private $answers = [];

    /**
     * @var ResourceRecord[]
     */
    private $authoritatives = [];

    /**
     * @var ResourceRecord[]
     */
    private $additionals = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isResponse(): bool
    {
        return $this->isResponse;
    }

    /**
     * @param bool $isResponse
     */
    public function setResponse(bool $isResponse): void
    {
        $this->isResponse = $isResponse;
    }

    /**
     * @return bool
     */
    public function isQuery(): bool
    {
        return !$this->isResponse;
    }

    /**
     * @param bool $query
     */
    public function setQuery(bool $query): void
    {
        $this->setResponse(!$query);
    }

    /**
     * @return int
     */
    public function getOpcode(): int
    {
        return $this->opcode;
    }

    /**
     * @param int $opcode
     */
    public function setOpcode(int $opcode): void
    {
        $this->opcode = $opcode;
    }

    /**
     * @return bool
     */
    public function isAuthoritative(): bool
    {
        return $this->isAuthoritative;
    }

    /**
     * @param bool $isAuthoritative
     */
    public function setAuthoritative(bool $isAuthoritative): void
    {
        $this->isAuthoritative = $isAuthoritative;
    }

    /**
     * @return bool
     */
    public function isTruncated(): bool
    {
        return $this->isTruncated;
    }

    /**
     * @param bool $isTruncated
     */
    public function setTruncated(bool $isTruncated): void
    {
        $this->isTruncated = $isTruncated;
    }

    /**
     * @return bool
     */
    public function isRecursionDesired(): bool
    {
        return $this->isRecursionDesired;
    }

    /**
     * @param bool $isRecursionDesired
     */
    public function setRecursionDesired(bool $isRecursionDesired): void
    {
        $this->isRecursionDesired = $isRecursionDesired;
    }

    /**
     * @return bool
     */
    public function isRecursionAvailable(): bool
    {
        return $this->isRecursionAvailable;
    }

    /**
     * @param bool $isRecursionAvailable
     */
    public function setRecursionAvailable(bool $isRecursionAvailable): void
    {
        $this->isRecursionAvailable = $isRecursionAvailable;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->z;
    }

    /**
     * @param int $z
     */
    public function setZ(int $z): void
    {
        $this->z = $z;
    }

    /**
     * @return int
     */
    public function getRcode(): int
    {
        return $this->rcode;
    }

    /**
     * @param int $rcode
     */
    public function setRcode(int $rcode): void
    {
        $this->rcode = $rcode;
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param Question $question
     */
    public function addQuestion(Question $question): void
    {
        $this->questions[] = $question;
    }

    /**
     * @param Question[] $questions
     */
    public function setQuestions(array $questions): void
    {
        $this->questions = [];
        foreach ($questions as $question) {
            $this->addQuestion($question);
        }
    }

    /**
     * @return ResourceRecord[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param ResourceRecord $answer
     */
    public function addAnswer(ResourceRecord $answer): void
    {
        $this->answers[] = $answer;
    }

    /**
     * @param ResourceRecord[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = [];
        foreach ($answers as $answer) {
            $this->addAnswer($answer);
        }
    }

    /**
     * @return ResourceRecord[]
     */
    public function getAuthoritatives(): array
    {
        return $this->authoritatives;
    }

    /**
     * @param ResourceRecord $authoritative
     */
    public function addAuthoritative(ResourceRecord $authoritative): void
    {
        $this->authoritatives[] = $authoritative;
    }

    /**
     * @param ResourceRecord[] $authoritatives
     */
    public function setAuthoritatives(array $authoritatives): void
    {
        $this->authoritatives = [];
        foreach ($authoritatives as $authoritative) {
            $this->addAuthoritative($authoritative);
        }
    }

    /**
     * @return ResourceRecord[]
     */
    public function getAdditionals(): array
    {
        return $this->additionals;
    }

    /**
     * @param ResourceRecord $additional
     */
    public function addAdditional(ResourceRecord $additional): void
    {
        $this->additionals[] = $additional;
    }

    /**
     * @param ResourceRecord[] $additionals
     */
    public function setAdditionals(array $additionals): void
    {
        $this->additionals = [];
        foreach ($additionals as $additional) {
            $this->addAdditional($additional);
        }
    }

    public function countQuestions(): int
    {
        return count($this->questions);
    }

    public function countAnswers(): int
    {
        return count($this->answers);
    }

    public function countAuthoritatives(): int
    {
        return count($this->authoritatives);
    }

    public function countAdditionals(): int
    {
        return count($this->additionals);
    }

    /**
     * @return string
     *
     * @throws UnsetValueException
     */
    public function toWire(): string
    {
        $flags = 0x0 |
            ($this->isResponse & 0x1) << 15 |
            ($this->opcode & 0xf) << 11 |
            ($this->isAuthoritative & 0x1) << 10 |
            ($this->isTruncated & 0x1) << 9 |
            ($this->isRecursionDesired & 0x1) << 8 |
            ($this->isRecursionAvailable & 0x1) << 7 |
            ($this->z & 0x7) << 4 |
            ($this->rcode & 0xf);

        $encoded = pack(
            'nnnnnn',
            $this->id,
            $flags,
            $this->countQuestions(),
            $this->countAnswers(),
            $this->countAuthoritatives(),
            $this->countAdditionals()
        );

        foreach ($this->questions as $question) {
            $encoded .= $question->toWire();
        }

        foreach ($this->answers as $answer) {
            $encoded .= $answer->toWire();
        }

        foreach ($this->authoritatives as $authoritative) {
            $encoded .= $authoritative->toWire();
        }

        foreach ($this->additionals as $additional) {
            $encoded .= $additional->toWire();
        }

        return $encoded;
    }

    /**
     * @param string $encoded
     *
     * @return Message
     *
     * @throws UnsupportedTypeException
     */
    public static function fromWire(string $encoded): Message
    {
        $message = new self();
        $offset = 0;
        $header = unpack('nid/nflags/nqdcount/nancount/nnscount/narcount', $encoded, $offset);
        $offset += 12;
        $flags = $header['flags'];
        $qdCount = $header['qdcount'];
        $anCount = $header['ancount'];
        $nsCount = $header['nscount'];
        $arCount = $header['arcount'];

        $message->setId($header['id']);
        $message->setResponse((bool) ($flags >> 15 & 0x1));
        $message->setOpcode($flags >> 11 & 0xf);
        $message->setAuthoritative((bool) ($flags >> 10 & 0x1));
        $message->setTruncated((bool) ($flags >> 9 & 0x1));
        $message->setRecursionDesired((bool) ($flags >> 8 & 0x1));
        $message->setRecursionAvailable((bool) ($flags >> 7 & 0x1));
        $message->setZ($flags >> 4 & 0x7);
        $message->setRcode($flags & 0xf);

        for ($i = 0; $i < $qdCount; ++$i) {
            $message->addQuestion(Question::fromWire($encoded, $offset));
        }

        for ($i = 0; $i < $anCount; ++$i) {
            $message->addAnswer(ResourceRecord::fromWire($encoded, $offset));
        }

        for ($i = 0; $i < $nsCount; ++$i) {
            $message->addAuthoritative(ResourceRecord::fromWire($encoded, $offset));
        }

        for ($i = 0; $i < $arCount; ++$i) {
            $message->addAdditional(ResourceRecord::fromWire($encoded, $offset));
        }

        return $message;
    }
}
