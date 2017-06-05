/*
    createAction(op, args);
    performAction(action);
    undoAction(action);
    createScheduler(container[, yaer, month, id]);
        container must already be added in document.
        It creates scheduler element inside container lement
*/
var ActionStack = [];
var createAction = function (op, args, callback) {
    this.op = op;
    this.args = args;
    this.callback = callback;
    return this;
};
var performAction = function (action) {
    var op = action.op,
        args = action.args;
    switch(op){
    case "get_candidate": 
        args.op = "get_candidate";
        action.result = xmlRequestJson(
            'GET', 
            args,
            'schedule.php'
            );
    break;
    case "add_schedule": 
        args.op = "add_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            'schedule.php'
            );
    break;
    case "update_schedule":
        args.op = "update_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            'schedule.php'
            );
    break;
    case "delete_schedule":
        args.op = "delete_schedule";
        action.result = xmlRequestJson(
            'GET', 
            args,
            'schedule.php'
            );
    break;
    }
    ActionStack.push(action);
    action.callback(action);
    return action.result;
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
            'schedule.php'
            );
    break;
    case "update_schedule":
    break;
    case "delete_schedule":
    break;
    }
}

var __id_auto_increament = 0;
var createScheduler = function (container, year, month, id, g_id) {
    var cont = document.createElement("div");
    cont.id = id || "scheduler" + (++__id_auto_increament);
    //todo : make interactive object here...
    var date = cont.date = new Date();
    if(year!=null)date.setYear(year);
    if(month!=null)date.setMonth(month-1);
    year = date.getFullYear();
    month = date.getMonth()+1;
    cont.className = "scheduler";
    if(g_id != null)
        cont.classList.add("group");
    cont.year = year;
    cont.month = month;
    cont.g_id = g_id;
    container.appendChild(cont);
    // create calendar
    var calendarCont = document.createElement("div");
    cont.appendChild(calendarCont);
    calendarCont.className = "calendar_container";
    if(g_id != null)
        calendarCont.classList.add("group");
    createDateController(calendarCont, cont.id, year, month);
    createScheduleViewElement(calendarCont, year, month, g_id);
    // create timetable
    var timetableCont = document.createElement("div");
    timetableCont.className = "timetable_container";
    if(g_id != null)
        timetableCont.classList.add("group");
    var timetable = createTimeTable(timetableCont, year, month, 1, g_id);
    cont.appendChild(timetableCont);
    // create controller
    var controllerCont = document.createElement("div");
    cont.appendChild(controllerCont);
    controllerCont.className = "controller_container";
    if(g_id != null)
        controllerCont.classList.add("group");
    controllerCont.timetable = timetable;
    createScheduleController(controllerCont, calendarCont, g_id);
    return cont;
};

