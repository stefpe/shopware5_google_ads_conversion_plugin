<?php

namespace GoogleAdsTracking;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class GoogleAdsTracking extends Plugin
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->setParameter('google_ads_tracking.plugin_dir', $this->getPath());
        parent::build($container);
    }

    /**
     * {@inheritdoc}
     */
    public function uninstall(UninstallContext $context)
    {
        // Remove configuration if not keeping user data
        if (!$context->keepUserData()) {
            $this->removeConfiguration();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    /**
     * {@inheritdoc}
     */
    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

    

    /**
     * Removes the plugin configuration
     */
    private function removeConfiguration()
    {
        $config = $this->container->get('config');
        $config->delete('googleAdsConversionId');
        $config->delete('googleAdsConversionLabel');
    }
}