<?php
defined('PHPFOX') or exit('NO DICE!');

class Popuplink_Service_popuplink extends Phpfox_Service 
{
    
    public function __construct()
    {
        $this->_sTable = phpfox::getT('popup_link');
    }
    public function getModulesAdminCP()
    {
        $aModules = $this->database()->select('*')
                    ->from($this->_sTable,'m')
                    ->execute('getRows');
        return $aModules;
    }
    public function updateActivity($iId, $iType)
    {
        Phpfox::isUser(true);
        Phpfox::getUserParam('admincp.has_admin_access', true);        
        $bResult = $this->database()->update($this->_sTable, array('is_active' => (int) ($iType == '1' ? 1 : 0)),'id = ' . (int) $iId);
        $this->cache()->remove('popuplink','substr');
        return $bResult;      
    }    
    public function updatePopup($iPopupId = 0,$aVals = array(),$aPost)
    {
        $sDisplayData = "";
        if(isset($aVals['display_in']))
        {
            $sDisplayData = isset($aPost['display_'.$aVals['display_in']])?$aPost['display_'.$aVals['display_in']]:"";
        }
        $sTypeData = "";
        if(isset($aVals['type_id']))
        {
            if($aVals['type_id'] == "ads")
            {
                $sTypeData = isset($aPost['content_html'])?$aPost['content_html']:"";
            }
            else
            {
                $sTypeData = isset($aPost['content_'.$aVals['type_id']])?$aPost['content_'.$aVals['type_id']]:"";    
            }
        }
        $aUpdate = array(
            'name' => isset($aVals['name'])?$aVals['name']:"",
            'is_active' => isset($aVals['is_active'])?$aVals['is_active']:0,
            'display_in' => isset($aVals['display_in'])?$aVals['display_in']:"",
            'display_data' => $sDisplayData,
            'type_id' => isset($aVals['type_id'])?$aVals['type_id']:"",
            'type_data' => $sTypeData,
            
        );
        if(isset($aVals['type_id']) && $aVals['type_id'] == "ads")
        {
            $aUpdate['description'] = phpfox::permalink('popuplink',$iPopupId);
        }
        $bUpdate = $this->database()->update($this->_sTable,$aUpdate,'id = '.(int)$iPopupId);
        $this->cache()->remove('popuplink','substr');  
        return $bUpdate;
    }
    public function addPopup($aVals = array(),$aPost)
    {
        $sDisplayData = "";
        if(isset($aVals['display_in']))
        {
            $sDisplayData = isset($aPost['display_'.$aVals['display_in']])?$aPost['display_'.$aVals['display_in']]:"";
        }
        $sTypeData = "";
        if(isset($aVals['type_id']))
        {
            if($aVals['type_id'] == "ads")
            {
                $sTypeData = isset($aPost['content_html'])?$aPost['content_html']:"";
            }
            else
            {
                $sTypeData = isset($aPost['content_'.$aVals['type_id']])?$aPost['content_'.$aVals['type_id']]:"";    
            }
        }
        $aInsert = array(
            'name' => isset($aVals['name'])?$aVals['name']:"",
            'is_active' => isset($aVals['is_active'])?$aVals['is_active']:0,
            'display_in' => isset($aVals['display_in'])?$aVals['display_in']:"",
            'display_data' => $sDisplayData,
            'type_id' => isset($aVals['type_id'])?$aVals['type_id']:"",
            'type_data' => $sTypeData,
            
        );
        $iId = $this->database()->insert($this->_sTable,$aInsert);
        if(isset($aVals['type_id']) && $aVals['type_id'] == "ads")
        {
            $aUpdate['description'] = phpfox::permalink('popuplink',$iId);
            $this->database()->update($this->_sTable,$aUpdate,'id = '.(int)$iId);
        }
        return $iId;
        
    }
    public function getForEdit($iId)
    {
        return $this->database()->select("*")
                    ->from($this->_sTable)
                    ->where('id = '.(int)$iId)
                    ->execute('getSlaveRow');
    }
    public function getForAdminCP()
    {
        return $this->database()->select("*")
                    ->from($this->_sTable)
                    ->execute('getSlaveRows');
    }
    public function deletePopup($iId)
    {
        return $this->database()->delete($this->_sTable,'id = '.(int)$iId);
    }
    public function showPopupLink()
    {
        echo '<script src="'.phpfox::getParam('core.path').'module/popuplink/static/jscript/displaypopup.js"></script>';
        return false;
    }
    public function getPopup($sController = "", $sUrl ="")
    {
        $aRow = $this->database()->select('*')
                ->from($this->_sTable)
                ->where('display_data = "'.$this->database()->escape($sUrl).'" AND is_active = 1')
                ->execute('getRow');
        if(isset($aRow['id']))
        {
            return $aRow;
        }
        $aRow = $this->database()->select('*')
                ->from($this->_sTable)
                ->where('display_data = "'.$this->database()->escape($sController).'" AND is_active = 1')
                ->execute('getRow');
        if(isset($aRow['id']))
        {
            return $aRow;
        }
        return false;
    }
    public function getPopupById($iPopupId = 0)
    {
        $aRow = $this->database()->select('*')
                ->from($this->_sTable)
                ->where('id = '.(int)$iPopupId.' AND is_active = 1')
                ->execute('getRow');
        if(isset($aRow['id']))
        {
            return $aRow;
        }
        return false;
    }
    public function __call($sMethod, $aArguments)
    {
        if ($sPlugin = Phpfox_Plugin::get('popuplink.service_process__call'))
        {
            return eval($sPlugin);
        }
        Phpfox_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }    
}

?>

