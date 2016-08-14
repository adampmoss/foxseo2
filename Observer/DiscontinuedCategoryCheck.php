<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class DiscontinuedCategoryCheck implements ObserverInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $_categoryRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;


    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    )
    {
        $this->_categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->_messageManager = $messageManager;
    }

    /**
     * Redirect category appropriately if discontinued
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $controller = $observer->getEvent()->getControllerAction();
        $data = $controller->getRequest();
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();

        $category = $this->_categoryRepository->get($data->getParam('id'));

        $this->_messageManager->addError(__('The category \'%s\' is discontinued'), $category->getName());

        if (empty($category->getIsActive()))
        {
            if ($category->getLevel() > 1)
            {
                // redirect to category parent
                $parentCategory = $this->_categoryRepository->get($category->getParentId());
                $controller->getResponse()->setRedirect($parentCategory->getUrl(), 301);
            } else {
                // redirect to homepage
                $controller->getResponse()->setRedirect($baseUrl, 301);
            }
        }

        return;
    }
}