var createScheduleController = function (container, scheduleView, g_id) {
    var cont = document.createElement('div');
    var form = document.createElement("form");
    var calendar = scheduleView.getElementsByClassName("calendar")[0];
    form.className = "schedule_controller";
    if(g_id != null)
        form.classList.add("group");
    var ret = "";
    ret += "<span class='title'>Group Schedule</span>"
    ret += "<input type='hidden' id='s_id' name='s_id'>";
    ret += "<p><label id='s_name'>Name</label><input id='s_name' name='s_name'></p>";
    ret += "<p><label id='start_time'>Start time</label><input id='start_time' name='start_time'></p>";
    ret += "<p><label id='end_time'>End time</label><input id='end_time' name='end_time'></p>";
    ret += "<p><label id='description'>Description</label><textarea id='description' name='description' rows=4></textarea></p>";
    form.innerHTML += ret;
    var addButton = document.createElement("button"),
        updateButton = document.createElement("button"),
        deleteButton = document.createElement("button");
    addButton.id = "add_schedule";
    if(g_id != null)
        addButton.innerText = "Add to group";
    else
        addButton.innerText = "Add";
    deleteButton.id = "delete_schedule";
    deleteButton.innerText = "Delete";
    updateButton.id = "update_schedule";
    updateButton.innerText = "Update";
    addButton.type = deleteButton.type = updateButton.type = "button";
    addButton.onclick = function () {
        json =  formToJson(form, function(name, value){
                    if(name.endsWith("time"))return stringTime(value); 
                    else return value;
                });
        if(g_id != null)
            json.g_id = g_id;
        performAction(createAction("add_schedule", 
            json,
            function (action) {
                writeSchedule(calendar, action.result.s_id, action.args.s_name, action.args.start_time, action.args.end_time);
                var boxCont = drawSchedule(calendar, action.result.s_id, action.args.s_name, action.args.start_time, action.args.end_time);
                for(var i=0, l=boxCont.children.length; i<l; i++)
                    boxCont.children[i].onclick = function () {
                        focusOn(this.classList[0]);
                    }
                clearHelper();
            }));
    }
    deleteButton.onclick = function () {
        performAction(createAction("delete_schedule", 
            {"s_id": form.s_id.value},
            function (action) {
                eraseSchedule(calendar, action.args.s_id);
                focusOn(null);
            }));
    }
    updateButton.onclick = function () {
        performAction(createAction("update_schedule", 
            formToJson(form, function(name, value){
                if(name.endsWith("time"))return stringTime(value); 
                else return value;
            }),
            function (action) {
                eraseSchedule(calendar, action.args.s_id);
                focusOn(null);
                var boxCont = drawSchedule(calendar, action.result.s_id, action.args.s_name, action.args.start_time, action.args.end_time);
                writeSchedule(calendar, action.result.s_id, action.args.s_name, action.args.start_time, action.args.end_time);
                for(var i=0, l=boxCont.children.length; i<l; i++)
                    boxCont.children[i].onclick = function () {
                        focusOn(this.classList[0]);
                    }
                focusOn(action.args.s_id);
            }));
    }
    var scheduleBoxes = scheduleView.getElementsByClassName("schedule_box");
    var focusingSID = null;
    var boxes=[], i;
    var focusOn = function (s_id) {
        if(isHelperMoving() && s_id != null){
            pinHelper();
            return;
        }
        if(s_id === focusingSID){
            for(i=0, l=boxes.length; i<l; i++)
                boxes[i].classList.remove("highlight");
            /*
            for(i=0, l=form.elements.length; i<l; i++)
                form.elements[i].value = "";
                */
            focusingSID = null;
        }
        else{
            for(i=0, l=boxes.length; i<l; i++)
                boxes[i].classList.remove("highlight");
            if(s_id != null){
                clearHelper();
                boxes = scheduleView.getElementsByClassName(s_id);
                for(i=0, l=boxes.length; i<l; i++)
                    boxes[i].classList.add("highlight");
                var schedule = xmlRequestJson(
                    'GET', 
                    {"op": "get_schedule",
                        "s_id": s_id,
                    },
                    'schedule.php'
                )[0];
                for(var name in schedule){
                    if(form[name] != null){
                        if(name.endsWith("time")) form[name].value = timeString(schedule[name]);
                        else form[name].value = schedule[name];
                    }
                }
            }
            focusingSID = s_id;
        }
        if(focusingSID == null){
            deleteButton.style.display = "none";
            updateButton.style.display = "none";
            addButton.style.display = "inline-block";
        }
        else {
            deleteButton.style.display = "inline-block";
            updateButton.style.display = "inline-block";
            addButton.style.display = "none";

        }
    }
    focusOn(null);
    form.appendChild(addButton);
    form.appendChild(updateButton);
    form.appendChild(deleteButton);
    container.appendChild(form);
    for(var i=0, l=scheduleBoxes.length;i<l; i++){
        scheduleBoxes[i].onclick = function () {
            focusOn(this.classList[0]);
        }
    }
    // line helper
    function isHelperMoving(){
        return pinnedStartTimeLine && !pinnedEndTimeLine;
    }
    function drawHelperStart(evt, datecell){
        var left = datecell.getBoundingClientRect().left;
            width = datecell.getBoundingClientRect().right - left;
        var _time = (evt.clientX-left)*1440/width,
            time = _time - _time%30,
            hour = ~~(time/60),
            miniute = ~~(time%60);
        form.s_name.value = "";
        form.description.value = "";
        endTime = startTime = "" + (datecell.id.substr(-14, 14)-0 + hour*10000 + miniute*100);
        form.start_time.value = timeString(startTime); 
        form.end_time.value = timeString(endTime);
        focusOn(null);
        pinnedStartTimeLine = true;
    }
    function pinHelper(){
        pinnedEndTimeLine = true;
    }
    function clearHelper(){
        pinnedStartTimeLine = pinnedEndTimeLine = false;
        eraseSchedule(calendar, placeholderId);
    }
    var startTime = "", endTime = "";
    var datecells = calendar.getElementsByClassName("datecell");
    var pinnedStartTimeLine = false;
    var pinnedEndTimeLine = false;
    var timeline = document.createElement("div");
    var placeholderId = "helper_box";
    timeline.className = "time_line";
    timeline.innerHTML = "00:00";
    for(var i=0, l=datecells.length; i<l; i++){
        datecells[i].onclick = function (evt) {
            date = "".concat(this.id.substr(-8,2)),
            container.timetable.setDate(date);
            
            if(!pinnedStartTimeLine){
                drawHelperStart(evt, this);
            }
            else if(!pinnedEndTimeLine){
                pinHelper();
            }
            else {
                clearHelper();
                drawHelperStart(evt, this);
            }
        }
        datecells[i].onmousemove = function (evt) {
            var left = this.getBoundingClientRect().left;
                width = this.getBoundingClientRect().right - left;
            var _time = (evt.clientX-left)*1440/width,
                time = _time - _time%30,
                date = "".concat(this.id.substr(-10, 2)-0,"-",this.id.substr(-8,2)),
                hour = ~~(time/60),
                miniute = ~~(time%60);
                if(timeline.parentElement && timeline.parentElement != this)timeline.parentElement.removeChild(timeline);
                timeline.style.marginLeft = ~~(width*time/1440-1) + "px"
                timeline.innerHTML = "".concat("<div>", date, "</div>", "<div>", hour, ":", miniute, "</div>");
                if(timeline.parentElement == null)this.appendChild(timeline);
            if(!pinnedStartTimeLine){
            }
            else if(!pinnedEndTimeLine){
                endTime = ""+ (this.id.substr(-14, 14)-0 + hour*10000 + miniute*100);
                eraseSchedule(calendar, placeholderId);
                if(startTime <= endTime){
                    drawSchedule(calendar, placeholderId, "", startTime, endTime);
                    form.start_time.value = timeString(startTime);
                    form.end_time.value = timeString(endTime);
                }else{
                    drawSchedule(calendar, placeholderId, "", endTime, startTime);
                    form.start_time.value = timeString(endTime);
                    form.end_time.value = timeString(startTime);
                }
            }
            else{
            }
        }
        datecells[i].onmouseout = function (evt) {
            if(this.contains(timeline))this.removeChild(timeline);
            if(!pinnedEndTimeLine && pinnedStartTimeLine){
                var box = document.elementFromPoint(evt.clientX, evt.clientY);
                if(box.classList[0] !== placeholderId && box.classList[1] !== "schedule_box") return;
                var left = this.getBoundingClientRect().left-1;
                    width = this.getBoundingClientRect().right - left;
                var _time;
                if(Math.abs(box.getBoundingClientRect().left - evt.clientX) < Math.abs(box.getBoundingClientRect().right - evt.clientX))
                    _time = (box.getBoundingClientRect().left-left)*1440/width;
                else
                    _time = (box.getBoundingClientRect().right-left)*1440/width;
                var time = _time - _time%30,
                    date = "".concat(this.id.substr(-10, 2)-0,"-",this.id.substr(-8,2)),
                    hour = ~~(time/60),
                    miniute = ~~(time%60);
                endTime = ""+ (this.id.substr(-14, 14)-0 + hour*10000 + miniute*100);
                eraseSchedule(calendar, placeholderId);
                if(startTime <= endTime){
                    drawSchedule(calendar, placeholderId, "", startTime, endTime);
                    form.start_time.value = timeString(startTime);
                    form.end_time.value = timeString(endTime);
                }else{
                    drawSchedule(calendar, placeholderId, "", endTime, startTime);
                    form.start_time.value = timeString(endTime);
                    form.end_time.value = timeString(startTime);
                }
            }
        }
    }
};


