$Core.PopupLink = {
    changeDisplayIn: function(v)
    {
        $('.admincp_table').hide();
        $('#display_'+v).show();
    },
    changeTypeContent:function(v)
    {
        $('.type_content').hide();
        if(v =="ads")
        {
            v="html";
        }
        $('#content_'+v).show();
        if(v == "html" || v=="ads")
        {
             $('.popup_content').cleditor({width:670});    
        }
    }
    
}