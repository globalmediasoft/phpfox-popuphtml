<?php 
defined('PHPFOX') or exit('NO DICE!'); 

?>
{literal}
    <style type="text/css">
        .table_left
        {
            width:90px;
        }
        .table_right {
            margin-left: 100px;
        }
        .cleditorToolbar {background: url('{/literal}{$sCoreUrl}{literal}module/popuplink/static/image/toolbar.gif') repeat}
        .cleditorButton {float:left; width:24px; height:24px; margin:1px 0 1px 0; background: url('{/literal}{$sCoreUrl}{literal}module/popuplink/static/image/buttons.gif')}

    </style>
{/literal}
{$sCreateJs}
<form method="post" action="{url link='admincp.popuplink.add'}" enctype="multipart/form-data" id="core_js_popuplink_form" onsubmit="{$sGetJsForm}">
{if $bIsEdit}
    <div><input type="hidden" name="id" value="{$aForms.id}" /></div>
{/if}
<div class="table_header">
        {phrase var='popuplink.details'}
    </div>
     <div class="table">
        <div class="table_left">
            {required}{phrase var='popuplink.name'}:
        </div>
        <div class="table_right">
               <input type="text" name="val[name]" size="50" value="{value type='input' id='name'}" id="name"/>
        </div>
        <div class="clear"></div>
    </div>
    <div class="table">
        <div class="table_left">
            {phrase var='popuplink.is_active'}:
        </div>
        <div class="table_right">
            <div class="item_is_active_holder">   
            <span class="js_item_active item_is_active"><input type="radio" name="val[is_active]" value="1" class="v_middle" {value type='radio' id='is_active' default='1' selected='true'}/> {phrase var='core.yes'}</span>
             <span class="js_item_active item_is_not_active"><input type="radio" name="val[is_active]" value="0" class="v_middle" {value type='radio' id='is_active' default='0'}/> {phrase var='core.no'}</span>
            </div>
        </div>
        <div class="clear"></div>
    </div>
   
    <div class="table">
        <div class="table_left">
            {required}{phrase var='popuplink.display_in'}:
        </div>
        <div class="table_right">
            <select name="val[display_in]" id="display_in" onchange="$Core.PopupLink.changeDisplayIn(this.value);">
                <option value="controller" {if $bIsEdit && $aForms.display_in == "controller"}selected{/if}>{phrase var='popuplink.controller'}</option>
                <option value="link" {if $bIsEdit && $aForms.display_in == "link"}selected{/if}>{phrase var='popuplink.special_link'}</option>
            </select>
                <div class="admincp_table" id="display_controller" style="margin-top:10px;{if $bIsEdit && $aForms.display_in == 'link'}display:none;{/if}">
                    <div class="table_right_admincp">
                        <select name="display_controller" id="m_connection">
                        {if !$bIsEdit}
                        <option value="">{phrase var='admincp.select'}:</option>
                        {/if}
                        {foreach from=$aControllers key=sName item=aController}
                            <option value="{$sName}" style="font-weight:bold;" {if $bIsEdit && $aForms.display_data == $sName}selected{/if}>{$sName|translate:'module'}</option>
                            {foreach from=$aController item=aCont}
                                <option value="{$aCont.m_connection}" {if $bIsEdit && $aForms.display_data == $aCont.m_connection}selected{/if}>-- {$aCont.m_connection}</option>
                            {/foreach}            
                        {/foreach}
                        </select>
                        {help var='admincp.block_add_connection'}
                    </div>
                    <div class="clear"></div>
                </div> 
                <div class="admincp_table" id="display_link" style="margin-top:10px;{if $bIsEdit && $aForms.display_in == 'link'}display:block;{else}display:none;{/if};">
                    <input type="text" value="{if $bIsEdit}{$aForms.display_data|clean}{/if}" name="display_link" size="80"/>
                </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="table">
        <div class="table_left">
            {phrase var='popuplink.content_type'}:
        </div>
        <div class="table_right">
            <select name="val[type_id]" id="type_id" onchange="$Core.PopupLink.changeTypeContent(this.value);">
                <option value="html" {if $bIsEdit && $aForms.type_id == "html"}selected{/if}>{phrase var='popuplink.html'}</option>
                <option value="iframe" {if $bIsEdit && $aForms.type_id == "iframe"}selected{/if}>{phrase var='popuplink.iframe'}</option>
                <option value="ads" {if $bIsEdit && $aForms.type_id == "ads"}selected{/if}>{phrase var='popuplink.ads_code'}</option>
            </select>
        </div>
        <div class="clear"></div>
    </div>
    <div class="table type_content" id="content_html" style="{if $bIsEdit && $aForms.type_id == 'iframe'}display:none;{/if}">
        <div class="table_left">
            {phrase var='popuplink.html_content'}:
        </div>
        <div class="table_right">
            <textarea class="popup_content" cols="80" rows="25" name="content_html">{if $bIsEdit}{$aForms.type_data}{/if}</textarea>
        </div>
        <div class="clear"></div>
    </div>
    <div class="table type_content" id="content_iframe" style="{if $bIsEdit && $aForms.type_id == 'iframe'}display:block;{else}display:none;{/if}">
        <div class="table_left">
            {phrase var='popuplink.iframe_link'}:
        </div>
        <div class="table_right">
            <input type="text" value="{if $bIsEdit}{$aForms.type_data|clean}{/if}" name="content_iframe" size="80"/>
        </div>
        <div class="clear"></div>
    </div>
    <div class="table_clear">
        <input type="submit" class="button" value="{if $bIsEdit}{phrase var='popuplink.update'}{else}{phrase var='popuplink.add'}{/if}" name="submit">
    </div>
</form>
<div class="clear p_4"></div>
{if !$bIsEdit || (isset($bIsEdit) && $aForms.type_id == "html" || $aForms.type_id == "ads")}
    <script type="text/javascript">
        $Behavior.initCLeEditor = function()
        {l}
            $('.popup_content').cleditor({l}width:670{r});    
        {r}
    </script>
{/if}
