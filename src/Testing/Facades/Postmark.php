<?php

declare(strict_types=1);

namespace Craftzing\Laravel\NotificationChannels\Postmark\Testing\Facades;

use Craftzing\Laravel\NotificationChannels\Postmark\Config as ConfigInterface;
use Craftzing\Laravel\NotificationChannels\Postmark\TemplateMessage;
use Craftzing\Laravel\NotificationChannels\Postmark\Testing\Doubles\FakePostmarkClient;
use Illuminate\Support\Facades\Facade;
use LogicException;
use Postmark\PostmarkClient;

use function sprintf;

/**
 * @method static void assertSendEmailWithTemplate(TemplateMessage $message)
 * @see FakePostmarkClient::assertSendEmailWithTemplate
 *
 * @method static \Postmark\Models\PostmarkException respondWithInactiveRecipientError
 * @see FakePostmarkClient::respondWithInactiveRecipientError
 *
 * @method static \Postmark\Models\PostmarkException respondWithError
 * @see FakePostmarkClient::respondWithError
 */
final class Postmark extends Facade
{
    public static function fake(): void
    {
        // By default, the service provider should not bind an instance of the PostmarkClient to the IoC
        // container, as it is an implementation detail. However, classes using PostmarkClient should
        // accept an optional client instance as a constructor argument. This should enable us to
        // provide a fake implementation via IoC binding when running tests, preventing the
        // implementation from initialising a real PostmarkClient instance under the hood.
        self::$app->instance(self::getFacadeAccessor(), new FakePostmarkClient());
    }

    public static function dontFake(): void
    {
        // When "unfaking" the PostmarkClient, we should drop the container binding so classes
        // using PostmarkClient will once again initialise a real instance themselves.
        unset(self::$app[self::getFacadeAccessor()]);
    }

    protected static function getFacadeAccessor(): string
    {
        return PostmarkClient::class;
    }
}
