<?php
    class Trenza_Message_Block_Adminhtml_Template_Grid_Renderer_Myrendered extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
    {
        public function render(Varien_Object $row)
        {
           $value = $row->getData('sender_id');
            if($value = $row->getData('sender_id'))
                return getUrl('customer/index/edit',array('id'=>$row->getData('sender_id'))).'">View Customer';
            else
                return false;
        }
    }
?>