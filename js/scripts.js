$(document).ready(function(){
  var visibleItems = $("#FAN_Visible").html();
  var liCount = $(".vicker-ul").children().length;

  var dd = $(".vticker").easyTicker({
    direction: "down",
    easing: "jswing",
    speed: "slow",
    interval: 2500,
    height: "auto",
    visible: visibleItems,
    mousePause: 1,
    controls: {
      up: ".btnUp",
      down: ".btnDown",
      toggle: ".btnToggle"
      //stopText: "Stop !!!"
    }/**/
  }).data("easyTicker");

  if(liCount <= visibleItems) {
    dd.stop();
  }

  $(".vis").click(function(){
    dd.options["visible"] = 3;
  });

  $(".btnStop").click(function(){
    dd.stop();
  });

  $(".btnStart").click(function(){
    dd.start();
  });
});

// functions go here


