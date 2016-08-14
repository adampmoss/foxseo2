<?php

namespace Fox\Seo\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

class CanonicalProductRedirect implements ObserverInterface
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var \Magento\Framework\Url
     */
    protected $_url;

    /**
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $_responseInterface;


    public function __construct(
        \Fox\Seo\Helper\Data $foxSeoHelper,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Url $url,
        \Magento\Framework\App\ResponseInterface $responseInterface
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
        $this->_productRepository = $productRepository;
        $this->_url = $url;
        $this->_responseInterface = $responseInterface;
    }

    /**
     * Set the category heading using the custom attribute if set
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->_foxSeoHelper->getConfig('catalog/seo/product_canonical_tag') && !$this->_foxSeoHelper->getConfig('catalog/seo/product_use_categories'))
        {
            if ($this->_foxSeoHelper->getConfig('foxseo/settings/forcecanonical')) {

                // Maintain querystring if one is set (to maintain tracking URLs such as gclid)
                $querystring = ($_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '');
                $controller = $observer->getEvent()->getControllerAction();
                $data = $controller->getRequest();
                $product = $this->_productRepository->getById($data->getParam('id'));

                $requestUrl = $this->_url->getCurrentUrl();
                $redirectUrl = $product->getUrlModel()->getUrl($product, array('_ignore_category'=>true)).$querystring;

                if ($requestUrl !== $redirectUrl)
                {
                    $controller->getResponse()->setRedirect($redirectUrl, 301);
                    $this->_responseInterface->sendResponse();
                }

                return;
            }
        }
    }
}
