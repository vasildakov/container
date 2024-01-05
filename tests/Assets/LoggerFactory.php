<?php

namespace VasilDakov\ContainerTests\Assets;

use Psr\Container\ContainerInterface;

final class LoggerFactory
{
    public function __invoke(ContainerInterface $container): Logger
    {
        return new Logger(
            $container->get(Writer::class)
        );
    }
}
