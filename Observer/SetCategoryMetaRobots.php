<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class SetCategoryMetaRobots implements ObserverInterface
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $_config;

    public function __construct(
        \Fox\Seo\Helper\Data $foxSeoHelper,
        \Magento\Framework\View\Page\Config $config
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
        $this->_config = $config;
    }

    /**
     * Set category page meta robots if configured
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $requestUrl = $observer->getEvent()->getControllerAction()->getRequest()->getRequestUri();

        // If the the URL has query string parameters
        if ($this->_foxSeoHelper->getConfig('foxseo/settings/noindexparams') && stristr($requestUrl, "?"))
        {
            $this->_config->setRobots('NOINDEX, FOLLOW');
        }
    }
}
