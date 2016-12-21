<?php

namespace Knp\FriendlyContexts\Alice\Fixtures;

use Knp\FriendlyContexts\Alice\ProviderResolver;
use Knp\FriendlyContexts\Alice\ServiceResolver;
use Nelmio\Alice\Fixtures\Loader as BaseLoader;

class Loader extends BaseLoader
{
    private $cache = [];

    private $processors = [];

    public function __construct($locale, ServiceResolver $providers, ServiceResolver $processors)
    {
        parent::__construct($locale, $providers->all());
        $this->processors = $processors->all();
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function getProcessors()
    {
        return $this->processors;
    }

    public function clearCache()
    {
        $this->cache = [];
    }

    /**
     * {@inheritdoc}
     */
    protected function instantiateFixtures(array $fixtures)
    {
        parent::instantiateFixtures($fixtures);

        foreach ($fixtures as $fixture) {
            $spec = array_map(function ($property) {
                return $property->getValue();
            }, $fixture->getProperties());

            $this->cache[] = [ $spec, $this->objects->get($fixture->getName()) ];
        }
    }
}
