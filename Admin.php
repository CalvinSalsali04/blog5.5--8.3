<?php


namespace TestProject\Controller;

class Admin extends Blog
{
    public function login(): void // needed to declare return type
    {
        if ($this->isLogged())
            header('Location: ' . ROOT_URL . '?p=blog&a=all');
            exit; // dont want more of script to run 

        if (isset($_POST['email'], $_POST['password']))
        {
            $this->oUtil->getModel('Admin');
            $this->oModel = new \TestProject\Model\Admin(); // when instanstiating class

            $sHashPassword =  $this->oModel->login($_POST['email']);
            if (password_verify($_POST['password'], $sHashPassword))
            {
                $_SESSION['is_logged'] = 1; 
                header('Location: ' . ROOT_URL . '?p=blog&a=all');
                exit;
            }
            else
            {
                $this->oUtil->sErrMsg = 'Incorrect Login!';
            }
        }

        $this->oUtil->getView('login');
    }

    public function logout()
    {
        if (!$this->isLogged())
            exit;

        
        if (!empty($_SESSION))
        {
            
            session_unset(); //no need for $_SESSION = array(); it's redundant
            session_destroy();
        }

        
        header('Location: ' . ROOT_URL);
        exit;
    }
}