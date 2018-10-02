var second = 60;
var timer;

function autoReload(callback)
{
  $('.auto-reload .pieChart').easyPieChart({
    animate: 500,
    lineWidth: 3,
    barColor: "#E86B94",
    scaleColor: false,
    size: 35,
  });

  timer = setInterval(function(){
    timerAnimation(function(msg){
      callback(msg);
    });
  }, 1000);

  $(".auto-reload #autoRefresh").on('switchChange.bootstrapSwitch', function (event, state) {
    var state = $(this).bootstrapSwitch('state');

    if (state == false)
    {
      clearInterval(timer);
    }
    else
    {
      timer = setInterval(function(){
        timerAnimation(function(msg){
          callback(msg);
        });
      }, 1000);
    }
  });
}

function timerAnimation(callback) {
  var time = 60 - second;
  var rate = Math.round((100 * time) / 60);
  $('.auto-reload .pieChart').data('easyPieChart').update(rate);

  if (second < 1)
  {
    clearInterval(timer);
    callback(1);
  }
  else
  {
    $(".auto-reload .pieChart .timer").html(second);
    second--;
  }
}