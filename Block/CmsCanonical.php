<?php

namespace Fox\Seo\Block;

class CmsCanonical extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Url
     */
    protected $_url;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Url $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Url $url,
        array $data = []
    )
    {
        $this->_url = $url;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed|string
     */
    public function getCanonicalUrl()
    {
        $currentUrl = $this->_url->getCurrentUrl();
        $url = $this->_url->getRebuiltUrl($currentUrl);

        if ($this->_scopeConfig->getValue('web/seo/use_rewrites',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE))
        {
            $url = str_replace("/index.php", "", $url);
        }

       return $url;
    }
}