<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class DiscontinuedProductCheck implements ObserverInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

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

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_responseInterface;


    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\App\ResponseInterface $responseInterface
    )
    {
        $this->_productRepository = $productRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_storeManager = $storeManager;
        $this->_messageManager = $messageManager;
        $this->_responseInterface = $responseInterface;
    }

    /**
     * Redirect the discontinued product appropriately
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $controller = $observer->getEvent()->getControllerAction();
        $data = $controller->getRequest();
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();

        $product = $this->_productRepository->getById($data->getParam('id'));

        // if discontinued is not set or the product is enabled, do nothing
        if ($product->getFoxseoDiscontinued() < 1 || $product->getStatus() === '1') {
            return false;
        }

        $this->_messageManager->addError('Product is Discontinued');

        switch ($product->getFoxseoDiscontinued()) {
            case 1; // Category Redirect

                $categoryIds = $product->getCategoryIds();

                if (count($categoryIds)) {
                    $category = $this->_categoryRepository->get($categoryIds[0]);
                    $controller->getResponse()->setRedirect($category->getUrl(), 301);
                } else {
                    $controller->getResponse()->setRedirect($baseUrl, 301);
                }

                break;

            case 2; // Homepage Redirect

                $controller->getResponse()->setRedirect($baseUrl, 301);
                $this->_responseInterface->sendResponse();
                break;

            case 3; // Product Redirect

                $sku = $product->getFoxseoDiscontinuedProduct();

                if (!empty($sku)) {
                    $redirectProduct = $this->_productRepository->get($sku);
                    $controller->getResponse()->setRedirect($redirectProduct->getProductUrl(), 301);
                } else {
                    $controller->getResponse()->setRedirect($baseUrl, 301);
                }
                break;
        }

        return false;
    }
}
