var _id_auto_increament = 0;
var createCalendarElement = function(container, year, month) {
    var id = "calendar" + (++_id_auto_increament);
    var dayString = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
    var today = new Date();
    year = year || today.getFullYear();
    month = month || today.getMonth()+1;
    var date = new Date(year, month-1, 1);
    var monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if((year%4 === 0 && year%100 !== 0) || year%400 === 0 )
        monthLength[1] = 29;


    var i=0, l=0, d=0, t=0
        startDay = date.getDay(),
        ret = "";
    ret += "<table border='0' cellspacing='0' cellpadding='0' class='calendar'>";
    ret += "<thead>";
    ret += "    <tr>";
    for(i=0; i<7; i++){
    if(i==0 || i==6)
    ret += "        <th scope='row' class='week holiday'>" + dayString[i] + "</th>";
    else {
    ret += "        <th scope='row' class='week'>" + dayString[i] + "</th>";
    }}
    ret += "    </tr>";
    ret += "</thead>";
    ret += "<tbody>";
    ret += "    <tr>";
    console.log(startDay);
    for(i=0, l=startDay; i<l; i++)
    ret += "    <td></td>";
    for(l=monthLength[month-1]+i; i<l; i++){
    if(i%7 == 0)
    ret += "    </tr><tr>";
    t = (startDay + d) % 7;
    d++
    if(t==0 || t==6)
    ret += "    <td class='datecell holiday' id='" + id+"-"+dateFormat(year, month, d) +  "'>" + d + "<div class='noon_line'></div></td>";
    else
    ret += "    <td class='datecell' id='" + id+"-"+dateFormat(year, month, d) +  "'>" + d +  "<div class='noon_line'></div></td>";
    }
    ret += "    </tr>";
    ret += "</tbody>";
    ret += "</table>";

    var el = document.createElement("div");
    el.innerHTML = ret;
    el.id = id;
    el.year = year;
    el.month = month;
    el.style.display="inline-block";
    container.appendChild(el);
    var todayElement = document.getElementById(id+"-"+dateFormat(today.getFullYear(), today.getMonth()+1, today.getDate()))
    console.log(id+"-"+dateFormat(today.getFullYear(), today.getMonth()+1, today.getDate()))
    console.log(todayElement);
    if(todayElement)todayElement.classList.add("today");
    return el;
};

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
