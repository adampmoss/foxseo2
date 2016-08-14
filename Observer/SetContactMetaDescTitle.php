<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class SetContactMetaDescTitle implements ObserverInterface
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    /**
     * @var \Magento\Framework\View\Page\Config
     */
    protected $_config;

    /**
     * @var \Magento\Framework\View\Page\Title
     */
    protected $_title;

    public function __construct(
        \Fox\Seo\Helper\Data $foxSeoHelper,
        \Magento\Framework\View\Page\Config $config,
        \Magento\Framework\View\Page\Title $title
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
        $this->_config = $config;
        $this->_title = $title;
    }

    /**
     * Set meta description and page title on contact page if configured
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($metaDescription = $this->_foxSeoHelper->getConfig('foxseo/metadata/contact_metadesc'))
        {
            $this->_config->setDescription($metaDescription);
        }

        if ($pageTitle = $this->_foxSeoHelper->getConfig('foxseo/metadata/contact_title'))
        {
            $this->_title->set($pageTitle);
        }
    }
}