var createDateController = function (container, id, year, month) {
    var div = document.createElement("div");
    div.className = "date_controller";
    var ret = "".concat("<span class='title'> <span onclick='setDate(\"",id,"\",",year,",",month-1, ")'><  </span>", year, "-", month, "<span onclick='setDate(\"",id,"\",",year,",",month+1, ")'>  ></span></span>");
    div.innerHTML = ret;
    container.appendChild(div);
};
function setDate(id, year, month) {
    var el = document.getElementById(id),
        cont = el.parentElement;
    cont.removeChild(el);
    el.id = null;
    createScheduler(cont, year, month, id, cont.g_id);
};
var createScheduleViewElement = function (container, year, month, g_id) {
    var date = new Date();
    year = year || date.getFullYear();
    month = month || date.getMonth()+1;
    var calendar = createCalendarElement(container, year, month);
    calendar.style.position = "relative";
    var schedules = null;
    var candidates = [];
    if(g_id == null){
        schedules = xmlRequestJson(
            'GET', 
            {"op": "get_schedule_in_range",
                "start_time": dateFormat(year, month, 1),
                "end_time": dateFormat(year, month+1, 1)},
            'schedule.php'
        );

    }else{
        schedules = xmlRequestJson(
            'GET', 
            {"op": "get_group_schedule_in_range",
                "g_id": g_id,
                "start_time": dateFormat(year, month, 1),
                "end_time": dateFormat(year, month+1, 1)},
            'schedule.php'
        );
        args = {};
        args.op = "get_candidate";
        args.g_id = g_id;
        result = xmlRequestJson(
            'GET', 
            args,
            'schedule.php'
            );
        if(result != null){
            candidates = result.map(function(t){return t.s_id});
        }
    }
    for(var i=0, l=schedules.length; i<l; i++){
        drawSchedule(calendar, schedules[i].s_id, schedules[i].s_name, schedules[i].start_time, schedules[i].end_time, candidates.includes(schedules[i].s_id));
        writeSchedule(calendar, schedules[i].s_id, schedules[i].s_name, schedules[i].start_time, schedules[i].end_time);
    }

    /*
    var names = calendar.getElementsByClassName("name");
    var i=0, j=0, l=names.length;
    for(i=0; i<l; i++)
        for(j=i+1; j<l; j++)
            if(collision(names[i], names[j])){
                names[j].style.paddingTop = parseFloat(names[i].style.paddingTop || 0) + 1.2 + "em";
                console.log(names[i].innerText, names[j].innerText);
            }
            */
    return calendar;
};

