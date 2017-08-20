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

        // Maybe the category is in the product?
        if ($category === null) {
            $category = $observer->getEvent()->getProduct()->getCategory();
        }

        // Or maybe there's just no category.
        if ($category === null) return;

        $this->_foxSeoHelper->checkMetaData($category, 'category');

        if ($robots = $category->getData('foxseo_metarobots'))
        {
            $this->_config->setRobots($robots);
        }
    }
}
