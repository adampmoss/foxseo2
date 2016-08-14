<?php

namespace Fox\Seo\Model\Source;

class BadgePositions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'BOTTOM_RIGHT', 'label' => __('Bottom Right (Default)')],
            ['value' => 'BOTTOM_LEFT', 'label' => __('Bottom Left')],
            ['value' => 'USER_DEFINED', 'label' => __('User Defined')]
        ];
    }
}
