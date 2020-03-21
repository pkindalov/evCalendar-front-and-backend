<?php
class Events extends Controller
{
    private $eventsModel;

    public function __construct()
    {
        $this->eventsModel = $this->model('Event');
    }

    public function addDate($date)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if(!isset($_SESSION['user_id'])){
            return json_encode(['success' => false, 'reason' => 'you must be logged to created events']);
        }
        
        if(!isset($_POST['eventText']) || strlen($_POST['eventText']) < 5 ){
            return json_encode(['success' => false, 'reason' => 'eventText variable do not exist or it is too short.']);
        }
        if(!isset($_POST['hoursBegin']) || empty($_POST['hoursBegin'])){
            return json_encode(['success' => false, 'reason' => 'hoursBegin variable do not exist or it is empty']);
        }
        if(!isset($_POST['hoursFinish']) || empty($_POST['hoursFinish'])){
            return json_encode(['success' => false, 'reason' => 'hoursFinish variable do not exist or it is empty']);
        }
        if(!isset($_POST['selectedYear']) || empty($_POST['selectedYear'])){
            return json_encode(['success' => false, 'reason' => 'selectedYear variable do not exist or it is empty']);
        }
        if(!isset($_POST['selectedMonth']) || empty($_POST['selectedMonth'])){
            return json_encode(['success' => false, 'reason' => 'selectedMonth variable do not exist or it is empty']);
        }
        if(!isset($date) || empty($date)){
            return json_encode(['success' => false, 'reason' => 'date variable do not exist or it is empty']);
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
        
        if($this->eventsModel->addEvent($data)){
            redirect('/');
        }
    }

    
}
