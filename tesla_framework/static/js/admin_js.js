jQuery(document).ready(function($) {
    //Disable submiting with enter key==================================================================================
    $('input').keydown(function(event){
      if($(this).siblings('.upload_image_button').length === 0 && $(this).attr('id') !== 'map_search')
        if(event.keyCode == 13) {
          return false;
        }
      });
    //====================Color Picker===============================================
    $('.my-color-field').wpColorPicker();
    //====================Text Color Picker===============================================
    $('.text_color').wpColorPicker({
            change: function(event, ui){
                var color = $(this).attr('value');
                $(this).parents('.tt_content_box_content').find('.tt_show_logo').css('color',color);
            }
    });
    //====================Font Changer===============================================
    $('.font_changer').on('change',function(){
        var apiUrl = [];
        var font;
        font = $(this).val();
        //==============================================
        $('body').append("<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=" + escape(font) +"' type='text/css' media='all' />");
        $(this).parents('.tt_content_box_content').find('.font_preview').css({'font-family':'"'+ font +'"'});
    }).each(function(endex,element){
        font = $(this).val();
        $('body').append("<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=" + escape(font) +"' type='text/css' media='all' />");
    });
    //--------------------Font Size Changer------------------------------------------
    $('.font_size_changer').on('change',function(){
        var size = $(this).val() + $(this).attr('data-size-unit');
        $(this).parents('.tt_content_box_content').find('.change_font_size').css('font-size',size);
    });
    //====================Image uploader=============================================
    // Uploading files
    var file_frame;
     
    $('.upload_image_button').on('click', function( event ){
        event.preventDefault();
        var button = $(this);
        
        // Create the media frame.
        file_frame = wp.media.frames.file_frame = wp.media({
          title: jQuery( this ).data( 'uploader_title' ),
          button: {
            text: jQuery( this ).data( 'uploader_button_text' ),
          },
          multiple: false  // Set to true to allow multiple files to be selected
        });
     
        // When an image is selected, run a callback.
        file_frame.on( 'select', function() {
          // We set multiple to false so only get one image from the uploader
          attachment = file_frame.state().get('selection').first().toJSON();
     
          // Do something with attachment.id and/or attachment.url here or do console.log(attachment) to get the list
          button.prev('input').attr('value',attachment.url);
          button.parent().find('.tt_show_logo img').attr('src',attachment.url);
        });
     
        // Finally, open the modal
        file_frame.open();
      });
      //---------------REMOVE UPLOADED IMAGE--------------------------------
      $('.remove_img').on('click',function( event ){
              event.preventDefault();
              var def = TT_FW + '/static/images/tesla_logo.png';
              $(this).parents('.tt_content_box_content').find('.tt_show_logo img').attr('src',def).siblings('input[type=text]').attr('value','');
              $(this).siblings('input[type=text]').attr('value','')
          });
      //=================DATEPICEKR========================================
          $( ".datepicker" ).datepicker();
      //=================TT Interact (show/hide elements in admin through other elements) =======================================
          $(".tt_interact").each(function(i,e){
              action = $(this).attr('data-tt-interact-action');
              if (!$(this).is(':checked') && action == 'show'){
                  objs = $.parseJSON($(this).attr('data-tt-interact-objs'));
                  $.each(objs,function(i,e){
                      if (action == 'show'){
                          $('#'+e).hide();
                          $('#'+e).siblings('.tt_explain').hide();
                          $('#'+e).siblings('.tt_option_title').hide();
                      }
                  });
              }
                  
          });
          $(".tt_interact").on('change', function(){
              objs = $.parseJSON($(this).attr('data-tt-interact-objs'));
              action = $(this).attr('data-tt-interact-action');
              $.each(objs,function(i,e){
                  if (action == 'show'){
                      $('#'+e).toggle('fast');
                      $('#'+e).siblings('.tt_explain').toggle('fast');
                      $('#'+e).siblings('.tt_option_title').toggle('fast');
                  }
              });
          });
      //=================Social PLatforms===================================
          $('.tt_share_platform li input').on('keyup',function() {
              if(!$(this).val())
                  $(this).removeClass('social_active');
              else
                  $(this).addClass('social_active');
          });
          //-------------ShareThis------requires select2.min.js library-----
          function format(item) {
              if (!item.id) return item.text; // selected option
              return "<img class='social_icon' src='"+TT_FW+"/static/images/social/" + item.id.toLowerCase() + "_32.png'/> ";
          }
          function format_result(item) {
              if (!item.id) return item.text; // result option
              return "<img class='social_icon2' src='"+TT_FW+"/static/images/social/" + item.id.toLowerCase() + "_32.png'/> " + item.text;
          }
          $(".social_search").select2({
              formatResult: format_result,
              formatSelection: format,
              escapeMarkup: function(m) { return m; }
          });
      //=================SELECT WITH SEARCH=================================
          $('.font_search').select2();  //requires select2.min.js library

//===========================AJAX SAVE OPTIONS======================================================================
  jQuery('.tt_admin form').submit(function() {
      $('.tt_submit').addClass('tt_button_loading').attr('disabled','disabled').attr('value','Saving...');
      this.action.value='save_options' //changing form action that should be the suffix of ajax handle function wp_ajax_$action
      var data = jQuery(this).serialize();console.log(data);
      jQuery.post(ajaxurl, data, function(response) {
        $('.tt_submit').removeClass('tt_button_loading').removeAttr('disabled').attr('value','Save Options');
        if(response == 'options updated' || response == 'options did not change') {
          //show options saved alert----that fades out
          $('.tt_bottom_note').fadeIn('slow');
          var note = setTimeout(function(){
              $('.tt_bottom_note').fadeOut('slow');
          },4000);
        } else {
          console.log('could not update');
        }
      });
      return false;
    });
});
//=================TAB REMEMBER======================================
jQuery(function($) {
  $('a[data-toggle="tab"]').on('shown', function(e){
    //save the latest tab using a cookie:
      jQuery.cookie('last_tab_' + THEME_NAME, $(e.target).attr('href'));
  });
  //activate latest tab, if it exists:
  var lastTab = $.cookie('last_tab_' + THEME_NAME);
  if (lastTab) {
      $('ul.tt_left_menu').children().removeClass('active');
      $('a[href='+ lastTab +']').parents('li:first').addClass('active');
      $('div.tt_content').children().removeClass('active');
      $(lastTab).addClass('active');
  }
});