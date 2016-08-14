<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class SetSearchMetaRobots implements ObserverInterface
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
     * Set quick search results page meta robots if configured
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_foxSeoHelper->getConfig('foxseo/settings/noindexparamssearch'))
        {
            $this->_config->setRobots('NOINDEX, FOLLOW');
        }
    }
}
