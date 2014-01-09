<?php
defined('PHPFOX') or exit('NO DICE!');
class Popuplink_Component_Controller_AdminCP_Add extends Phpfox_Component
{
	public function process()
	{
		$bIsEdit = false;
        $sCategoryId = "0";  
        $aValidation = array(
            
            /*'description' => array(
                    'def' => 'required',
                    'title' => Phpfox::getPhrase('location.add_description_for_location')
            )*/
            'type_id' => array(
                'def' => 'required',
                'title' => Phpfox::getPhrase('popuplink.please_select_type_of_popup')
            ),
            'name' => array(
                    'def' => 'required',
                    'title' => Phpfox::getPhrase('popuplink.fill_the_name_of_popup')
                ),
        );
        $oValid = Phpfox::getLib('validator')->set(array(
                'sFormName' => 'core_js_popuplink_form', 
                'aParams' => $aValidation
        ));
        if ($iEditId = $this->request()->getInt('id'))
        {
            if ($aPopupLink = Phpfox::getService('popuplink')->getForEdit($iEditId))
            {
                $bIsEdit = true;
                $sCategoryId = $aPopupLink['type_id'];
                $this->template()->assign('aForms', $aPopupLink);
                $this->template()->assign('aLocation', $aPopupLink);
            }
        } 
        if ($aVals = $this->request()->getArray('val'))
        {
            $sCategoryId = $aVals['type_id'];
            if(phpfox_error::isPassed())
            {
                
                if(!$bIsEdit)
                {
                    if($iId = phpfox::getService('popuplink')->addPopup($aVals,$_POST))
                    {
                        $this->url()->send('admincp.popuplink.add',array('id' => $iId),Phpfox::getPhrase('popuplink.add_new_popup_successfully'));
                    }    
                }
                else
                {
                    if(phpfox::getService('popuplink')->updatePopup($iEditId,$aVals,$_POST))
                    {
                        $this->url()->send('admincp.popuplink.add',array('id' => $iEditId),Phpfox::getPhrase('popuplink.update_popup_successfully'));
                    }
                }
                
            }
        }  
        $this->template()->setTitle(($bIsEdit ? Phpfox::getPhrase('popuplink.edit_the_popup'): Phpfox::getPhrase('popuplink.create_new_popup')))
            ->setHeader(array(
                'jquery.cleditor.min.js' => 'module_popuplink',
                'jquery.cleditor.css' => 'module_popuplink',
                'popuplink.js' => 'module_popuplink'
            ))
            ->setBreadcrumb(($bIsEdit ? Phpfox::getPhrase('popuplink.edit_the_popup') : Phpfox::getPhrase('popuplink.create_new_popup')), $this->url()->makeUrl('admincp.add'))
            ->assign(array(
                    'bIsEdit' => $bIsEdit,
                    'sCoreUrl' => phpfox::getParam('core.path'),
                    'aVals' => $aVals,
                    'sCategoryId' => $sCategoryId,
                    'sCreateJs' => $oValid->createJS(),
                    'sGetJsForm' => $oValid->getJsForm(),
                    'aControllers' => Phpfox::getService('admincp.component')->get(true),
                )
            )
            ;   
	}
	
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('popuplink.component_controller_admincp_add')) ? eval($sPlugin) : false);
	}
}

?>