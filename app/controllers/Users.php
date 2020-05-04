<?php

require_once APPROOT . '/libraries/PhpMailSender.php';

class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->phpMailer = new PhpMailSender(MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD);
        $this->phpMailer->setCharset(CHARSET);
    }

    public function register()
    {
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Proces form

            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }
            //Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                //Check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'This email is already taken. Please enter another.';
                }
            }

            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter passord';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            //Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] !== $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords don\'t match';
                }
            }

            //Make sure errors are empty
            if (
                empty($data['email_err']) &&
                empty($data['name_err']) &&
                empty($data['password_err']) &&
                empty($data['confirm_password_err'])
            ) {
                //Validated

                //Hasing password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered successfully. You can login in your profile now');
                    redirect('users/login');
                } else {
                    die('Something goes wrong');
                }
                // die('SUCCESS');
            } else {
                $this->view('users/register', $data);
            }
        } else {
            //Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //Load view
            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Proces form
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            //Validate Email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }


            //Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter passord';
            }

            //Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                //User found
            } else {
                $data['email_err'] = 'No user found.';
            }

            //Make sure errors are empty
            if (
                empty($data['email_err']) &&
                empty($data['password_err'])
            ) {
                //Validated
                //Check and set logged users
                $loggedUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedUser) {
                    //Create Session
                    $this->createUserSession($loggedUser);
                } else {
                    $data['password_err'] = 'Email or Password incorrect';
                    $this->view('users/login', $data);
                }
            } else {
                $this->view('users/login', $data);
            }
        } else {
            //Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            //Load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
    }

    public function createUserSessionWithoutRedirect($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }

    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function fbLogin()
    {

        if (!$_SERVER['REQUEST_METHOD'] === 'POST') {
            redirect('/');
        }

        if (!isset($_POST)) {
            redirect('/');
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $userEmail = htmlspecialchars($_POST['email']);

        if ($this->userModel->findUserByEmail($userEmail)) {
            $loggedUser = $this->userModel->fbLogin($userEmail);
            if (isset($loggedUser)) {
                $this->createUserSessionWithoutRedirect($loggedUser);
                echo json_encode(['success' => true]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
    }

    public function fbLoginProblem()
    {
        $this->view('users/fbLoginProblem');
    }

    public function sendMail(){
       try{
              
           $this->phpMailer->setIsSMTP();
           $this->phpMailer->setSMTPAuth(SMTP_AUTH);
           $this->phpMailer->setSMTPSecure(SMTP_SECURE);
           $this->phpMailer->setIsHTML(IS_HTML);
           $this->phpMailer->setFrom(SET_FROM);
           $this->phpMailer->setSubject("Пращам това от сървъра");
           $this->phpMailer->setBody("Пробвам да видя дали да включа библиотеката в проекта");
           $this->phpMailer->setReceiver("ponko88@abv.bg");
           $this->phpMailer->setMsgSentSuccess('Message sent successfully!');

        //    var_dump($this->phpMailer);
           echo $this->phpMailer->sendMail();
        // var_dump(method_exists($this->phpMailer, 'IsSMTP'));

       } catch(Exception $e){
         echo "Message could not be sent. Mailer Error: {$this->phpMailer->getError()}";
       } 
       

    }
}
