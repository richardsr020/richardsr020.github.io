<?php 
class Rout{

    

    public static function signUp(){
        if(!empty($_POST['pass']) && !empty($_POST['phone'])){
            extract($_POST);
            $hashPassWord = sha1($pass);
            $user = new User('',$hashPassWord, $phone);
            $user->insert();
            Rout::logIn();
           
        }else {
            echo'error';
        }
        
    }
    public static function currentSession(){
        if(isset($_SESSION['id'])){
            echo json_encode($_SESSION['id']);
            // return $_SESSION['id'];
        }else{
            echo  json_encode('no session');
            return false;
        }
    }

    public static function logIn(){
        // echo json_encode($_POST);
        if(!empty($_POST['pass']) && !empty($_POST['phone'])){
            extract($_POST);
            $hashPassWord = sha1($pass);
            $user = new User();
            $userdata = $user->getByPhone($phone);
            
               if($userdata[0]['pass'] == $hashPassWord){
                   $_SESSION['id'] = $userdata[0]['id'];
                   $_SESSION['username'] = $userdata[0]['name'];
                   $_SESSION['userprofile'] = $userdata[0]['profile'];
                   $_SESSION['usermail'] = $userdata[0]['mail'];

                   header("location:localhost/nano-api/index.php");
  
                }else{
                   unset($userdata);
                   echo json_encode('not correct');
                   
               }
            
           
        }else {
            echo json_encode('error no data sent from inputs');
        }
    }

    public static function startSession(){
        session_start();
    }

    public static function getProfile(){
        $profile = new User();
        $profileData = $profile->getInfos($_SESSION['id']);
        print_r($profileData);
    }

    public static function getPrivateChatWith($destId){
        $messages = new Msg('',$destId);
        if($messages->getByMarkup()){
            return $privateChat = $messages->getByMarkup();
        
        }

    }

    public static function getChat(){
        $messages = new Msg();
        if($messages->getAll()){
            $chat = $messages->getAll();
            // print_r($chat);
        }

    }
    /**
     * the function logOut clean a current $_SESSION and returne 
     * the link of logInPage 
     */
    public static function logOut(){
        $logOutUser = new User();
        $logInLink = $logOutUser->logOut();
        header("location:".$logInLink);
    }
    public static function sendFile(){
        if(isset($_FILES) && $_FILES['file']['error'] == 0)
        {    
            $file = new File($_FILES,"piece",(int)$_GET["chat"]);
            $file->upload();
            // print_r((int)$_GET["chat"]);
        }

    }
    

    public static function fillProfileInfo($name, $mail,$id){
        $profile= new User();
        $profile->completData($name, $mail, $id);
        if(isset($_FILES) && $_FILES['file']['error'] == 0)
        {    
            $file = new File($_FILES,"profile", (int)$_SESSION['id']);
            $file->upload();
        }
    }
    public static function msgSend(){
            
            if(!empty($_POST['textMsg'])){
                $msg = new Msg($_POST['textMsg'], (int)$_GET['idDest']);
                $msg->send();
                header("location: index.php");
            }
            else{
                echo 'message Filed';
            }
    }
    public static function getFreinds(){
        $freinds = new Contact();
        $freinds->getAll($_SESSION['id']);
        return $freinds->getAll($_SESSION['id']);

        
    }
    public static function addNewContact(){
        $user = new User();

        $NewFreind = $user->getByPhone($_POST['phone']);
        $contact = new Contact($NewFreind[0]['id']);
        $contact->creat();
        header('location: ../../../index.php');
       
    }
}

?>