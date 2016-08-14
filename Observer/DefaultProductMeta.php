<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class DefaultProductMeta implements ObserverInterface
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
     * Set default product meta data if set
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();

        $this->_foxSeoHelper->checkMetaData($category, 'category');

        if ($robots = $category->getData('foxseo_metarobots'))
        {
            $this->_config->setRobots($robots);
        }
    }
}
