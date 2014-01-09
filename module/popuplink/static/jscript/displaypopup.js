if(typeof (bPopupLoading) == "undefined")
{
    var bPopupLoading = true;
    var bLoadComplete = false;
    $Core.PopupLoading = {
        sController:'',
        sFullUrl:'',
        iExpiredTime:1,
        init:function(){
            this.sController =  oParams['sController'];
            this.sFullUrl = window.location.href;
            var sUrl = this.getCurrentView(this.sController);
            if( sUrl != this.sFullUrl && this.sController !="")
            {   
                $.ajaxCall('popuplink.show','controller='+this.sController+'&url='+encodeURIComponent(this.sFullUrl));
            }
            bLoadComplete = true;
        },
        openOffersDialog:function()
        {
            var sUrl = this.getCurrentView(this.sController);
            if( sUrl != this.sFullUrl && this.sController !="")
            {
                $('#popup_overlay').fadeIn('fast', function() {
                    $('#boxpopup').css('display','block');
                    $('#boxpopup').animate({'left':'30%'},500);
                });    
            }
            
        },
        closeOfferDialog:function(prospectElementID)
        {
            
            $('#' + prospectElementID).css('position','absolute');
            $('#' + prospectElementID).animate({'left':'-100%'}, 500, function() {
                $('#' + prospectElementID).css('position','fixed');
                $('#' + prospectElementID).css('left','100%');
                $('#popup_overlay').fadeOut('fast');
            });
            this.saveCurrentView(this.sController,this.sFullUrl);
               
        },
        saveCurrentView:function(controller,url)
        {
             setCookie('cfc_'+controller,url,this.iExpiredTime);   
        },
        getCurrentView:function(controller)
        {
             return getCookie('cfc_'+controller);
        }
    };
    $Behavior.initPopupLoading = function(){
        if(bLoadComplete == false)
        {
            $Core.PopupLoading.init();    
        }
        
    }
}
