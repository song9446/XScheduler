/*
    createAction(op, args);
    performAction(action);
    undoAction(action);
    createScheduler(container[, yaer, month, id]);
        container must already be added in document.
        It creates scheduler element inside container lement
*/
var ActionStack = [];
var createAction = function (op, args) {
    this.op = op;
    this.args = args;
};
var performAction = function (action) {
    var op = action.op,
        args = action.args;
    switch(op){
    case "add_schedule": 
        args.op = "add_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            '/schedule.php'
            );
    break;
    case "update_schedule":
        args.op = "update_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            '/schedule.php'
            );
    break;
    case "delete_schedule":
        args.op = "delete_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            '/schedule.php'
            );
    break;
    }
    ActionStack.push(action);
};
var undoAction = function (action) {
    var op = action.op,
        args = action.args;
    switch(action.op){
    case "add_schedule": 
        args = {};
        args.op = "delete_schedule";
        args.s_id = action.result.s_id
        result = xmlRequestJson(
            'GET', 
            args,
            '/schedule.php'
            );
    break;
    case "update_schedule":
    break;
    case "delete_schedule":
    break;
    }
}

var createScheduleController = function (scheduler) {
    var calendar = scheduler.getElementsByClassName("calendar")[0];
    var datecells = calendar.getElementsByClassName("datecell");
    var timeline = document.createElement("div");
    timeline.className = "time_line";
    timeline.innerHTML = "00:00";
    for(var i=0, l=datecells.length; i<l; i++){
        datecells[i].onmousemove = function (evt) {
            if(timeline.parentElement && timeline.parentElement != this)timeline.parentElement.removeChild(timeline);
            var left = this.getBoundingClientRect().left;
                width = this.getBoundingClientRect().right - left;
            var time = (evt.pageX-left)*1440/width,
                hour = ~~(time/60),
                miniute = ~~(time%60);
            timeline.style.marginLeft = (evt.pageX - left-1) + "px"
            timeline.innerHTML = "".concat(hour, ":", miniute);
            if(timeline.parentElement == null)this.appendChild(timeline);
        }
    }
};

var __id_auto_increament = 0;
var createScheduler = function (container, year, month, id) {
    this.id = id || "scheduler" + (++__id_auto_increament);
    //todo : make interactive object here...
    this.date = new Date();
    console.log(year, month);
    if(year!=null)date.setYear(year);
    if(month!=null)date.setMonth(month-1);
    year = date.getFullYear();
    month = date.getMonth()+1;
    console.log(year, month);
    var cont = document.createElement("div");
    cont.id = this.id;
    cont.className = "scheduler";
    container.appendChild(cont);
    createDateController(cont, this.id, year, month);
    createSchedulerViewElement(cont, year, month);
    return cont;
};
var createDateController = function (container, id, year, month) {
    var div = document.createElement("div");
    div.className = "date_controller";
    var ret = "".concat("<span onclick='setDate(\"",id,"\",",year,",",month-1, ")'><  </span><span id='", id,"-date", "'>", year, "-", month, "</span><span onclick='setDate(\"",id,"\",",year,",",month+1, ")'>  ></span>");
    div.innerHTML = ret;
    container.appendChild(div);
};
function setDate(id, year, month) {
    var el = document.getElementById(id),
        cont = el.parentElement;
    cont.removeChild(el);
    el.id = null;
    createScheduler(cont, year, month, id);
};
var createSchedulerViewElement = function (container, year, month) {
    var date = new Date();
    year = year || date.getFullYear();
    month = month || date.getMonth()+1;
    var calendar = createCalendarElement(container, year, month);
    calendar.style.position = "relative";
    var schedules = xmlRequestJson(
        'GET', 
        {"op": "get_schedule",
         "start_time": dateFormat(year, month, 1),
         "end_time": dateFormat(year, month+1, 1)},
        '/schedule.php'
        );
    for(var i=0, l=schedules.length; i<l; i++)
        drawSchedule(calendar, schedules[i].s_id, schedules[i].s_name, schedules[i].start_time, schedules[i].end_time);
    return calendar;
};

