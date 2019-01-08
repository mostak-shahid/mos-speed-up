jQuery(document).ready(function($) {
  $(window).load(function(){
    $('.mos-speed-up-wrapper .acc-group .acc-collapse').hide();
    $('.mos-speed-up-wrapper .acc-group .active .acc-collapse').show();
  });

  $('.acc-group .acc-heading .acc-title a').click(function(event) {
    event.preventDefault();
    var id = $(this).data('id');
    //alert(id);
    set_mos_speed_up_cookie('speed_up_active_tab',id,1);
    $('#mos-speed-up-'+id).addClass('active');
    $(this).closest('.acc-heading').siblings('.acc-collapse').show();

    $('#mos-speed-up-'+id).siblings('div').removeClass('active');
    $('#mos-speed-up-'+id).siblings('div').find('.acc-collapse').hide();

  });
});
