<?php

class Pages extends Controller
{

    public function __construct()
    {
        $this->eventsModel = $this->model('Event');
    }

    public function index()
    {
        $data = [
            'title' => 'evCalendar',
            'description' => 'Simple event calendar to remind you for a simple things/tasks',
        ];
        if (isset($_SESSION['user_id'])) {
            //get ids of montly selected events
            $montlyEvents = $this->eventsModel->getMontlyEvents();
            $yearlyEvents = $this->eventsModel->getYearlyEvents();
            $weeklyEvents = $this->eventsModel->getWeeklyEvents();
            $dailyEvents = $this->eventsModel->getDailyEvents();
            if (count($montlyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($montlyEvents);
                $this->eventsModel->updateMonthOfEvents($eventsIdsDatesForUpdate);
            }
            if (count($yearlyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($yearlyEvents);
                $this->eventsModel->updateYearOfEvents($eventsIdsDatesForUpdate);
            }
            if (count($weeklyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($weeklyEvents);
                $this->eventsModel->updateWeekOfEvents($eventsIdsDatesForUpdate);
            }
            if (count($dailyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($dailyEvents);
                $this->eventsModel->updateDayOfEvents($eventsIdsDatesForUpdate);
            }

            $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
            $upcomingEventsInHour = $this->eventsModel->upcomingSoonInHourEvents();
            if (!$upcomingEventsInHour) {
                $upcomingEventsInHour = [];
            }
            $data['upcomingEventsInHour'] = $upcomingEventsInHour;
            $data['todayEvents'] = $todayEventsCount[0]->count;
        }

        $this->view('pages/index', $data);
    }


    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'App to share posts with other users'
        ];

        if (isset($_SESSION['user_id'])) {
            $todayEventsCount = $this->eventsModel->getCountOfMyTodayEvents();
            $data['todayEvents'] = $todayEventsCount[0]->count;
        }
        $this->view('pages/about', $data);
    }

    public function testPhpWord()
    {
      $phpWord =  new \PhpOffice\PhpWord\PhpWord();

// Adding an empty Section to the document...
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

// Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );

// Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
            $fontStyleName
        );

// Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);

// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $fileAndPath = '/opt/lampp/temp/test.docx';
        $objWriter->save($fileAndPath);



//        THIS WORKS
//        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Type: application/vnd.ms-word');
//        header('Content-Disposition: attachment; filename="hello_world.docx"');
//        $objWriter->save("php://output");
    }

    public function recommend(){
        $this->view('pages/recommend');
    }
}
