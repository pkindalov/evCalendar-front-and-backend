<?php

class Event
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addEvent($data)
    {
        // print_r($data);
        $this->db->query("INSERT INTO events (text, begin, finish, date, user_id) 
                          VALUES(:text, :begin, :finish, :date, :user_id)");
        $this->db->bind(":text", $data['eventText'], null);
        $this->db->bind(":begin", $data['hoursBegin'], null);
        $this->db->bind(":finish", $data['hoursFinish'], null);
        $this->db->bind(":date", $data['date'], null);
        $this->db->bind(":user_id", $_SESSION['user_id'], null);
        if ($this->db->execute()) {
            return true;
        }

        return false;
    }

    public function getCurrYearUserEvents()
    {
        $currentYear = date('Y');
        $user = $_SESSION['user_id'];
        $searched = '%' . $currentYear . '%';

        $this->db->query("SELECT id, date, begin AS `from`, finish AS `to`, text, checkedEvent AS `checked`, user_id, showNotification FROM events WHERE events.user_id = :userId AND events.date LIKE :search");
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

    public function getYearUserEvents($year)
    {
        $currentYear = $year;
        $user = $_SESSION['user_id'];
        $searched = '%' . $currentYear . '%';

        $this->db->query("SELECT id, date, begin AS `from`, finish AS `to`, text, checkedEvent AS `checked`, user_id FROM events WHERE events.user_id = :userId AND events.date LIKE :search");
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

    public function updateEvent($eventId, $data)
    {
        $text = $data['eventTextName'];
        $date = $data['editedDate'];
        $begin = $data['hoursBegin'];
        $finish = $data['hoursFinish'];
        $checked = !isset($data['checkedEvent']) ? null : 1;

        $this->db->query('UPDATE events 
                         SET `text` = :eventText, 
                             `begin` = :begin, 
                             `finish` = :finish,
                             `date` = :date,
                             `checkedEvent` = :checked
                          WHERE events.id = :eventId AND events.user_id = :currentUser
                        ');
        $this->db->bind(":eventText", $text, null);
        $this->db->bind(":begin", $begin, null);
        $this->db->bind(":finish", $finish, null);
        $this->db->bind(":date", $date, null);
        $this->db->bind(":checked", $checked, null);
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":currentUser", $_SESSION['user_id'], null);

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function removeEventById($queryData)
    {

        $eventId = htmlspecialchars($queryData['eventId']);
        $author = htmlspecialchars($queryData['author']);

        if (!$_SESSION['user_id'] || $_SESSION['user_id'] !== $queryData['author']) {
            redirect('/');
        }

        $this->db->query('DELETE FROM events WHERE `id` = :eventId AND user_id = :userId');
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $author, null);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function checkUncheckEventById($queryData)
    {
        $eventId = htmlspecialchars($queryData['eventId']);
        $author = htmlspecialchars($queryData['author']);
        $checked = htmlspecialchars($queryData['checked']);
        $checkedValue = $checked == 'false' ? NULL : 1;

        //TO GET CHECKED STATUS OF THE EVENT HERE


        // echo $eventId . "<br />";
        // echo "Before:" . "<br />";
        // echo $checked . "<br >";
        // echo gettype($checkedValue) . "<br />";
        // echo "After:" . "<br />";
        // echo $checked;
        // echo $checkedValue;
        // die();

        if (!$_SESSION['user_id'] || $_SESSION['user_id'] !== $queryData['author']) {
            redirect('/');
        }

        $this->db->query("UPDATE events 
                           SET `checkedEvent` = :checked 
                           WHERE `id` = :eventId AND `user_id` = :author
                           ");
        $this->db->bind(":checked", $checkedValue, null);
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":author", $author, null);

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function showEventFromNotif($eventId)
    {
        $this->db->query("SELECT events.`id`, events.`text`, events.`date`,
                                 events.`begin`, events.`finish`, events.`checkedEvent`
                          FROM events WHERE events.`id` = :eventId AND events.`user_id` = :userId       
        ");
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);

        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return [];
        } else {
            $results = $this->db->resultSet();
            return $results;
        }

        return $results;
    }

    public function turnOffNotif($eventId)
    {
        $this->db->query("UPDATE events SET events.`showNotification` = NULL
                        WHERE events.`id` = :eventId AND events.`user_id` = :userId");
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function turnOnNotif($eventId)
    {
        $this->db->query("UPDATE events SET events.`showNotification` = 1
                        WHERE events.`id` = :eventId AND events.`user_id` = :userId");
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }

    public function getMyEventsByYearAndMonth($year, $month, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $searchedYear = '%' . $year . '-' . $month . '%';
        $this->db->query("SELECT * FROM events
                          WHERE events.date LIKE :year
                          AND events.user_id = :userId
                          ORDER BY events.date DESC
                          LIMIT :limit
                          OFFSET :offset
                         ");
        $this->db->bind(":year", $searchedYear, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $this->db->bind(":limit", $pageSize, null);
        $this->db->bind(":offset", $offset, null);

        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return [];
        } else {
            $results = $this->db->resultSet();
            return $results;
        }

        return $results;
    }


    public function getEventById($eventId)
    {
        $this->db->query("SELECT events.* FROM events WHERE events.id = :eventId");
        $this->db->bind(":eventId", $eventId, null);
        $results = $this->getResults();
        return $results;
    }

    private function getResults()
    {
        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return [];
        } else {
            $results = $this->db->resultSet();
            return $results;
        }

        return $results;
    }

    public function searchEventsByKeyword($keyword, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $searchingStr = '%' . $keyword . '%';
        $this->db->query("SELECT events.* FROM events
                          WHERE events.`text` LIKE :keyword OR events.`date` LIKE :keyword AND events.user_id = :userId
                          LIMIT :limit
                          OFFSET :offset");
        $this->db->bind(":keyword", $searchingStr, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $this->db->bind(":limit", $pageSize, null);
        $this->db->bind(":offset", $offset, null);
        $results = $this->getResults();
        return $results;
    }

    public function getAllMontsStats()
    {
        $monthsCount = 12;
        $year = date('Y');
        $data = [];
        $userId = $_SESSION['user_id'];

        for ($i = 1; $i <= $monthsCount; $i++) {
            $month = $i < 10 ? '0' . $i : $i;
            $date = '' . $year . '-' . $month;
            $keyword = '%' . $date . '%';
            $this->db->query("SELECT COUNT(*) AS count FROM events
                              WHERE events.date LIKE :keyword
                              AND events.user_id = :userId
                              ORDER BY events.date DESC");
            $this->db->bind(":keyword", $keyword, null);
            $this->db->bind(":userId", $userId, null);
            $results = $this->db->execute();
            if ($this->db->rowCount($results) > 0) {
                $results = $this->db->resultSet();
                $data[$date] = [$results[0]->count];
            }

            // print_r($data);
        }
        return $data;
    }

    public function getAllWeekStatsCurrentYear()
    {
        $weeksCount = 52;
        $year = date('Y');
        $data = [];
        $userId = $_SESSION['user_id'];

        for ($i = 1; $i <= $weeksCount; $i++) {
            $weekStartEndArr = getStartAndEndDate($i, $year);
            $weekStart = $weekStartEndArr['week_start'];
            $weekEnd = $weekStartEndArr['week_end'];
            //    $this->db->query("SELECT * FROM events WHERE events.user_id = :userId
            //                      AND events.date
            //                      BETWEEN :weekStart AND :weekEnd ORDER BY events.date;
            //                      ");
            $this->db->query("SELECT COUNT(*) AS count FROM events WHERE events.user_id = :userId 
                             AND events.date 
                             BETWEEN :weekStart AND :weekEnd;
                             ");
            $this->db->bind(":userId", $userId, null);
            $this->db->bind(":weekStart", $weekStart, null);
            $this->db->bind(":weekEnd", $weekEnd, null);
            $results = $this->db->execute();
            if ($this->db->rowCount($results) > 0) {
                $results = $this->db->resultSet();
                $data[$weekStart . '-' . $weekEnd] = [$results[0]->count];
            }
        }

        return $data;
    }

    public function getEventsHappenedOnDay($day, $month)
    {
        $url = "http://history.muffinlabs.com/date/" . $month . "/" . $day;
        $ch = curl_init($url); // such as http://example.com/example.xml
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = json_decode(curl_exec($ch));
        curl_close($ch);
        return $data;
        // print_r($data);
        // $events = extractEventsDataFromAPIData($data);
        // return $events;
    }

    public function getMyTodayEvents($today, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $this->db->query("SELECT * FROM events 
                          WHERE events.date 
                          LIKE :today 
                          AND events.user_id = :userId
                          ORDER BY events.readed
                        --   AND events.readed IS NULL
                          LIMIT :limit
                          OFFSET :offset
                          ");
        $this->db->bind(":today", $today, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $this->db->bind(":limit", $pageSize, null);
        $this->db->bind(":offset", $offset, null);
        $results = getResults($this->db);
        return $results;
    }

    public function markAsReaded($eventId)
    {
        $this->db->query("UPDATE events SET events.readed = 1 WHERE events.id = :eventId AND events.user_id = :userId");
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = execQueryRetTrueOrFalse($this->db);
        return $result;
    }

    public function markAsUnReaded($eventId)
    {
        $this->db->query("UPDATE events SET events.readed = NULL WHERE events.id = :eventId AND events.user_id = :userId");
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = execQueryRetTrueOrFalse($this->db);
        return $result;
    }

    public function getCountOfMyTodayEvents()
    {
        $today = getTodayDateYmdStr();
        $this->db->query("SELECT COUNT(*) AS count FROM events WHERE events.date = :today AND events.user_id = :userId AND events.readed IS NULL");
        $this->db->bind(":today", $today, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = getResults($this->db);
        return $result;
    }

    public function upcomingSoonInHourEvents()
    {
        $today = getTodayDateYmdStr();
        $this->db->query("
                SELECT events.*, CAST(CONCAT(events.date, ' ', events.`begin`) AS DATETIME) AS dt,
                TIME_FORMAT(TIMEDIFF(NOW(),CONCAT(events.date, ' ', events.`begin`)),'%H:%i:%s') AS timeleft
                FROM events
                WHERE events.date = :today 
                AND
                CAST(TIME_FORMAT(TIMEDIFF(NOW(), CAST(CONCAT(events.date, ' ', events.`begin`) AS DATETIME)),'%H') AS INT) >= -1
                AND
                CAST(TIME_FORMAT(TIMEDIFF(NOW(), CAST(CONCAT(events.date, ' ', events.`begin`) AS DATETIME)),'%H') AS INT) <= 0 
                AND
                CAST(TIME_FORMAT(TIMEDIFF(NOW(), CAST(CONCAT(events.date, ' ', events.`begin`) AS DATETIME)),'%i') AS INT) <= 0 
                AND events.user_id = :userId
        ");
        $this->db->bind(":today", $today, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = getResults($this->db);
        return $result;
    }

    public function moveEventByDate($eventId, $editedDate)
    {
        $this->db->query("UPDATE events SET events.date = :date 
                              WHERE events.id = :eventId 
                              AND events.user_id = :userId ");
        $this->db->bind(":date", $editedDate, null);
        $this->db->bind(":eventId", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        return execQueryRetTrueOrFalse($this->db);
    }

    public function makeEventMonthly($eventId)
    {
        $this->db->query("UPDATE events SET events.isMonthly = 1 WHERE events.id = :id AND events.user_id = :userId");
        $this->db->bind(":id", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        return execQueryRetTrueOrFalse($this->db);
    }

    public function makeEventNotMonthly($eventId)
    {
        $this->db->query("UPDATE events SET events.isMonthly = NULL WHERE events.id = :id AND events.user_id = :userId");
        $this->db->bind(":id", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        return execQueryRetTrueOrFalse($this->db);
    }

    public function makeEventYearly($eventId)
    {
        $this->db->query("UPDATE events SET events.isYearly = 1 WHERE events.id = :id AND events.user_id = :userId");
        $this->db->bind(":id", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        return execQueryRetTrueOrFalse($this->db);
    }

    public function makeEventNotYearly($eventId)
    {
        $this->db->query("UPDATE events SET events.isYearly = NULL WHERE events.id = :id AND events.user_id = :userId");
        $this->db->bind(":id", $eventId, null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        return execQueryRetTrueOrFalse($this->db);
    }

    public function getMontlyEvents()
    {
        $this->db->query("SELECT events.id, events.date 
                             FROM events 
                             WHERE events.isMonthly = 1 
                             AND events.user_id = :userId
                             
                             ");
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = getResults($this->db);
        return $result;
    }

    public function getYearlyEvents()
    {
        $this->db->query("SELECT events.id, events.date 
                             FROM events 
                             WHERE events.isYearly = 1 
                             AND events.user_id = :userId
                             
                             ");
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $result = getResults($this->db);
        return $result;
    }

    public function updateMonthOfEvents($idsNum)
    {
        foreach ($idsNum as $key => $value) {
            // echo $value['date'] . '<br />' . date('Y-m-d');
            // echo $value['date'] < date('Y-m-d');
            if ($value['date'] <= date('Y-m-d') == 1) {
                $this->db->query("UPDATE events 
                                  SET events.`date` = (
                                  SELECT DATE_ADD(CAST(events.`date` AS DATE), INTERVAL 1 MONTH) AS newDate
                                  FROM events
                                  WHERE events.id = :eventId)
                                  WHERE events.id = :eventId AND events.user_id = :userId;");
                $this->db->bind(":eventId", $value['id'], null);
                $this->db->bind(":userId", $_SESSION['user_id'], null);
                $this->db->execute();
            }
        };
    }
    public function updateYearOfEvents($idsNum)
    {
        foreach ($idsNum as $key => $value) {
            // echo $value['date'] < date('Y-m-d') . '<br />';
            if ($value['date'] <= date('Y-m-d') == 1) {
                $this->db->query("UPDATE events 
                                  SET events.`date` = (
                                  SELECT DATE_ADD(CAST(events.`date` AS DATE), INTERVAL 1 YEAR) AS newDate
                                  FROM events
                                  WHERE events.id = :eventId)
                                  WHERE events.id = :eventId AND events.user_id = :userId;");
                $this->db->bind(":eventId", $value['id'], null);
                $this->db->bind(":userId", $_SESSION['user_id'], null);
                $this->db->execute();
            }
        };
    }

}
