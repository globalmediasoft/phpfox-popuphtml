<?php
defined('PHPFOX') or exit('NO DICE!');
class Popuplink_Component_Controller_Index extends Phpfox_Component
{
	public function process()
	{
        $this->template()->setTemplate('blank');
		$iId = $this->request()->get('req2');
        if($iId <=0)
        {
            return false;
        }
        $aPopup = phpfox::getService('popuplink')->getPopupById($iId);
        if(!isset($aPopup['id']))
        {
            return false;
        }
        $aPopup['type_data'] = html_entity_decode($aPopup['type_data']);
        if($aPopup['type_id'] == "ads")
        {
            $aPopup['type_data'] = str_replace("<br>","",$aPopup['type_data']);
            $aPopup['type_data'] = str_replace("<br/>","",$aPopup['type_data']);    
        }
        
        $this->template()->assign(array(
            'aPopup' => $aPopup,
        ));
	}
	
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('popuplink.component_controller_index')) ? eval($sPlugin) : false);
	}
}

?>