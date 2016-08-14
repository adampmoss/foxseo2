<?php

namespace Fox\Seo\Model\Source;

class Discontinued extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('No Redirect (404)'), 'value' => 0],
                ['label' => __('301 Redirect to Category'), 'value' => 1],
                ['label' => __('301 Redirect to Homepage'), 'value' => 2],
                ['label' => __('301 Redirect to Product (Enter SKU)'), 'value' => 3]
            ];
        }
        return $this->_options;
    }
}
