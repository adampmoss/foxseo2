<?php

namespace Fox\Seo\Block\Adminhtml;

class Checklist extends \Magento\Backend\Block\Template
{

    /**
     * @param $configpath
     * @param $success
     * @param $message
     * @param string $method
     * @return string
     */
    public function check($configpath, $success, $message, $method = 'equal_to')
    {
        $website = $this->getRequest()->getParam('website');
        $store = $this->getRequest()->getParam('store');

       if ($website)
       {
           $configvalue = $this->_scopeConfig->getValue($configpath, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE, $website);
       }

        elseif ($store)
        {
            $configvalue = $this->_scopeConfig->getValue($configpath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
        }

        else {
            $configvalue = $this->_scopeConfig->getValue($configpath);
        }


        if ($this->$method($configvalue, $success))
        {
            return $this->answer($message.__(' is correctly configured'), 'success');
        }

        $section = explode("/", $configpath);

        return $this->answer($message.__(' is not correctly configured - ').'<a target="_blank" href="'.$this->getUrl
            ('adminhtml/system_config/edit/section/'.reset($section))
            .'">'.__('Update Settings').'</a>',
            'error');
    }

    /**
     * @param $message
     * @param $type
     * @return string
     */
    public function answer($message, $type)
    {
        return '<div class="message message-'.$type.'">'.$message.'</div>';
    }

    /**
     * @param $config
     * @param $success
     * @return bool
     */
    public function equal_to($config, $success)
    {
        return $config === $success;
    }

    /**
     * @param $config
     * @param $success
     * @return bool
     */
    public function not_equal_to($config, $success)
    {
        return $config !== $success;
    }

}