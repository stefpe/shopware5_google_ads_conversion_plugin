{extends file='parent:frontend/index/index.tpl'}

{block name="frontend_index_header_javascript_tracking"}
    {$smarty.block.parent}
    {if $GoogleAdsTrackingActive }
    <script async src="https://www.googletagmanager.com/gtag/js?id={$GoogleAdsConversionId}"></script>
    <script>
      // Default consent mode (before user interaction)
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      
      gtag('consent', 'default', {
        'ad_storage': 'denied',
        'ad_user_data': 'denied',
        'ad_personalization': 'denied',
        'analytics_storage': 'denied'
      });

      gtag('js', new Date());
      gtag('config', '{$GoogleAdsConversionId}');

      function applyConsent(adConsent) {
        const state = (adConsent) ? 'granted' : 'denied';
          gtag('consent', 'update', {
            'ad_storage': state,
            'ad_user_data': state,
            'ad_personalization': state,
            'analytics_storage': state
          });
      }

      document.addEventListener('DOMContentLoaded', function () {
        if($.getCookiePreference('google_consent')){
          applyConsent(true);
        }

        // Listen for cookie consent changes
        $.subscribe('plugin/swCookieConsentManager/onBuildCookiePreferences', function (event, plugin, preferences) {
          applyConsent($.getCookiePreference('google_consent'));
        });
        
          {if $Controller == 'checkout' && $SwapAction == 'finish' && $GoogleAdsConversionLabel}
          gtag('event', 'conversion', {
          'send_to': '{$GoogleAdsConversionId}/{$GoogleAdsConversionLabel}',
          'value': {$sAmount|replace:',':'.'},
          'currency': '{$sBasket.sCurrencyName}',
          'transaction_id': '{$sOrderNumber}'
          });
          {/if}
      });
    </script>
    {/if}
{/block}