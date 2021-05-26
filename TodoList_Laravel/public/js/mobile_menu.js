$(function() {



  // メニューを開く
  $("#mobile_button").click(function() {

    $.when(
      $("#mobile_menu").addClass("mobile-menu-open"),
      $("body").addClass("scroll-prevent"),
    ).done(function() {
      setTimeout(() => {
        $(".mobile-menu-wapper li").fadeIn(30);

        setTimeout(() => {
          $("#mobile-no-1").addClass("mobile-menu-wapper-li-move1");
        }, 30);

        setTimeout(() => {
          $("#mobile-no-2").addClass("mobile-menu-wapper-li-move2");
        }, 500);

        setTimeout(() => {
          $("#mobile-no-3").addClass("mobile-menu-wapper-li-move3");
        }, 900);

      }, 300);
    });

  });

  // メニューを閉じる
  $("#mobile-menu-hide").click(function() {

    $.when(
      $("#mobile-no-1").removeClass("mobile-menu-wapper-li-move1"),
      $("#mobile-no-2").removeClass("mobile-menu-wapper-li-move2"),
      $("#mobile-no-3").removeClass("mobile-menu-wapper-li-move3"),
      $(".mobile-menu-wapper li").fadeOut(380),
    ).done(function() {
      $("#mobile_menu").removeClass("mobile-menu-open");
      $("body").removeClass("scroll-prevent");
    });
    
  });



});





