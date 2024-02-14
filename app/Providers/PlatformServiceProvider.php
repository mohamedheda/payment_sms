<?php

namespace App\Providers;

use App\Http\Services\Api\V1\Auth\AuthMobileService;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Http\Services\Api\V1\Auth\AuthWebService;
use Illuminate\Support\ServiceProvider;
use function Laravel\Prompts\select;

class PlatformServiceProvider extends ServiceProvider
{
    private const VERSIONS = [
        1,
    ];
    private const PLATFORMS = [
        'website',
        'mobile',
    ];
    private const SERVICES = [
//   Version => Services
        1 => [
            AuthService::class => [
                'website' => AuthWebService::class,
                'mobile' => AuthMobileService::class
            ]
        ],
    ];
    private ?int $version = null;
    private ?string $platform = null;

    public function __construct($app)
    {
        parent::__construct($app);
        foreach (self::VERSIONS as $version) {
            foreach (self::PLATFORMS as $platform) {
                $pattern = app()->isProduction()
                    ? 'v' . $version . '/' . $platform . '/*'
                    : 'api/v' . $version . '/' . $platform . '/*';
                if (request()->is($pattern)) {
                    $this->version = $version;
                    $this->platform = $platform;
                } else {
                    // In case the version and the platform cannot be assigned, assign the first values instead as fallback data
                    $this->version = self::VERSIONS[0];
                    $this->platform = self::PLATFORMS[0];
                }
            }
        }
    }

    private function initiate(): void
    {
        foreach (self::SERVICES[$this->version] ?? [] as $abstractService => $targetService) {
            $this->app->singleton($abstractService, $targetService[$this->platform]);
        }
    }

    public function register(): void
    {
        $this->initiate();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
