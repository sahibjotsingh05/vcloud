$(document).ready(function () {
  $(".related,.suggested").mouseenter(function () {
    $(this)
      .children(".video")
      .each(function () {
        this.play();
        $(this).addClass("hover");
      });
  });

  $(".related,.suggested").mouseleave(function () {
    $(".hover").each(function () {
      $(this).removeClass("hover");
      this.pause();
      this.currentTime = 10;
    });
  });

  $("video").on("play", function () {
    var vid_id = $(this).attr("id");
    $("video").each(function () {
      if (
        !this.paused &&
        $(this).attr("id") != vid_id &&
        $(this).attr("class") != "performing"
      ) {
        this.pause();
        this.currentTime = 10;
      }
    });
  });

  $(".video").click(function () {
    var performer_id = $(this).attr("id");
    $(".video").each(function () {
      $(this).removeClass(".performing");
      if ($(this).attr("id") != performer_id) {
        $(this).parents(".tile").remove();
      }
    });
    var performer_address = $(this).siblings(".vid_src").text();
    var video_name = $(this).siblings(".vid_name").text();
    $.post(
      "process_actor_sender.php",
      {
        call: true,
        vid_name: video_name,
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

  // FOR FILTERING OUT ANY DUPLICATE VIDEO ENTRY
  for (var i = 0; i < $(".related_video").length; i++) {
    var current_1_id = $(".related_video").eq(i).attr("id");
    var current_1_name = $(".related_video").eq(i).siblings(".name").text();
    for (var j = $(".related_video").length - 1; j > i; j--) {
      var current_2_id = $(".related_video").eq(j).attr("id");

      if (current_1_id == current_2_id) {
        console.log("FOUND AT :-", j, "FOUND FOR :-", current_1_name);
        $(".related_video").eq(j).parent().remove();
      }
    }
  }

  //FOR FETCHING ADDITIONAL INFO OF THE ACTOR/PERFORMER
  var performer_id = $(".performing").attr("id");
  $.post(
    "process_additional_info.php",
    {
      call: true,
      vid_id: performer_id,
    },
    function (data) {
      $(".additional_info").html(data);
      let bookmarkAvailability = document.getElementById("bookmarkAvailability")
        .innerText;
      if (bookmarkAvailability == "TRUE") {
        $.getScript("../js/bookmark.js").done(
          console.log("bookmark.js LOADED")
        );
      } else {
        console.log("bookmark.js NOT LOADED. DEPARTMENT IS NOT SAME");
      }
    }
  );

  //BACKUP IN CASE OF NEW RELATIVES.
  if ($(".relatives").html().length == 0) {
    $.post(
      "process_related_backup.php",
      {
        call: true,
      },
      function (data) {
        $(".relatives").html(data);
        $.getScript("../js/stage.js").done(console.log("stage.js LOADED"));
      }
    );
  }
});
