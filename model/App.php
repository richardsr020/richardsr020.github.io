<?php 
class App{

    public static function fillProfile($targetField){
        if(isset($_POST['submit']) && !empty($targetField)){
            $user = new User();
            if($user->update($targetField,$_POST[$targetField],$_SESSION['id'])){
                echo 'update successfuly';
            }else{
                echo 'Update error';
            }
        }
        
    }

    public static function sendFile(){
        if(isset($_FILES) && isset($_GET['fileType']) && isset($_GET['destId'])){
            $file = new File($_FILES, $_GET['fileType'], $_GET['destId']);
            $file->upload();

        }
       
    }

    public static function signUp(){
        if(isset($_POST['submit'])){
            $errors = [];
            if(!empty($_POST['pass']) && !empty($_POST['mail']) && !empty($_POST['phone'])){
                extract($_POST);
                $hashPassWord = sha1($pass);
                $user = new User('',$hashPassWord, $phone,$mail);
                if($user->insert()){
                        $userdata = $user->getByMail($mail);
                            $_SESSION['id'] = $userdata[0]['id'];
                            print_r($_SESSION['id']);

                }
               
            }else {
                echo'error';
            }

        }
            
    }
    /**
     * logIn interface that using the User class 
     * to log the user
     */

    public static function logIn(){
        if(isset($_POST['submit'])){
            if(!empty($_POST['pass']) && !empty($_POST['mail'])){
                extract($_POST);
                $hashPassWord = sha1($pass);
                $user = new User();
                if($user->getByMail($mail)){
                   $userdata = $user->getByMail($mail);
                   if($userdata[0]['pass'] === $hashPassWord){
                       
                       $_SESSION['id'] = $userdata[0]['id'];
                       print_r($_SESSION['id']);
                   }else{
                       unset($userdata);
                       echo 'not correct';
                   }
                }
               
            }else {
                echo'error';
            }
        }
    }

    public static function startSession(){
        session_start();
    }
    public static function logOut(){
        $loginLink = User::logout();
        echo $loginLink;

    }

    public static function getProfile(){
        $profile = new User();
        $profileData = $profile->getInfos($_SESSION['id']);
        print_r($profileData);
    }
    /**
     * this is the methode to get the chat with someone 
     */
    public static function getPrivateChat($idContact){
        $chat = new Msg('',$idContact);
        print_r($chat->getByMarkup());
    }
    /**
     * the function to ge all the message
     */
    public static function getChat(){
        $chat = new Msg();
        print_r($chat->getAll());
        

        
    }
    public static function messageSend(){
     
    }
}

?>