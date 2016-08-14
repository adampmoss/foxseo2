<?php

namespace Fox\Seo\Controller\Adminhtml\Checklist;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Check if user has enough privileges
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Fox_Seo::checklist');
    }

    /**
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();

        $this->_setActiveMenu('Fox_Seo::checklist');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('FoxSEO Checklist'));

        $this->_addBreadcrumb(__('Stores'), __('Stores'));
        $this->_addBreadcrumb(__('FoxSEO Checklist'), __('FoxSEO Checklist'));

        $this->_view->renderLayout();
    }
}
