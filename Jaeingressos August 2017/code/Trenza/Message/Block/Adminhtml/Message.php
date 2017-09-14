<?php
namespace Trenza\Message\Block\Adminhtml;

class Message extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_message';
        $this->_blockGroup = 'Trenza_Message';
        $this->_headerText = __('Message');
        /*
        $this->_addButtonLabel = __('Add New Message');
        parent::_construct();
        if ($this->_isAllowedAction('Trenza_Message::save')) {
            $this->buttonList->update('add', 'label', __('Add New Message'));
        } else {
            $this->buttonList->remove('add');
        }
        */
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
