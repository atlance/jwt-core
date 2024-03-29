<?php

declare(strict_types=1);

namespace Atlance\JwtCore\Tests\Functional;

use Atlance\JwtCore\Tests\Configuration\Configuration;
use Atlance\JwtCore\Tests\Configuration\Factory\ConfigurationFactory;
use Atlance\JwtCore\Tests\Factory\DecoderFactory;
use Atlance\JwtCore\Tests\Factory\EncoderFactory;
use Atlance\JwtCore\Token\Contracts\DataSet\DataSetInterface;
use Atlance\JwtCore\Token\Contracts\DecodeInterface;
use Atlance\JwtCore\Token\Contracts\EncodeInterface;
use PHPUnit\Framework\TestCase;

class KernelTestCase extends TestCase
{
    private ?EncodeInterface $encoder = null;

    private ?DecodeInterface $decoder = null;

    private static ?Configuration $staticConfiguration = null;

    private static ?EncodeInterface $staticEncoder = null;

    private static ?DecodeInterface $staticDecoder = null;

    /** @return non-empty-string */
    public function encode(DataSetInterface $claimset): string
    {
        if (!$this->encoder instanceof EncodeInterface) {
            throw new \RuntimeException('Encoder must be initialized.');
        }

        return $this->encoder->encode($claimset);
    }

    /** @param non-empty-string $encodedToken */
    public function decode(string $encodedToken): DataSetInterface
    {
        if (!$this->decoder instanceof DecodeInterface) {
            throw new \RuntimeException('Decoder must be initialized.');
        }

        return $this->decoder->decode($encodedToken);
    }

    public static function configuration(): Configuration
    {
        if (!isset(self::$staticConfiguration)) {
            self::$staticConfiguration = ConfigurationFactory::create();
        }

        return self::$staticConfiguration;
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!isset(self::$staticConfiguration)) {
            self::$staticConfiguration = ConfigurationFactory::create();
        }

        if (!isset(self::$staticEncoder)) {
            self::$staticEncoder = EncoderFactory::create(self::$staticConfiguration);
        }

        if (!isset(self::$staticDecoder)) {
            self::$staticDecoder = DecoderFactory::create(self::$staticConfiguration);
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->encoder = self::$staticEncoder;
        $this->decoder = self::$staticDecoder;
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->encoder = null;
        $this->decoder = null;
    }
}
