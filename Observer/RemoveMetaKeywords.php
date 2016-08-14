<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class RemoveMetaKeywords implements ObserverInterface
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
     * Remove meta keywords tag if configured
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_foxSeoHelper->getConfig('foxseo/settings/removekeywords'))
        {
            $this->_config->setKeywords('');
        }
    }
}
