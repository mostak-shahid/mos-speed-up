jQuery(document).ready(function($) {
    $(window).load(function(){
      $('.mos-speed-up-wrapper .tab-con').hide();
      $('.mos-speed-up-wrapper .tab-con.active').show();
    });

    $('.mos-speed-up-wrapper .tab-nav > a').click(function(event) {
      event.preventDefault();
      var id = $(this).data('id');

      set_mos_speed_up_cookie('speed_up_active_tab',id,1);
      $('#mos-speed-up-'+id).addClass('active').show();
      $('#mos-speed-up-'+id).siblings('div').removeClass('active').hide();

      $(this).closest('.tab-nav').addClass('active');
      $(this).closest('.tab-nav').siblings().removeClass('active');
    });
});
