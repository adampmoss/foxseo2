<?php

namespace Fox\Seo\Model\Source;

class Robots extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => 'Use Config Settings'],
                ['value' => 'INDEX,FOLLOW', 'label' => 'INDEX, FOLLOW'],
                ['value' => 'NOINDEX,FOLLOW', 'label' => 'NOINDEX, FOLLOW'],
                ['value' => 'INDEX,NOFOLLOW', 'label' => 'INDEX, NOFOLLOW'],
                ['value' => 'NOINDEX,NOFOLLOW', 'label' => 'NOINDEX, NOFOLLOW']
            ];
        }
        return $this->_options;
    }
}