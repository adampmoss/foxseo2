<?php

namespace Fox\Seo\Block\Sitemap;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Fox\Seo\Model\Sitemap\CmsPages;

class Cms extends Template
{
    /**
     * @var CmsPages
     */
    private $cmsPages;

    /**
     * @param Context $context
     * @param CmsPages $cmsPages
     */
    public function __construct(Context $context, CmsPages $cmsPages)
    {
        $this->cmsPages = $cmsPages;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Cms\Api\Data\PageInterface[]
     */
    public function getCmsPages()
    {
        return $this->cmsPages->getCmsPages();
    }
}