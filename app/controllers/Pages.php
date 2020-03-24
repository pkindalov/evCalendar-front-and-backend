<?php
class Pages extends Controller{

    public function __construct()
    {

    } 

    public function index(){
        $data = [
            'title' => 'evCalendar',
            'description' => 'Simple event calendar to remind you for a simple things/tasks',
        ];
        
        $this->view('pages/index', $data);
    }


    public function about(){
       $data = [
           'title' => 'About Us',
           'description' => 'App to share posts with other users'
        ];  
       $this->view('pages/about', $data);
    }

}