<?php
defined('PHPFOX') or exit('NO DICE!');
class Popuplink_Component_Controller_Admincp_Index extends Phpfox_Component
{
	public function process()
	{
        if($iDelete = $this->request()->get('delete'))
        {
            if(phpfox::getService('popuplink')->deletePopup($iDelete))
            {
                $this->url()->send('admincp.popuplink',null,Phpfox::getPhrase('popuplink.delete_popup_successfully'));
            }
        }
        $this->template()->setTitle(Phpfox::getPhrase('popuplink.manage_popup_links'))
            ->setBreadcrumb(Phpfox::getPhrase('popuplink.manage_popup_links'))
            ->assign(array(
                    'aPopups' => phpfox::getService('popuplink')->getForAdminCP(),
                )
            );
	}
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('popuplink.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}

?>
