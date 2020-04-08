jQuery(document).ready(function($){   
    
    var radioValue = $("input[name='mobile_sticky_buttons_settings[mobile_sticky_buttons_general_bg-color]']:checked").val();
    
    if(radioValue == 0){
        $('#mobile_sticky_buttons_general_bg-sl-color').closest('tr').show();
        $('#mobile_sticky_buttons_general_bg-gd-color1').closest('tr').hide();
        $('#mobile_sticky_buttons_general_bg-gd-color2').closest('tr').hide();
    } else {
        $('#mobile_sticky_buttons_general_bg-sl-color').closest('tr').hide();
        $('#mobile_sticky_buttons_general_bg-gd-color1').closest('tr').show();
        $('#mobile_sticky_buttons_general_bg-gd-color2').closest('tr').show();
    } 
   
    $('input:radio[name="mobile_sticky_buttons_settings[mobile_sticky_buttons_general_bg-color]"]').change(function() {
        if ($(this).val() == '0') {
            $('#mobile_sticky_buttons_general_bg-sl-color').closest('tr').show();
            $('#mobile_sticky_buttons_general_bg-gd-color1').closest('tr').hide();
            $('#mobile_sticky_buttons_general_bg-gd-color2').closest('tr').hide();
        } else {
            $('#mobile_sticky_buttons_general_bg-sl-color').closest('tr').hide();
            $('#mobile_sticky_buttons_general_bg-gd-color1').closest('tr').show();
            $('#mobile_sticky_buttons_general_bg-gd-color2').closest('tr').show();
        }
    });  
    
    $(".section-end").closest('tr').addClass('section-line');
          
});