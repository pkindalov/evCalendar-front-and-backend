<?php
require_once APPROOT . '/libraries/PhpMailSender.php';

class Events extends Controller
{
    private $eventsModel;
    private $calConfigModel;

    public function __construct()
    {
        $this->eventsModel = $this->model('Event');
        $this->calConfigModel = $this->model('CalendarConfig');
        $this->phpMailer = new PhpMailSender(MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD);
        $this->phpMailer->setCharset(CHARSET);
    }

    public function addDate($date)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'reason' => 'you must be logged to created events']);
            return;
        }

        if (!isset($_POST['eventText']) || strlen($_POST['eventText']) < 5) {
            echo json_encode(['success' => false, 'reason' => 'text of event do not exist or it is too short.']);
            return;
        }
        if (!isset($_POST['hoursBegin']) || empty($_POST['hoursBegin'])) {
            echo json_encode(['success' => false, 'reason' => 'hoursBegin variable do not exist or it is empty']);
            return;
        }
        if (!isset($_POST['hoursFinish']) || empty($_POST['hoursFinish'])) {
            echo json_encode(['success' => false, 'reason' => 'hoursFinish variable do not exist or it is empty']);
            return;
        }
        if (!isset($_POST['selectedYear']) || empty($_POST['selectedYear'])) {
            echo json_encode(['success' => false, 'reason' => 'selectedYear variable do not exist or it is empty']);
            return;
        }
        if (!isset($_POST['selectedMonth']) || empty($_POST['selectedMonth'])) {
            echo json_encode(['success' => false, 'reason' => 'selectedMonth variable do not exist or it is empty']);
            return;
        }
        if (!isset($date) || empty($date)) {
            echo json_encode(['success' => false, 'reason' => 'date variable do not exist or it is empty']);
            return;
        }


        $fullDate = $_POST['selectedYear'] . '-';
        $month = intval($_POST['selectedMonth']) < 10 ? '0' . $_POST['selectedMonth'] : $_POST['selectedMonth'];
        $day = intval($date) < 10 ? '0' . $date : $date;
        $fullDate .= $month . '-' . $day;
        $data = [
            "eventText" => $_POST['eventText'],
            "hoursBegin" => $_POST['hoursBegin'],
            "hoursFinish" => $_POST['hoursFinish'],
            "date" => $fullDate,
        ];

        if ($this->eventsModel->addEvent($data)) {
            redirect('/');
        }
        return;
    }

    public function getUserEventsCurrYear()
    {
        if (isset($_SESSION['user_id'])) {
            $currYearUserEvents = $this->eventsModel->getCurrYearUserEvents();
            header('Content-Type: application/json');
            echo json_encode($currYearUserEvents);
            // return ['success' => true, 'data' => json_encode($currYearUserEvents)];
        }
    }

    public function getUserCalendarSettings()
    {
        $data = ['language' => 'bg', 'usingThemes' => true, 'notifications' => false];
        $userSettings = $this->calConfigModel->getUsersSettingsById();
        if ($userSettings) {
            $data = [
                'language' => $userSettings[0]->title,
                'usingThemes' => !isset($userSettings[0]->usingThemes) ? false : $userSettings[0]->usingThemes,
                'notifications' => !isset($userSettings[0]->notifications) ? false : $userSettings[0]->notifications
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getUserEventsYear($year)
    {
        if (isset($_SESSION['user_id']) && isset($year)) {
            $yearUserEvents = $this->eventsModel->getYearUserEvents(htmlspecialchars($year));
            header('Content-Type: application/json');
            echo json_encode($yearUserEvents);
            // return ['success' => true, 'data' => json_encode($currYearUserEvents)];
        }
    }

    public function editEvent($eventId)
    {

        if (!isset($_SESSION['user_id']) || !isset($_POST) || !isset($_POST['eventAuthor']) || !isset($eventId)) {
            redirect('/');
        }

        if ($_SESSION['user_id'] !== $_POST['eventAuthor']) {
            redirect('/');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($this->eventsModel->updateEvent(htmlspecialchars($eventId), $_POST)) {
            redirect('/');
        }
        return;
    }

    public function deleteEvent($query)
    {
        $queryData = getQueryData($query);
        if ($this->eventsModel->removeEventById($queryData)) {
            redirect('/');
        }
        return;
    }

    public function checkUncheckEvent($query)
    {
        $queryData = getQueryData($query);
        if ($this->eventsModel->checkUncheckEventById($queryData)) {
            redirect('/');
        }
        return;
    }

    public function showEventFromNotif($query)
    {
        $queryData = getQueryData($query);
        $eventId = $queryData['id'];
        $timeleft = $queryData['timeleft'];
        if (!isset($eventId) || empty($eventId)) {
            redirect('/');
        }

        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }

        $eventData = $this->eventsModel->showEventFromNotif($eventId);
        $data = [
            'event' => $eventData,
            'timeleft' => intval($timeleft)
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;


        $this->view('events/showEventFromNotif', $data);
    }

    public function turnOffNotif($eventId)
    {
        if (!isset($eventId) || empty($eventId) || !$eventId || !$_SESSION['user_id']) {
            redirect('/');
        }
        $eventId = htmlspecialchars($eventId);
        $this->eventsModel->turnOffNotif($eventId);
        redirect('/');
    }

    public function turnOnNotif($eventId)
    {
        if (!isset($eventId) || empty($eventId) || !$eventId || !$_SESSION['user_id']) {
            redirect('/');
        }
        $eventId = htmlspecialchars($eventId);
        $this->eventsModel->turnOnNotif($eventId);
        redirect('/');
    }

    public function listMyEvents($query)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }
        $queryData = getQueryData($query);
        $year = isset($queryData['year']) ? htmlspecialchars($queryData['year']) : date('Y');
        $page = isset($queryData['page']) ? htmlspecialchars($queryData['page']) : 1;
        $month = isset($queryData['month']) ? htmlspecialchars($queryData['month']) : date('m');
        $pageSize = 10;
        $events = $this->eventsModel->getMyEventsByYearAndMonth($year, $month, $page, $pageSize);
        $sortedByDate = $this->extractEventsByDate($events);
        $chartJsData = convDataChartJS($sortedByDate);
//        $googleChartData = $this->convertForGoogleChart($sortedByDate);
        $data = [
            // 'events' => $events,
            'page' => $page,
            'year' => $year,
            'month' => $month,
            'today' => date('Y-m-d'),
            'hasNextPage' => count($events) > 0,
            'hasPrevPage' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
            'sortedData' => $sortedByDate,
            'chartJsData' => json_encode($chartJsData)
//            'googleData' => json_encode($googleChartData)
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/listMyEvents', $data);
    }

    private function extractEventsByDate($data)
    {
        $sortedData = [];
        foreach ($data as $event) {
            // print_r($event);
            $eventDetails = [
                'id' => $event->id,
                'text' => $event->text,
                'begin' => $event->begin,
                'finish' => $event->finish,
                'date' => $event->date,
                'checkedEvent' => $event->checkedEvent,
                'showNotification' => $event->showNotification,
                'isMonthly' => $event->isMonthly,
                'isYearly' => $event->isYearly,
                'isWeekly' => $event->isWeekly,
                'isDaily' => $event->isDaily,
                'user_id' => $event->user_id
            ];
            // if(!isset($sortedData[$event->date])){
            //     $sortedData[$event->date][] = $eventDetails;
            // } else {

            // }
            $sortedData[$event->date][] = $eventDetails;
        }

        return $sortedData;
    }

    private function convertForGoogleChart($data)
    {
        $googleData = [
            ['Date', 'Events Count']
        ];

        foreach ($data as $key => $value) {
            $row = [$key, count($value)];
            $googleData[] = $row;
        }
        if (count($data) == 0) {
            $googleData[] = [0, 0];
        }
        return $googleData;
    }

    public function searchEvent($query)
    {
        header('Content-Type: text/html; charset=utf-8');
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }

        $queryData = getQueryData($query);
        $keyword = htmlspecialchars(urldecode($queryData['keyword']));
        if (!isset($keyword) || strlen($keyword) < 3) {
            redirect('/');
        }
        $page = isset($queryData['page']) ? htmlspecialchars($queryData['page']) : 1;
        $pageSize = 10;
        $events = $this->eventsModel->searchEventsByKeyword($keyword, $page, $pageSize);
        $sortedByDate = $this->extractEventsByDate($events);

        $data = [
            'page' => $page,
            'hasNextPage' => count($events) > 0,
            'hasPrevPage' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
            'sortedData' => $sortedByDate,
            'keyword' => $keyword
        ];

        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/listSearchResults', $data);
    }


    public function loadEventEdit($eventId)
    {
        if (!isset($eventId) || !isset($_SESSION['user_id'])) {
            redirect("/");
        }

        $eventId = htmlspecialchars($eventId);
        $event = $this->eventsModel->getEventById($eventId);
        $data = [
            'event' => $event[0]
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/editEvent', $data);
    }

    public function addNewEvent()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($_POST) > 0) {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            if ($this->eventsModel->addEvent($_POST)) {
                redirect('/');
            }
            return;
        }


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/addNewEvent', $data);
    }

    public function sendToMail()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (!isset($_POST['receiver'])) {
            echo json_encode(['success' => false]);
            return;
        }
        $email = $_POST['receiver'];
        $tempData = html_entity_decode($_POST['dayEvents']);
        $cleanData = json_decode($tempData);
        $body = '<div style="text-align: center; width: 100%; height: 100px; background-color: red; color: white"><h2>evCalendar</h2></div>';
        $subject = 'Daily events';
        foreach ($cleanData[0]->textContent as $key => $value) {
            if ($key % 4 == 0) {
                // $body .= '<div style="margin-bottom: 20px;><p>' . $value . '</p></div>';
                $body .= '<br />';
            }
            $body .= '<p>' . $value . '</p>';
        }
        if (sendMail($this->phpMailer, $subject, $body, $email)) {
            echo json_encode(['success' => true]);
            return;
        } else {
            echo json_encode(['success' => false]);
            return;
        }
    }

    public function sendEventsOnThisDay()
    {
        if (!isset($_POST['receiver'])) {
            echo json_encode(['success' => false]);
            return;
        }
        $email = $_POST['receiver'];
        $tempData = ($_POST['dayEvents']);
        $cleanData = json_decode($tempData);


        $body = '<div style="text-align: center; width: 100%; height: 100px; background-color: red; color: white"><h2>evCalendar</h2></div>';
        $subject = 'Events Happened Today';
        foreach ($cleanData[0]->textContent as $key => $value) {
            //    print_r($value->event);

            if ($key % 4 == 0) {
                // $body .= '<div style="margin-bottom: 20px;><p>' . $value . '</p></div>';
                $body .= '<br />';
            }
            $body .= '<p>' . $value->event . '</p>';
        }

        if (sendMail($this->phpMailer, $subject, $body, $email)) {
            echo json_encode(['success' => true]);
            return;
        } else {
            echo json_encode(['success' => false]);
            return;
        }
    }

    public function allWeeksStats()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
        }

        $mostBusyWeeks = $this->eventsModel->getAllWeekStatsCurrentYear();
        $dateLabels = getDateLabelsChartJs($mostBusyWeeks);
        $dateValues = getValueForEachDateChartJs($mostBusyWeeks);
        $currentWeekStrArr = getStartAndEndDate(date('W'), date('Y'));
        $currentWeekStr = $currentWeekStrArr['week_start'] . '-' . $currentWeekStrArr['week_end'];

        // foreach ($mostBusyWeeks as $key => $value) {
        //     foreach ($value as $key2 => $value2) {
        //         print_r($value2);

        //     } 
        // }
        // $googleBarChartData = convertForGoogleBarChart($mostBusyWeeks, ['Week', 'Count of events']);
        $data = [
            // 'googleBarChartData' => json_encode($googleBarChartData)
            'dateLabels' => json_encode($dateLabels),
            'dateValues' => json_encode($dateValues),
            'busyWeeks' => $mostBusyWeeks,
            'currentWeek' => $currentWeekStr
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/allWeekStats', $data);
    }

    public function allMonthStats()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
        }

        $mostBusyMonths = $this->eventsModel->getAllMontsStats();
        $dateLabels = getDateLabelsChartJs($mostBusyMonths);
        $dateValues = getValueForEachDateChartJs($mostBusyMonths);
        $date = date('Y') . '-' . date('m');

        $data = [
            'dateLabels' => json_encode($dateLabels),
            'dateValues' => json_encode($dateValues),
            'busyMonths' => $mostBusyMonths,
            'currentMonth' => $date
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/allMonthsStats', $data);
    }

    public function onThisDay()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
        }
        $today = date('d');
        $month = date('m');
        $rawData = $this->eventsModel->getEventsHappenedOnDay($today, $month);
        $events = extractEventsDataFromAPIData($rawData);
        $data = [
            // 'events' => $events,
            'eventsEnc' => json_encode($events),
            'today' => $today . ' ' . date('M'),
            'todayURL' => $rawData->url
        ];
        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;
        $this->view('events/eventsOnThisDay', $data);
    }

    public function myTodayEvents($query)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }
        $queryData = getQueryData($query);
        $page = isset($queryData['page']) ? htmlspecialchars($queryData['page']) : 1;
        $pageSize = 5;
        $today = date('Y') . '-' . date('m') . '-' . date('d');
        $todayEvents = $this->eventsModel->getMyTodayEvents($today, $page, $pageSize);
        $data = [
            'events' => $todayEvents,
            'page' => $page,
            'hasNextPage' => count($todayEvents) > 0,
            'hasPrevPage' => $page > 1,
            'nextPage' => $page + 1,
            'prevPage' => $page - 1,
            'todayDate' => $today
        ];


        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/myTodayTasks', $data);
    }

    public function markAsReaded($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }
        $this->eventsModel->markAsReaded(htmlspecialchars($eventId));
        redirect('events/myTodayEvents?page=1');
    }

    public function markAsUnread($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }
        $this->eventsModel->markAsUnReaded(htmlspecialchars($eventId));
        redirect('events/myTodayEvents?page=1');
    }

    public function upcomingInHour()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
        }
        $todayDate = getTodayDateYmdStr();
        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        $data = [
            'upcomingInHour' => $upcomingEventsInHour,
            'todayDate' => $todayDate
        ];
        $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
        $data['todayEvents'] = $todayEventsCount[0]->count;

        $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
        if (!$upcomingEventsInHour) {
            $upcomingEventsInHour = [];
        }
        $data['upcomingEventsInHour'] = $upcomingEventsInHour;

        $this->view('events/upcomingInHour', $data);
    }

    public function moveToNewDate($query)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $year = date('Y');
        $month = date('m');

        if (!isset($query)) {
            redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
            return;
        }
        $queryData = getQueryData($query);
        $eventId = htmlspecialchars($queryData['event']);
        $editedDate = htmlspecialchars($queryData['newDate']);

        if (!$eventId || !$editedDate) {
            redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
            return;
        }
        $this->eventsModel->moveEventByDate($eventId, $editedDate);
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeMonthly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventMonthly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeNotMonthly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventNotMonthly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeYearly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventYearly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeNotYearly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventNotYearly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeWeekly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventWeekly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeNotWeekly($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventNotWeekly(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeDaily($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventDaily(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }

    public function makeNotDaily($eventId)
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/users/login');
            return;
        }
        $this->eventsModel->makeEventNotDaily(htmlspecialchars($eventId));
        $year = date('Y');
        $month = date('m');
        redirect('/events/listMyEvents?year=' . $year . '&month=' . $month . '&page=1');
    }
}