var eraseSchedule = function (calendar, id) {
    var ss = calendar.getElementsByClassName(id);
    for(var i=0; i < ss.length; i++){ 
        if(ss[i]){
            ss[i].parentElement.removeChild(ss[i]);
            --i;
        }
    }
    /*for(var i=0, l=ss.length; i<l; i++)
        ss[i].parentElement.removeChild(ss[i]);
        */
};
var writeSchedule = function (calendar, id, name, startTime, endTime) {
    var tds = calendar.getElementsByClassName("datecell");
    var startId = calendar.id + "-" + startTime.substr(0, 8) + "000000",
        endId = calendar.id + "-" + endTime.substr(0, 8) + "000000";
    var startIndex = startId.substr(4, 2) < tds[0].id.substr(4, 2)? 0 : startTime.substr(6, 2)-1, 
        endIndex = endId.substr(4, 2) > tds[tds.length-1].id.substr(4, 2)? tds.length-0 : endTime.substr(6, 2)-0; 
    if(endTime.substr(8, 6) === "000000") endIndex-=1;
    for(var i=startIndex; i<endIndex; i++){
        var content = document.createElement("div");
        content.className = id + " schedule_writed";
        content.innerHTML = name;
        content.startTime = startTime;
        content.endTime = endTime;
        var cont = tds[i].getElementsByClassName("datecell_description")[0];
        var writes = cont.children;
        for(var j=0, l=writes.length; j<l; j++)
            if(writes[j].startTime > startTime)break;
        if(j==l)cont.appendChild(content);
        else cont.insertBefore(content, writes[j]);
    }
}
var drawSchedule = function (calendar, id, name, startTime, endTime, is_candidate) {
    var startCalendarDateElement = document.getElementById(calendar.id + "-" + startTime.substr(0,8) + "000000");
    var endCalendarDateElement = document.getElementById(calendar.id + "-" + endTime.substr(0, 8) + "000000");
    var tds = calendar.getElementsByClassName("datecell");
    var startHour = (startTime-0)/10000%100,
        startMiniute = (startTime-0)/100%100,
        endHour = (endTime-0)/10000%100,
        endMiniute = (endTime-0)/100%100;
    var dh = tds[0].offsetHeight,
        dw = tds[0].offsetWidth,
        sx = startCalendarDateElement? startCalendarDateElement.offsetLeft 
                                     + (startHour*60 + startMiniute)/1440*dw 
                                     : tds[0].offsetLeft, 
        sy = startCalendarDateElement? startCalendarDateElement.offsetTop 
                                     : tds[0].offsetTop,
        ex = endCalendarDateElement? endCalendarDateElement.offsetLeft 
                                     + (endHour*60 + endMiniute)/1440*dw
                                     : tds[tds.length-1].offsetLeft+dw,
        ey = endCalendarDateElement? endCalendarDateElement.offsetTop 
                                     : tds[tds.length-1].offsetTop, 
        w = calendar.clientWidth;
    var box_class = "schedule_box";
    var box_style = {
        backgroundColor: genRandomColor(name, 0.3),
        color: genCounterBlackOrWhite(name),
    };
    var container = document.createElement("div");
    container.style.position = "absolute";
    container.style.top = 0;
    container.style.left = 0;
    container.id = id;
    var parsedStartTime = startCalendarDateElement? timeStringTime(startTime): timeStringMonth(startTime), 
        parsedEndTime = endCalendarDateElement? timeStringTime(endTime): timeStringMonth(endTime);
    var contentStartTime = "<span class='start_time'>".concat(parsedStartTime, "~", "</span>");
    var contentEndTime = "<span class='end_time'>".concat("~", parsedEndTime, "</span>");
    var contentName = "<span class='name'>".concat(name, "</span>");
    var contentEmpty = "<span class='name'>".concat("&nbsp;", "</span>");
    var candidateCheckbox = "<input type='checkbox' class='candidate'/>"

    if(ey-dh+1<sy){ 
    // case1 : schedule represent in one line
        var box = createBox(container, sx, sy, ex-sx, dh, id, box_style, //contentStartTime.concat(contentName, contentEndTime));
            candidateCheckBox);
        box.classList.add(box_class);
    }else {
    // case2 : schedule represent in more than one line
        var box = createBox(container, sx, sy, w-sx, dh, id, box_style, //contentStartTime.concat(contentName, contentEmpty));
            candidateCheckBox);
        box.classList.add(box_class);
        // case3 : schedule represent in more than two lines
        for(var i=1, l=~~((ey-sy+1)/dh); i<l; i++){
            var box = createBox(container, 0, sy + dh*i, w, dh, id, box_style, contentEmpty.concat(contentName, contentEmpty));
            box.classList.add(box_class);
        }
        box = createBox(container, 0, ey, ex, dh, id, box_style, //contentEmpty.concat(contentName, contentEndTime));
            candidateCheckBox);
        box.classList.add(box_class);
    }
    calendar.appendChild(container);
    return container;
};
function collision(e1, e2){
    var r1 = e1.getBoundingClientRect(),
        r2 = e2.getBoundingClientRect();
    if (r1.bottom < r2.top || r1.top > r2.bottom || r1.right < r2.left || r1.left > r2.right) return false;
    return true;
}
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

