<?php

namespace Fox\Seo\Block {

    class Template extends \Magento\Framework\View\Element\Template
    {
        /**
         * @var \Fox\Seo\Helper\Data
         */
        protected $_foxSeoHelper;

        /**
         * @param \Magento\Framework\View\Element\Template\Context $context
         * @param \Fox\Seo\Helper\Data $foxSeoHelper
         * @param array $data
         */
        public function __construct(
            \Magento\Framework\View\Element\Template\Context $context,
            \Fox\Seo\Helper\Data $foxSeoHelper,
            array $data = []
        )
        {
            $this->_foxSeoHelper = $foxSeoHelper;
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
    }
}