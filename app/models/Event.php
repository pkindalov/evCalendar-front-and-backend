<?php

class Event
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addEvent($data){
        print_r($data);
        $this->db->query("INSERT INTO events (text, begin, finish, date, user_id) 
                          VALUES(:text, :begin, :finish, :date, :user_id)");
        $this->db->bind(":text", $data['eventText'], null);                  
        $this->db->bind(":begin", $data['hoursBegin'], null);                  
        $this->db->bind(":finish", $data['hoursFinish'], null);                  
        $this->db->bind(":date", $data['date'], null);                  
        $this->db->bind(":user_id", $_SESSION['user_id'], null); 
        if($this->db->execute()){
            return true;
        }

        return false;
    }

    public function getCurrYearUserEvents(){
        $currentYear = date('Y');
        $user = $_SESSION['user_id'];
        $searched = '%' . $currentYear . '%';

        $this->db->query("SELECT id, date, begin AS `from`, finish AS `to`, text, checkedEvents AS `checked` FROM events WHERE events.user_id = :userId AND events.date LIKE :search");
        $this->db->bind(":userId", $user, null);
        $this->db->bind(":search", $searched, null);

        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return [];
        } else {
            $results = $this->db->resultSet();
            return $results;
        }
        
    }
}
