$(document).ready(function () {
  $(".video").click(function () {
    var performer_id = $(this).attr("id");
    $(".video").each(function () {
      $(this).removeClass(".performing");
      if ($(this).attr("id") != performer_id) {
        $(this).parents(".tile").remove();
      }
    });
    var performer_address = $(this).siblings(".vid_src").text();
    var performer_name = $(this).siblings(".vid_name").text();

    $.post(
      "process_actor_sender.php",
      {
        call: true,
        vid_name: performer_name,
        vid_id: performer_id,
        vid_src: performer_address,
      },
      function (data, status) {
        $(".stage").html(data);
        $(".stage").css("display", "block");
        let historyAvailability = document.getElementById("historyAvailability")
          .innerText;
        if (historyAvailability == "TRUE") {
          $.getScript("../js/history.js").done(
            console.log("history.js LOADED")
          );
        } else {
          console.log("history.js NOT LOADED. DEPARTMENT IS NOT SAME");
        }
        $.getScript("../js/stage.js").done(console.log("stage.js LOADED"));
      }
    );
  });

  $(".tile").mouseenter(function () {
    $(this)
      .children(".video")
      .each(function () {
        this.play();
        $(this).addClass("hover");
      });
  });
  $(".tile").mouseleave(function () {
    $(".hover").each(function () {
      $(this).removeClass("hover");
      this.pause();
      this.currentTime = 10;
    });
  });
  $("button.pseudo_feature").click(function () {
    var to_show = $(this).attr("value");
    var condition = $(this).attr("id");
    window.location = "content.php?show=" + to_show + "&condition=" + condition;
  });
});
