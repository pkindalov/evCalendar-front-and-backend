<?php
class CalendarConfigs extends Controller
{
    private $calConfigModel;

    public function __construct()
    {
        $this->calConfigModel = $this->model('CalendarConfig');
    }

    public function userSettings()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }

        $userSettings = $this->calConfigModel->getUsersSettingsById();
        if(empty($userSettings)){
            $createUserDefaultSettings = $this->calConfigModel->createDefaultUserCalSettings();
            if($createUserDefaultSettings){
                $userSettings = $this->calConfigModel->getUsersSettingsById();
            }
        }
        $allLanguages = $this->calConfigModel->getAllLanguages();
        $data = ['language' => 'bg', 'languageId' => 2, 'usingThemes' => true, 'allLanguages' => $allLanguages];


        if (isset($userSettings) && !empty($userSettings)) {
            $data = [
                'language' => $userSettings[0]->title,
                'languageId' => $userSettings[0]->language,
                'usingThemes' => $userSettings[0]->usingThemes,
                'allLanguages' => $allLanguages
            ];
        }

        // print_r($data);
        $this->view('calendar/calendarConfig', $data);
    }

    public function makeUserSettings()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/');
        }

        if (!isset($_POST) || empty($_POST)) {
            redirect('/');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $usingThemes = !isset($_POST['usingThemes']) ? null : $_POST['usingThemes'];
        
        $data = ['languageId' => $_POST['language'], 'usingThemes' => $usingThemes == 'on' ? true : null];

        $this->calConfigModel->saveUserSettings($data);
        redirect('/');
    }
}
