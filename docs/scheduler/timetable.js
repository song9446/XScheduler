var createTimeTable = function (container, year, month, date, g_id) {
    // get schedules on date
    function render(){
        var schedules = null;
        if(g_id == null)
            schedules = xmlRequestJson(
                'GET', 
                {"op": "get_schedule_in_range",
                    "start_time": dateFormat(year, month, date, 0, 0, 0),
                    "end_time": dateFormat(year, month, date+1, 0, 0, 0),
                },
                'schedule.php'
            );
        else
            schedules = xmlRequestJson(
                'GET', 
                {"op": "get_group_schedule_in_range",
                    "g_id": g_id,
                    "start_time": dateFormat(year, month, 1),
                    "end_time": dateFormat(year, month+1, 1)},
                'schedule.php'
            );
        var d_min = 60,
            n_date = 60*24/d_min,
            current_min = 0;

        // draw background table with schedules
        var canv = document.createElement("canvas");
        var table_canv = document.createElement("canvas");
        var width = canv.width = table_canv.width = 300,
            height = canv.height = table_canv.height = 1800;
        container.appendChild(canv);
        var top_margin = 50.5;
        var bottom_margin = 30;
        var height = height-top_margin-bottom_margin;
        var table_ctx = table_canv.getContext("2d");
        table_ctx.textBaseline="middle"; 
        table_ctx.textAlign="center";
        table_ctx.font = table_ctx.font.replace(/\d+px/, "20px");
        table_ctx.fillText(year + "-" + month + "-" + date, width*0.5, top_margin*0.4);
        table_ctx.font = table_ctx.font.replace(/\d+px/, "10px");
        table_ctx.textBaseline="middle"; 
        table_ctx.textAlign="center";
        for(var i=0; i<n_date+1; i++){
            table_ctx.beginPath();
            var h = height/n_date*i+top_margin;
            table_ctx.fillText(_to_time_string(Math.floor(current_min/60), current_min%60), width*0.5, h);
            table_ctx.moveTo(0, h);
            table_ctx.lineTo(width*0.5-20, h);
            table_ctx.moveTo(width*0.5+20, h);
            table_ctx.lineTo(width, h);
            table_ctx.stroke();
            current_min += d_min;
        }
        var first_date = new Date(year, month-1, date), 
            d_time = new Date(year, month-1, date+1) - first_date;
        for(var i=0, l=schedules.length; i<l; i++){
            var schedule = schedules[i];
            schedule.start_date = new Date(timeString(schedule.start_time));
            schedule.end_date = new Date(timeString(schedule.end_time));
            schedule.fillColor = genRandomColor(schedule.s_name, 0.5);
            schedule.strokeColor = genRandomColor(schedule.s_name, 1.0);
            table_ctx.fillStyle = schedule.fillColor;
            table_ctx.strokeStyle = schedule.strokeColor;
            schedule.y_start = (schedule.start_date - first_date)/d_time * height + top_margin; 
            schedule.y_end = (schedule.end_date - first_date)/d_time * height + top_margin;
            console.log(schedule);
            table_ctx.fillRect(0, schedule.y_start,
                width, schedule.y_end-schedule.y_start);
            table_ctx.strokeRect(0, schedule.y_start,
                width, schedule.y_end-schedule.y_start);
            table_ctx.fillStyle = "rgba(0, 0, 0, 1)";
            table_ctx.textBaseline="middle"; 
            table_ctx.textAlign="center";
            table_ctx.font = table_ctx.font.replace(/\d+px/, "10px");
            table_ctx.fillText(_to_time_string(schedule.start_date.getHours(), schedule.start_date.getMinutes()), width*0.5, (schedule.start_date - first_date)/d_time * height + top_margin);
            table_ctx.fillText(_to_time_string(schedule.end_date.getHours(), schedule.end_date.getMinutes()), width*0.5, (schedule.end_date - first_date)/d_time * height + top_margin);
            table_ctx.textBaseline="top"; 
            table_ctx.textAlign="left";
            table_ctx.font = table_ctx.font.replace(/\d+px/, "15px");
            table_ctx.fillText(" - " + schedule.s_name, 3, (schedule.start_date - first_date)/d_time * height + top_margin);
        }
        var ctx = canv.getContext("2d");
        ctx.drawImage(table_canv, 0, 0);



        // draw helper line on screen
        var helperline = {
            time: 0,
            y: 0,
        };
        var drawhelperline = null;
        ctx.font = table_ctx.font.replace(/\d+px/, "10px");
        ctx.textBaseline="middle"; 
        ctx.textAlign="left";

        canv.onmousemove = function (evt) {
            var time = Math.floor(60*24*(evt.offsetY+0.5 - top_margin)/height);
            helperline.y = evt.offsetY-0.5;
            helperline.time = _to_time_string(Math.floor(time/60), time%60)
            if(drawhelperline == null)
                drawhelperline = setInterval(function () {
                    ctx.clearRect(0, 0, width, height+top_margin+bottom_margin);
                    ctx.drawImage(table_canv, 0, 0);
                    ctx.fillText(helperline.time, 5, helperline.y);
                    ctx.beginPath();
                    ctx.lineWidth = 1;
                    ctx.moveTo(0, helperline.y);
                    ctx.lineTo(3, helperline.y);
                    ctx.moveTo(30, helperline.y);
                    ctx.lineTo(width, helperline.y);
                    ctx.stroke();
                }, 1000/30);
        };
        canv.onmouseout = function (evt) {
            clearInterval(drawhelperline);
            drawhelperline = null;
            ctx.clearRect(0, 0, width, height+top_margin+bottom_margin);
            ctx.drawImage(table_canv, 0, 0);
        };

        // add / delete helper

        // draw highlight
        var highlight = null;
        canv.onclick = function (evt) {
            for(var i=0, l=schedules.length; i<l; i++){
                var schedule = schedules[i];
                if(evt.offsetY >= schedule.y_start && evt.offsetY <= schedule.y_end){
                    if(highlight != null){
                        table_ctx.strokeStyle = highlight.strokeColor;
                        table_ctx.fillStyle = highlight.fillColor;
                        table_ctx.strokeRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                            width, (highlight.end_date - first_date)/d_time * height + top_margin);
                        table_ctx.fillRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                            width, (highlight.end_date - first_date)/d_time * height + top_margin);
                    }
                    if(highlight == schedule){
                        i = l;
                        break;
                    }
                    highlight = schedule;
                    table_ctx.strokeStyle = "#ff0000";
                    table_ctx.fillStyle = "#ff0000";
                    table_ctx.strokeRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                        width, (highlight.end_date - first_date)/d_time * height + top_margin);
                    table_ctx.fillRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                        width, (highlight.end_date - first_date)/d_time * height + top_margin);
                    break;
                }
            }
            if(i == l && highlight != null){ 
                table_ctx.strokeStyle = highlight.strokeColor;
                table_ctx.fillStyle = highlight.fillColor;
                table_ctx.strokeRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                    width, (highlight.end_date - first_date)/d_time * height + top_margin);
                table_ctx.fillRect(0, (highlight.start_date - first_date)/d_time * height + top_margin, 
                    width, (highlight.end_date - first_date)/d_time * height + top_margin);
                highlight = null;
            }
        }
    }
    render();
    return {
        setDate: function(_date){
            date = _date-0;
            container.removeChild(container.children[0])
            render();
        },
    }
};
var _to_time_string = function (hour, min) {
    if(hour<10)hour = "0" + hour;
    if(min<10)min = "0" + min;
    return "" + hour + ":" + min;
};
function timeString(time) {
    return "".concat(time.substr(0, 4), "-", time.substr(4, 2), "-", time.substr(6, 2), " ", time.substr(8, 2), ":", time.substr(10, 2), ":", time.substr(12, 2));
}
function dateFormat(year, month, date, hour, miniute, second){ 
    hour = hour || 0;
    miniute = miniute || 0;
    second = second || 0;
    if(month < 10)month = "0" + month;
    if(date < 10)date = "0" + date;
    if(hour < 10)hour = "0" + hour;
    if(miniute < 10)miniute = "0" + miniute;
    if(second < 10)second = "0" + second;
    return "" + year + month + date + hour + miniute + second; 
}

