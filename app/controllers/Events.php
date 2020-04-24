<?php
class Events extends Controller
{
    private $eventsModel;
    private $calConfigModel;

    public function __construct()
    {
        $this->eventsModel = $this->model('Event');
        $this->calConfigModel = $this->model('CalendarConfig');
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
        if($userSettings){
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

    public function showEventFromNotif($query){
        $queryData = getQueryData($query);
        $eventId = $queryData['id'];
        $timeleft = $queryData['timeleft'];
        if(!isset($eventId) || empty($eventId)){
            redirect('/');
        }
        
        if(!$_SESSION['user_id']){
            redirect('/');
        }

        $eventData = $this->eventsModel->showEventFromNotif($eventId);
        $data = [
            'event' => $eventData,
            'timeleft' => intval($timeleft)
        ];
       
        $this->view('events/showEventFromNotif', $data);
    }

    public function turnOffNotif($eventId){
        if(!isset($eventId) || empty($eventId) || !$eventId || !$_SESSION['user_id']){
            redirect('/');
        }
        $eventId = htmlspecialchars($eventId);    
        $this->eventsModel->turnOffNotif($eventId);
        redirect('/');
    }
}
