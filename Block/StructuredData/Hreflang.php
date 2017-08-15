<?php

namespace Fox\Seo\Block\StructuredData;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class Hreflang extends \Magento\Framework\View\Element\Template
{
    /** @var \Magento\Framework\Registry */
    protected $registry;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    )
    {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Get this website's language codes & URLs.
     *
     * @return array
     *   Keyed by language code, value is store's base URL.
     */
    public function getLangs() {
        $storelangs = [];
        $currentWebsiteId = $this->getCurrentWebsiteId();
        $product = $this->registry->registry('current_product');

        foreach ($this->_storeManager->getStores() as $code => $store) {
            if ($store->getWebsiteId() === $currentWebsiteId) {
                $storeUrl = $product->setStoreId($store->getId())->getUrlInStore();
                $storeLangcode = $this->_scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $code);
                $storelangs[$storeLangcode] = $storeUrl;
            }
        }

        return $storelangs;
    }

    /**
     * @return int
     */
    protected function getCurrentWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }
}