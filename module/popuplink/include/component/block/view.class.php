<?php
defined('PHPFOX') or exit('NO DICE!');
class Popuplink_Component_Block_View extends Phpfox_Component
{
	public function process()
	{
        $sController = $this->getParam('sController');
        $sUrl = $this->getParam('sUrl');
        $aPopup = phpfox::getService('popuplink')->getPopup($sController,$sUrl);
        if(!isset($aPopup['id']))
        {
            return false;
        }
        $this->template()->assign(array(
            'sCoreUrl' => phpfox::getParam('core.path'),
            'aPopup' => $aPopup,
        ));
	}
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('popuplink.component_block_popuplink_clean')) ? eval($sPlugin) : false);
	}
}

?>