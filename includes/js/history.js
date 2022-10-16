$(document).ready(function () {
  var infoRecorded = false;
  $(".performing").on("play", function () {
    if (!infoRecorded) {
      var vid_id = $(this).attr("id");
      $("video").each(function () {
        if (!this.paused && $(this).attr("id") != vid_id) {
          this.pause();
        }
      });
      var current_time = Math.ceil(
        parseInt(document.getElementById(vid_id).currentTime)
      );
      var watch_time = 0;

      playinterval = setInterval(function () {
        if (!document.getElementsByClassName("performing").paused) {
          console.log(
            current_time,
            watch_time,
            document.getElementById(vid_id).paused,
            vid_id
          );
          if (watch_time >= 12) {
            $.post(
              "process_history_insert.php",
              {
                call: true,
                vid_id: vid_id,
              },
              function (data, status) {
                if (status) {
                  console.log("Executed", data);
                  infoRecorded = true;
                }
              }
            );
            $.post(
              "process_view_insert.php",
              {
                call: true,
                vid_id: vid_id,
              },
              function (data, status) {
                console.log(data);
                infoRecorded = true;
              }
            );
            clearInterval(playinterval);
          }
          watch_time++;
        }
      }, 1000);
    } else {
      console.log("Already Recorded");
    }
  });

  $(".performing").on("pause", function () {
    clearInterval(playinterval);
    console.log("Paused");
  });
});
