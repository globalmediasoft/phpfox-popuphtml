<?php 
    defined('PHPFOX') or exit('NO DICE!'); 

?>
{literal}
<style>
.boxpopup {
    background-color: #ffffff;
    color: #888888;
    min-height: 205px;
    max-height:500px;
    left: 100%;
    padding: 0 3px 10px 3px;
    position: fixed;
    right: 30%;
    top: 25%;
    width: 555px;
    z-index: 8001;
    border:5px solid #888888;
    border-radius:10px;
    -moz-border-radius:10px;
    
}

.popup_overlay {
    background: #000000;
    bottom: 0;
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 8000;
    opacity:0.5;
}

a.popupboxclose {
    background: url("{/literal}{$sCoreUrl}{literal}module/popuplink/static/image/close.png") no-repeat scroll left top transparent;
    cursor: pointer;
    float: right;
    height: 26px;
    left: 9px;
    position: relative;
    top: 0;
    width: 16px;
}
#boxpopupcontent
{
    min-height: 205px;
    max-height:436px;
    overflow-y:auto;
    overflow-x:hidden;
    width:100%;
    margin-top:-1px;
    
}
iframe.popupview
{
    overflow-y: auto;
    overflow-x: hidden;
    height:100%;
    width:100%;
    min-height:250px;
    max-height:460px;
}
.boxpopup h3
{
    border-bottom: 1px solid #D8D8D8;
    text-shadow: rgba(255, 255, 255, 0.8) 0px 1px 0px;
    padding: 8px 10px 9px;
    font-size: 16px;
    font-weight: 700 ;
    position:relative;
}
</style>
{/literal}
<div id="popup_wrapper" style="diplay:none;">
    <div id="popup_overlay" class="popup_overlay"></div>
    <div id="boxpopup" class="boxpopup">
        <h3 style="text-align:left; padding-left:5px;">
            <span class="popup_title">{$aPopup.name|clean}</span>
            <a onclick="$Core.PopupLoading.closeOfferDialog('boxpopup');" class="popupboxclose"></a>
        </h3>
        <div id="boxpopupcontent">
            {if $aPopup.type_id == "html"}
                {$aPopup.type_data|parse}
            {/if}
            {if $aPopup.type_id == "iframe"}
                <iframe class="popupview" src="{$aPopup.type_data}" scrolling="no"></iframe>
            {/if}
            {if $aPopup.type_id == "ads"}
                <iframe class="popupview" src="{$aPopup.description}" scrolling="no"></iframe>
            {/if}
        </div>
    </div>
</div>
<script>$Core.PopupLoading.openOffersDialog();</script>
	