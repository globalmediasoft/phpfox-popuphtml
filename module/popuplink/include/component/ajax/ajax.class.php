<?php
defined('PHPFOX') or exit('NO DICE!');

class Popuplink_Component_Ajax_Ajax extends Phpfox_Ajax
{
    public function updateActivity()
    {
        if (Phpfox::getService('popuplink')->updateActivity($this->get('id'), $this->get('active')))
        {

        }
    }    
    public function show()
    {
        $sController = $this->get('controller');
        $sUrl = $this->get('url');
        phpfox::getBlock('popuplink.view',array(
            'sController' => $sController,
            'sUrl' => $sUrl,
        ));
        $this->append('body',$this->getContent(false));
    }
    
}

?>