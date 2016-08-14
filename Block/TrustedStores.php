<?php

namespace Fox\Seo\Block;

class TrustedStores extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    /**
     * @var Product
     */
    protected $_product = null;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Fox\Seo\Helper\Data $foxSeoHelper
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Fox\Seo\Helper\Data $foxSeoHelper,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
        $this->_orderFactory = $orderFactory;
        $this->_coreRegistry = $registry;
        $this->_checkoutSession = $checkoutSession;
        parent::__construct($context, $data);
    }

    /**
     * @param $configpath
     * @return mixed
     */
    public function getConfig($configpath)
    {
        return $this->_foxSeoHelper->getConfig($configpath);
    }

    /**
     * @param $configpath
     * @return mixed
     */
    public function getGtsConfig($configpath)
    {
        return $this->_foxSeoHelper->getConfig('foxseo/google_trusted_store/'.$configpath);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        /** @var \Magento\Sales\Model\Order $order */
        return $this->_checkoutSession->getLastRealOrder();
    }

    /**
     * @return mixed
     */
    public function getFormattedBaseUrl()
    {
        $replace = [
            'https://',
            'http://',
            '/'
        ];

        return str_replace($replace, '', $this->getBaseUrl());
    }

    /**
     * @param $items
     * @return string
     */
    public function orderHasVirtualProducts($items)
    {
        foreach($items as $item) {
            if ($item->getProductType() === 'virtual' || $item->getProductType() === 'downloadable') {
                return 'Y';
            }
        }

        return 'N';
    }

    /**
     * @param $items
     * @return string
     */
    public function orderHasPreOrders($items) {
        $count = 0;
        foreach($items as $item) {
            $count = $count + (float)$item->getQtyBackordered();
        }

        return ($count>0)?'Y':'N';
    }

    /**
     * @param $price
     * @return float|string
     */
    public function price($price)
    {
        if ($price > 0)
        {
            return number_format($price, 2);
        }

        return (float) $price;
    }

    /**
     * @param $qty
     * @return string
     */
    public function qty($qty)
    {
        return number_format($qty, 1);
    }

    /**
     * @param $created_at
     * @return bool|string
     */
    public function estimatedShippingDate($created_at)
    {
        $days_to_ship = $this->getGtsConfig('estimated_shipping_days');

        return date("Y-m-d", strtotime($created_at. ' + '.$days_to_ship));
    }

    /**
     * @param $created_at
     * @return bool|string
     */
    public function estimatedDeliveryDate($created_at)
    {
        $days_to_ship = $this->getGtsConfig('estimated_shipping_days');
        $days_to_deliver = $this->getGtsConfig('estimated_delivery_days');

        $days_total = $days_to_ship + $days_to_deliver;

        $days = ($days_total === 1) ? ' day' : ' days';

        return date("Y-m-d", strtotime($created_at. ' + '.$days_total.$days));
    }

}