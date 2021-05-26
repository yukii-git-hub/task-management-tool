$(function() {

  /////////////////////////////////////////////// ajax 
  let now; //タイムスタンプ取得

	$.getJSON('/ajax_currenttime')
	  .done(function(json){
		  for(let i in json){
		    now = json[i] * 1000;
      }
	  })
	  .fail(function(){
	    console.log('php_currenttime/json_error');
	  });

  /////////////////////////////////////////////// timer
  function realtimer () {
      const realDay = document.getElementById("realday"); //日付け
      const realTime = document.getElementById('realtime'); //時間

    function timer () {
      let timeNow = new Date(now);
      let yearNow = timeNow.getFullYear();
      let monthNow = timeNow.getMonth()+1;
      let dayNow = timeNow.getDate();
      let weekNow = timeNow.getDay();
      let WeekDays = ["日","月","火","水","木","金","土"]
      let hoursNow = String(timeNow.getHours()).padStart(2, "0");
      let minitesNow = String(timeNow.getMinutes()).padStart(2, "0");
      let secondNow = String(timeNow.getSeconds()).padStart(2, "0");
      let day = `${yearNow}/${monthNow}/${dayNow}/${WeekDays[weekNow]}`;
      let time = `${hoursNow} : ${minitesNow} : ${secondNow}`;
      realDay.innerHTML = day;
      realTime.innerHTML = time;
      now += 1000;
    }

    setInterval (() => {
      timer();
    }, 1000);
  }
  realtimer();

});