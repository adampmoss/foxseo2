<?php

namespace Fox\Seo\Block\StructuredData;

class Organization extends \Fox\Seo\Block\Template
{
    /**
     * Retrieve logo image URL
     *
     * @return string
     */
    public function getLogoUrl()
    {
        $folderName = \Magento\Config\Model\Config\Backend\Image\Logo::UPLOAD_DIR;
        $storeLogoPath = $this->_scopeConfig->getValue(
            'design/header/logo_src',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $path = $folderName . '/' . $storeLogoPath;
        $logoUrl = $this->_urlBuilder
                ->getBaseUrl(['_type' => \Magento\Framework\UrlInterface::URL_TYPE_MEDIA]) . $path;

        if ($storeLogoPath !== null && $this->_isFile($path)) {
            $url = $logoUrl;
        } elseif ($this->getLogoFile()) {
            $url = $this->getViewFileUrl($this->getLogoFile());
        } else {
            $url = $this->getViewFileUrl('images/logo.svg');
        }
        return $url;
    }

    /**
     * @return array
     */
    public function getSocialProfiles()
    {
        return array_filter(explode("\n", $this->_foxSeoHelper->getConfig
        ('foxseo/social_sd/social_profiles')));
    }
}