var drawSchedule = function (calendar, id, name, startTime, endTime) {
    var startCalendarDateElement = document.getElementById(calendar.id + "-" + startTime.substr(0,8) + "000000");
    var endCalendarDateElement = document.getElementById(calendar.id + "-" + endTime.substr(0, 8) + "000000");
    console.log(calendar.id + "-" + endTime.substr(0, 8) + "000000");
    var tds = calendar.getElementsByClassName("datecell");
    var startHour = (startTime-0)/10000%100,
        startMiniute = (startTime-0)/100%100,
        endHour = (endTime-0)/10000%100,
        endMiniute = (endTime-0)/100%100;
    var dh = tds[0].offsetHeight,
        dw = tds[0].offsetWidth-1,
        sx = startCalendarDateElement? startCalendarDateElement.offsetLeft 
                                     + ~~((startHour*60 + startMiniute)/1440*dw)
                                     : tds[0].offsetLeft, 
        sy = startCalendarDateElement? startCalendarDateElement.offsetTop
                                     : tds[0].offsetTop,
        ex = endCalendarDateElement? endCalendarDateElement.offsetLeft 
                                     + ~~((endHour*60 + endMiniute)/1440*dw)
                                     : tds[tds.length-1].offsetLeft+dw,
        ey = endCalendarDateElement? endCalendarDateElement.offsetTop
                                     : tds[tds.length-1].offsetTop,
        w = calendar.clientWidth;
    var box_class = "schedule_box";
    var box_style = {
        backgroundColor: genRandomColor(name, 0.9),
    };
    var container = document.createElement("div");
    container.style.position = "absolute";
    container.style.top = 0;
    container.style.left = 0;
    var contentStartTime = "<span class='start_time'>".concat(
        startCalendarDateElement? timeStringTime(startTime): timeStringMonth(startTime), 
        "~", "</span>");
    var contentEndTime = "<span class='end_time'>".concat("~", 
        endCalendarDateElement? timeStringTime(endTime): timeStringMonth(endTime), 
        "</span>");
    var contentName = "<span class='name'>".concat(name, "</span>");
    var contentEmpty = "<span class='name'>".concat("&nbsp;", "</span>");

    if(ey-dh+1<sy){ 
    // case1 : schedule represent in one line
        var box = createBox(container, sx, sy, ex-sx, dh, box_class, box_style, contentStartTime.concat(contentName, contentEndTime));
        box.name = id;
    }else {
    // case2 : schedule represent in more than one line
        var box = createBox(container, sx, sy, w-sx, dh, box_class, box_style, contentStartTime.concat(contentName, contentEmpty));
        box.name = id;
        // case3 : schedule represent in more than two lines
        for(var i=1, l=~~((ey-sy+1)/dh); i<l; i++){
            var box = createBox(container, 0, sy + dh*i, w, dh, box_class, box_style, contentEmpty.concat(contentName, contentEmpty));
            box.name = id;
        }
            box = createBox(container, 0, ey, ex, dh, box_class, box_style, contentEmpty.concat(contentName, contentEndTime));
        box.name = id;
    }
    calendar.appendChild(container);
};
//var _z_index_autodecreament = 1000;
function createBox(container, x, y, w, h, className, style, inner){
    var box = document.createElement("div");
    box.style.position = "absolute";
    box.style.left = x + "px";
    box.style.top = y + "px";
    box.style.width = w + "px";
    box.style.height = h + "px";
    box.className = className;
    box.innerHTML = inner;
    //box.style.zIndex = ++_z_index_autodecreament;
    for(i in style)
        box.style[i] = style[i];
    container.appendChild(box);
    return box;
}

function genRandomColor(str, alpha) {
    alpha = alpha||1;
    var code = hashCode(str),
        h = code%360,
        s = h*31%100,
        l = s*31%50;
    if(h<0)h=0;if(h>=360)h=359;
    if(s<0)s=0;if(s>100)s=100;
    if(l<0)l=0;if(l>100)l=100;
    s=100; l=10;
    return "hsla(".concat(h, ",", s, "%,", l, "%,", alpha, ")");
}

function timeStringTime(time) {
    return "".concat(time.substr(8, 2), ":", time.substr(10, 2));
}
function timeStringDate(time) {
    return "".concat(time.substr(6, 2), " ", time.substr(8, 2), ":", time.substr(10, 2));
}
function timeStringMonth(time) {
    return "".concat(time.substr(4, 2), "-", time.substr(6, 2), " ", time.substr(8, 2), ":", time.substr(10, 2));
}

function hashCode(str) {
    var hash =0, i=0, l=0, chr=0;
    if(str.length === 0)return hash;
    for(i=0, l=str.length; i<l; i++){
        chr = str.charCodeAt(i);
        hash = hash * 31 + chr;
    }
    return hash;
}

function xmlRequestJson(type, json, target, callback){
    var xhr = new XMLHttpRequest();
    if(type=="get" || type=="GET"){
        xhr.onreadystatechange = function () {
            if(xhr.readyState === 4){
                if(xhr.status === 200)
                    callback && callback(JSON.parse(xhr.responseText));
                else
                    console.log("error in xmlRequest : " + type + ", " + json + ", " + target);
            }
        }
        xhr.open(type, target + "?" + jsonToQueryString(json), callback!=null);
        console.log(target + "?" + jsonToQueryString(json));
        xhr.send();
    }
    return JSON.parse(xhr.responseText);
}
function jsonToQueryString(json) {
    return Object.keys(json).map(function(key) { return encodeURIComponent(key) + '=' + encodeURIComponent(json[key]); }).join('&');
}
