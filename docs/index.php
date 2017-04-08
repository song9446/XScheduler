<html>
    <head>
    <link rel="stylesheet" href="calendar.css"></link>
    <link rel="stylesheet" href="scheduler.css"></link>
    </head>
    <body>
    <script src="calendar.js"></script>
    <script src="scheduler.js"></script>
    <script>
    /*
    var calendar = createCalendarElement(2016, 4); 
    document.body.appendChild(calendar);
    var scheduler = createSchedulerElement(2016, 4);
    */
    var scheduler = createScheduler(document.body);
    var controller = createScheduleController(scheduler);
    </script>
    </body>
</html>
