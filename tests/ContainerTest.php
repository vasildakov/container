<?php

namespace VasilDakov\ContainerTests;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use VasilDakov\Container\Container;
use VasilDakov\ContainerTests\Assets\Logger;
use VasilDakov\ContainerTests\Assets\LoggerFactory;
use VasilDakov\ContainerTests\Assets\Writer;

final class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function itCanBeCreated(): void
    {
        $container = new Container();

        self::assertInstanceOf(ContainerInterface::class, $container);
    }

    /**
     * @test
     */
    public function itCanAddCallables(): void
    {
        // Arrange
        $container = new Container();
        $container->add(Writer::class, function (ContainerInterface $container) {
            return new Writer();
        });

        $container->add(Logger::class, function (ContainerInterface $container) {
            return new Logger(
                $container->get(Writer::class)
            );
        });

        // Act
        $logger = $container->get(Logger::class);

        // Assert
        self::assertInstanceOf(Logger::class, $logger);
    }

    /**
     * @test
     */
    public function itCanAddFactories(): void
    {
        // Arrange
        $container = new Container();
        $container->add(Writer::class, function (ContainerInterface $container) {
            return new Writer();
        });

        $container->add(Logger::class,LoggerFactory::class);

        // Act
        $logger = $container->get(Logger::class);

        // Assert
        self::assertInstanceOf(Logger::class, $logger);
        self::assertInstanceOf(Writer::class, $logger->writer);
    }
}
