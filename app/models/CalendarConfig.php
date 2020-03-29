<?php
class CalendarConfig
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUsersSettingsById()
    {
        $this->db->query('SELECT settings.`language`, settings.`usingThemes`, languages.title FROM settings
        JOIN languages ON  languages.id = settings.`language`
        WHERE settings.user_id = :userId');

        $this->db->bind(":userId", $_SESSION['user_id'], null);
        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return false;
        } else {
            $results = $this->db->resultSet();
            return $results;
        }
    }

    public function getAllLanguages(){
        $this->db->query("SELECT * FROM languages");
        $results = $this->db->execute();
        if ($this->db->rowCount($results) == 0) {
            return false;
        } else {
            $results = $this->db->resultSet();
            return $results;
        }
    }

    public function saveUserSettings($data){
        $this->db->query("UPDATE settings SET `language` = :languageId, `usingThemes` = :usingThemes WHERE `user_id` = :userId");
        $this->db->bind(":languageId", $data['languageId'], null);
        $this->db->bind(":usingThemes", $data['usingThemes'], null);
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        if($this->db->execute()){
            return true;
        }

        return false;
    }

    public function createDefaultUserCalSettings(){
        $this->db->query("INSERT INTO settings (`user_id`, `language`, `usingThemes`) VALUES (:userId, 1, NULL)");
        $this->db->bind(":userId", $_SESSION['user_id'], null);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
}
