<?php

namespace Fox\Seo\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @param $configpath
     * @return mixed
     */
    public function getConfig($configpath)
    {
        return $this->scopeConfig->getValue(
            $configpath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param $string
     * @return string
     */
    public function cleanString($string)
    {
        return strip_tags(addcslashes($string, '"\\/'));
    }

    /**
     * @param $string
     * @param $object
     * @return mixed
     */
    public function shortcode($string, $object)
    {
        preg_match_all("/\[(.*?)\]/", $string, $matches);

        for($i = 0; $i < count($matches[1]); $i++)
        {
            $tag = $matches[1][$i];

            if ($tag === "store")
            {
                $string = str_replace($matches[0][$i], $this->getConfig('general/store_information/name'), $string);
            } else {

                if (!empty($object->getTypeId())) // checks if model in question is a product
                {
                    $attribute = $object->getResource()->getAttribute($tag)->getFrontend()->getValue($object);
                } else {
                    $attribute = $object->getData($tag);
                }

                $string = str_replace($matches[0][$i], $attribute, $string);
            }
        }

        return $string;
    }

    /**
     * @param $object
     * @param $type
     */
    public function checkMetaData($object, $type)
    {
        // Check if object has a no title set, and that default fallbacks are enabled
        if (empty($object->getMetaTitle()) && $this->getConfig('foxseo/metadata/'.$type.'_title_enabled'))
        {
            $metatitle = $this->shortcode($this->getConfig('foxseo/metadata/'.$type.'_title'), $object);
            $object->setMetaTitle($metatitle);
        }

        // Check if object has a no meta description set, and that default fallbacks are enabled
        if (empty($object->getMetaDescription()) && $this->getConfig('foxseo/metadata/'.$type.'_metadesc_enabled'))
        {
            $metadesc = $this->shortcode($this->getConfig('foxseo/metadata/'.$type.'_metadesc'), $object);
            $object->setMetaDescription($metadesc);
        }
    }
}