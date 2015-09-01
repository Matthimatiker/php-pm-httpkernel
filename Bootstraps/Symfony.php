<?php

namespace PHPPM\Bootstraps;

use Stack\Builder;
use Symfony\Component\HttpKernel\HttpCache\Store;

/**
 * A default bootstrap for the Symfony framework
 */
class Symfony implements StackableBootstrapInterface
{
    /**
     * @var string|null The application environment
     */
    protected $appenv;

    /**
     * Instantiate the bootstrap, storing the $appenv
     */
    public function __construct($appenv)
    {
        $this->appenv = $appenv;
    }

    /**
     * Create a Symfony application
     */
    public function getApplication()
    {
        if (file_exists('./app/AppKernel.php')) {
            require_once './app/AppKernel.php';
        }

        $app = new \AppKernel($this->appenv, $this->isDebug());
        $app->loadClassCache();

        return $app;
    }

    /**
     * Return the StackPHP stack.
     */
    public function getStack(Builder $stack)
    {
        return $stack;
    }

    /**
     * Determines if the kernel should be started in debug mode.
     *
     * The environment variable SYMFONY_DEBUG is used to determine if the debug mode
     * should be enabled.
     * If the variable is not defined, then the configured environment is used to
     * determine, if the debug mode should be enabled. Debug will be enabled, when
     * the environment is defined as "dev". This is usually the default behavior,
     * when using Symfony standard.
     *
     * @return bool
     */
    protected function isDebug()
    {
        if (($debug = getenv('SYMFONY_DEBUG')) !== false) {
            return (bool)$debug;
        }
        return $this->appenv === 'dev';
    }
}
