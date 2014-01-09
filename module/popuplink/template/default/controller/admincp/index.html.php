<?php 

defined('PHPFOX') or exit('NO DICE!'); 

?>
<div class="table_header">
   {phrase var='popuplink.manage_popup_links'}
</div>
{if count($aPopups)}
<table id="js_drag_drop" cellpadding="0" cellspacing="0">
    <tr>

        <th style="width:20px;"></th>
        <th>{phrase var='popuplink.name'}</th>
        <th>{phrase var='popuplink.display_in'}</th>
        <th>{phrase var='popuplink.content_type'}</th>
        <th class="t_center" style="width:60px;">{phrase var='popuplink.active'}</th>    
    </tr>
    {foreach from=$aPopups key=iKey item=aPopup}
    <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
        <td class="t_center">
            <a href="#" class="js_drop_down_link" title="Manage">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
            <div class="link_menu">
                <ul>
                    <li><a href="{url link='admincp.popuplink.add' id=$aPopup.id}">{phrase var='core.edit'}</a></li>        
                    <li><a href="{url link='admincp.popuplink' delete=$aPopup.id}" onclick="return confirm('{phrase var='core.are_you_sure'}');">{phrase var='core.delete'}</a></li>        
                </ul>
            </div>        
        </td>    
        <td>{$aPopup.name|clean}</td>
        <td>{$aPopup.display_in|clean} - <strong>{$aPopup.display_data}<strong></td>
        <td>{$aPopup.type_id}</td>
        <td class="t_center">
            <div class="js_item_is_active"{if !$aPopup.is_active} style="display:none;"{/if}>
                <a href="#?call=popuplink.updateActivity&amp;id={$aPopup.id}&amp;active=0" class="js_item_active_link" title="{phrase var='popuplink.deactivate'}">{img theme='misc/bullet_green.png' alt=''}</a>
            </div>
            <div class="js_item_is_not_active"{if $aPopup.is_active} style="display:none;"{/if}>
                <a href="#?call=popuplink.updateActivity&amp;id={$aPopup.id}&amp;active=1" class="js_item_active_link" title="{phrase var='popuplink.activate'}">{img theme='misc/bullet_red.png' alt=''}</a>
            </div>        
        </td>        
    </tr>
    {/foreach}
</table>
{else}
    <div class="error_message">{phrase var='popuplink.there_are_no_popup_content_added'}</div>
{/if}