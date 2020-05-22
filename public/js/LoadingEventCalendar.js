(async function() {
    let url = '/evCalendar/events/getUserEventsCurrYear';
    let userEventsData = await fetch(url);
    let data = await userEventsData.json(); // read response body and parse as JSON

    url = '/evCalendar/events/getUserCalendarSettings';
    let userCalendarSettings = await fetch(url);
    let calendarSettingsData = await userCalendarSettings.json();
    // console.log(calendarSettingsData);

    let evCalendar = new eventCalendar({
        calendarContainer: 'simpleCalendarContainer',
        usingThemes: calendarSettingsData['usingThemes'],
        language: calendarSettingsData['language'],
        calendarEventsData: data,
        notifications: calendarSettingsData['notifications']
        // calendarEventsData: dataEvents
    });
    // evCalendar.setContainer('simpleCalendarContainer');
    // evCalendar.setUseOfThemes(false);
    // evCalendar.setData(dataEvents);
    evCalendar.createCalendar();
})();