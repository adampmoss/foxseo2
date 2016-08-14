<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;

class CategorySeoHeading implements ObserverInterface
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    public function __construct(
        \Fox\Seo\Helper\Data $foxSeoHelper
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
    }

    /**
     * Set the category heading using the custom attribute if set
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $category = $observer->getEvent()->getCategory();
        $category->setOriginalName($category->getName());

        if ($this->_foxSeoHelper->getConfig('foxseo/settings/category_h1'))
        {
            if ($category->getData('foxseo_heading'))
            {
                $category->setName($category->getFoxseoHeading());
            }

        }
    }
}
