<?php

declare(strict_types=1);

namespace Craftzing\Laravel\NotificationChannels\Postmark;

use Craftzing\Laravel\NotificationChannels\Postmark\Testing\Concerns\WithFaker;
use Craftzing\Laravel\NotificationChannels\Postmark\Testing\IntegrationTestCase;

use function config;

final class ServiceProviderTest extends IntegrationTestCase
{
    use WithFaker;

    protected bool $shouldFakeConfig = false;

    /**
     * @test
     */
    public function itBindsADefaultImplementationForTheConfigInterface(): void
    {
        config([
            'services.postmark.token' => $this->faker()->md5,
            'mail.default' => 'postmark',
            'mail.from.address' => $this->faker()->email,
            'mail.from.name' => $this->faker()->name,
        ]);

        $instance = $this->app[Config::class];

        $this->assertInstanceOf(IlluminateConfig::class, $instance);
    }
}
