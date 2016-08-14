<?php

namespace Fox\Seo\Block\StructuredData;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class TwitterCards extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Fox\Seo\Helper\Data
     */
    protected $_foxSeoHelper;

    /**
     * @var \Magento\Bundle\Model\Product\Price
     */
    protected $_bundlePrice;

    /**
     * @var Product
     */
    protected $_product = null;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Fox\Seo\Helper\Data $foxSeoHelper
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Bundle\Model\Product\Price $bundlePrice
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Fox\Seo\Helper\Data $foxSeoHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Bundle\Model\Product\Price $bundlePrice,
        PriceCurrencyInterface $priceCurrency,
        array $data = []
    )
    {
        $this->_foxSeoHelper = $foxSeoHelper;
        $this->_coreRegistry = $registry;
        $this->_bundlePrice = $bundlePrice;
        $this->_priceCurrency = $priceCurrency;
        parent::__construct($context, $data);
    }

    public function cleanString($string)
    {
        return $this->_foxSeoHelper->cleanString($string);
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

    public function getConfig($configpath)
    {
        return $this->_foxSeoHelper->getConfig($configpath);
    }

    public function getStartingPrice($product)
    {
        if($product->getTypeId() === 'bundle')
        {
            $price = $this->_bundlePrice->getTotalPrices($product, 'min', 1);
        } else {
            $price = $product->getFinalPrice();
        }

        return $this->_priceCurrency->format($price, false);

    }
}