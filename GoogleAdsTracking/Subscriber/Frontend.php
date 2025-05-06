<?php

namespace GoogleAdsTracking\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Controller_ActionEventArgs;
use Enlight_View_Default;
use Shopware_Components_Config;

class Frontend implements SubscriberInterface
{

    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @var Shopware_Components_Config
     */
    private $config;

    private $templateManager;

    /**
     * @param Shopware_Components_Config $config
     */
    public function __construct(string $pluginDirectory, Shopware_Components_Config $config, \Enlight_Template_Manager $templateManager)
    {
        $this->pluginDirectory = $pluginDirectory;
        $this->config = $config;
        $this->templateManager = $templateManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onFrontendPreDispatch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch',
        ];
    }

    public function onFrontendPreDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        $this->templateManager->addTemplateDir($this->pluginDirectory . '/Resources/views/');
    }

    /**
     * Adds the Google Ads tracking code to the template
     *
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onFrontendPostDispatch(Enlight_Controller_ActionEventArgs $args)
    {
        /** @var Enlight_View_Default $view */
        $view = $args->getSubject()->View();
        $controller = $args->getSubject();
        
        // Only inject the script on storefront pages
        if (!$view || !$controller->Request()->isDispatched() || $controller->Request()->getModuleName() !== 'frontend') {
            return;
        }
        
        // Get configuration values using the proper namespace for plugin configs
        $googleAdsConversionId = $this->config->getByNamespace('GoogleAdsTracking', 'googleAdsConversionId');
        $googleAdsConversionLabel = $this->config->getByNamespace('GoogleAdsTracking', 'googleAdsConversionLabel');

        // Only activate tracking if Google Ads Conversion ID is set
        if (empty($googleAdsConversionId)) {
            return;
        }
        
        $view->assign('GoogleAdsTrackingActive', true);
        $view->assign('GoogleAdsConversionId', $googleAdsConversionId);
        $view->assign('GoogleAdsConversionLabel', $googleAdsConversionLabel);
    }
} 