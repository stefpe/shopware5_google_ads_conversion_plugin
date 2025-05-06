<?php

namespace GoogleAdsTracking\Subscriber;

use Enlight\Event\SubscriberInterface;
use Enlight_Event_EventArgs;
use Shopware\Bundle\CookieBundle\CookieCollection;
use Shopware\Bundle\CookieBundle\Structs\CookieGroupStruct;
use Shopware\Bundle\CookieBundle\Structs\CookieStruct;

class CookieProvider implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'CookieCollector_Collect_Cookies' => 'addCookies'
        ];
    }
    
    /**
     * Adds Google Ads cookies to the cookie collection
     *
     * @param Enlight_Event_EventArgs $args
     * @return CookieCollection
     */
    public function addCookies()
    {
        $collection = new CookieCollection();
        
        $collection->add(new CookieStruct(
            'google_consent',
            '/^google_consent$/',
            'Erlaubnis für Google Ads, Google Analytics und Google Tag Manager',
            CookieGroupStruct::STATISTICS
        ));
        
        return $collection;
    }
}