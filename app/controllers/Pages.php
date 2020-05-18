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
            if (count($montlyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($montlyEvents);
                $this->eventsModel->updateMonthOfEvents($eventsIdsDatesForUpdate);
            }
            if (count($yearlyEvents)) {
                $eventsIdsDatesForUpdate = getIdsAndDates($yearlyEvents);
                $this->eventsModel->updateYearOfEvents($eventsIdsDatesForUpdate);
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
}