function genRandomColor(num, alpha) {
    alpha = alpha||1;
    var code;
    if(typeof num === "number")
        code = num*397+163;
    else
        code = hashCode(num)*397+163;
    var 
        h = code%360,
        s = h*31%100,
        l = s*31%100;
    s=100;//l=50;// l=10;
    return "hsla(".concat(h, ",", s, "%,", l, "%,", alpha, ")");
}
function genCounterBlackOrWhite(num) {
    var code;
    if(typeof num === "number")
        code = num*397+163;
    else
        code = hashCode(num)*397+163;
    var
        h = code%360,
        s = h*31%100,
        l = s*31%100;
    //l=50;
    if(l > 50)
        return "black";
    else
        return "white";

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
function timeString(time) {
    return "".concat(time.substr(0, 4), "-", time.substr(4, 2), "-", time.substr(6, 2), " ", time.substr(8, 2), ":", time.substr(10, 2), ":", time.substr(12, 2));
}
function stringTime(time) {
    return "".concat(time.substr(0, 4), time.substr(5, 2), time.substr(8, 2), time.substr(11, 2), time.substr(14, 2), time.substr(17, 2));
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
    json = encodeJSON(json);
    if(type=="get" || type=="GET"){
        xhr.onreadystatechange = function () {
            if(xhr.readyState === 4){
                if(xhr.status === 200){
                    callback && callback(decodeJSON(JSON.parse(xhr.responseText)));
                }
                else
                    console.log("error in xmlRequest : " + type + ", " + json + ", " + target);
            }
        }
        xhr.open(type, target + "?" + jsonToQueryString(json), callback!=null);
        console.log(target + "?" + jsonToQueryString(json));
        xhr.send();
    }
    console.log(xhr.responseText);
    return decodeJSON(JSON.parse(xhr.responseText));
}
function encodeJSON(json){
    if(typeof(json) !== "object") return encodeURIComponent(json);
    if(Array.isArray(json))t = [];
    else t = {};
    for(var i in json){
        t[encodeURIComponent(i)] = encodeJSON(json[i]);
    }
    return t;
}
function decodeJSON(json){
    if(typeof(json) !== "object"){
        if(typeof(json) === "string" && (json[json.length-1] == "%" || json[json.length-2] == "%"))
            json = json.substr(0, json.lastIndexOf("%")).concat("%20");
        return decodeURIComponent(json);
    }
    var t;
    if(Array.isArray(json))t = [];
    else t = {};
    for(var i in json){
        t[decodeURIComponent(i)] = decodeJSON(json[i]);
    }

    //return JSON.parse(decodeURIComponent(JSON.stringify(json)));
    return t;
}
function jsonToQueryString(json) {
    return Object.keys(json).map(function(key) { return encodeURIComponent(key) + '=' + encodeURIComponent(json[key]); }).join('&');
}
function formToJson(form, reduceCall) {
    var json = {};
    for(var i=0, l=form.elements.length; i<l; i++){
        var input = form.elements[i];
        if(input.name && input.name != ""){
            if(reduceCall)json[input.name] = reduceCall(input.name, input.value);
            else json[input.name] = input.value;
        }
    }
    return json;
}

