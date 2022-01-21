<?php

declare(strict_types=1);

namespace Craftzing\Laravel\NotificationChannels\Postmark\Testing\Facades;

use Craftzing\Laravel\NotificationChannels\Postmark\Config as ConfigInterface;
use Craftzing\Laravel\NotificationChannels\Postmark\FakeConfig;
use Illuminate\Support\Facades\Facade;
use LogicException;

use function sprintf;

final class Config extends Facade
{
    private static ?ConfigInterface $implementation = null;

    public static function fake(): void
    {
        self::$implementation = self::$app[self::getFacadeAccessor()];

        self::$app->instance(self::getFacadeAccessor(), self::$app[FakeConfig::class]);
    }

    public static function dontFake(): void
    {
        if (! self::$implementation) {
            throw new LogicException(sprintf("`%s` has not been faked.", self::getFacadeAccessor()));
        }

        self::$app->instance(self::getFacadeAccessor(), self::$implementation);
    }

    protected static function getFacadeAccessor(): string
    {
        return ConfigInterface::class;
    }
}
