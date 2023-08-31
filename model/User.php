<?php
//require 'Model.php';
class User extends Model{
    private $name;
    private $passW;
    private $phonneN;
    
    public function __construct($userName=null, $password=null, $phonneN=null){
       $this->name = $userName;
       $this->passW = $password;
       $this->phonneN=$phonneN;
        
    }
    public function getById($id){
        $this->connect();
        $userId = $id; 
        $ps = $this->pdo->prepare("SELECT * FROM user WHERE id=?");
        $ps->execute([$userId]);
        if($ps->fetchAll()){
            //if user's data has fund requesteError will be at TRUE or 1
            return true;
        }
        else{
            return false;
        }

    }
    public function getByMail($mail){
        $this->connect();
        $userMail = $mail; 
                $ps = $this->pdo->prepare("SELECT * FROM user WHERE mail=?");
                $ps->execute([$userMail]);
                $userData = $ps->fetchAll(PDO::FETCH_ASSOC);
                if($userData){
                //if user's data has fund requesteError will be at TRUE or 1
                    return $userData;
                }
                else{return false;}
    }
    public function getByPhone($number){
            $userphone = $number; 
            $this->connect();
            $ps = $this->pdo->prepare("SELECT * FROM user WHERE phone=?");
            $ps->execute([$userphone]);
            $data = $ps->fetchAll(PDO::FETCH_ASSOC);
            if(!empty($data)){
            //if user's data has fund requesteError will be at TRUE or 1
                return $data;
            }
            else{
                return false;
                die;
            }
    }
   
    public function insert(){
        //$this->connect();
        if(empty($this->getByPhone($this->phonneN))){
            $ps = $this->pdo->prepare("INSERT INTO user(name,phone,pass,) VALUES(?,?,? )");
            $ps->execute([$this->name,$this->phonneN,$this->passW]);
            return true;
        } else{
            return false;
        }
        
    }
    /**
     * To delete user, put 1 in the active entry in database 
     */
    
    public function delete($id){
        $this->connect();
        $ps = $this->pdo->prepare("UPDATE user SET active=1 WHERE id=?");
        $ps->execute([$id]);   
    }
    /**
     * Can update data in the database 
     * field : Entry in the database 
     * Value : data to update
     * Id    : Id of user 
     */
    public function update($field,$value,$id){
        $this->connect();
        $ps = $this->pdo->prepare("UPDATE user SET $field = '$value' WHERE id =?");
        if($ps->execute([$id])){
            return 1;
        } else{
            return 0;
        }
        
    }
    public function getInfos($id){
        $this->connect();
        $userId = $id; 
        $ps = $this->pdo->prepare("SELECT id,name,profile FROM user WHERE id=?");
        $ps->execute([$userId]);
        $result = $ps->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result)){
            //if user's data has fund requesteError will be at TRUE or 1
           return $result[0];
        }else{ return false;}
       
    }
    
    public function validUser($data){
        $i = 0;
        while($i < count($data)){
            if($data[$i] == ''){
                break;
                return false;
            }
            //print_r($data);
            $i++;
            
        }
        //print_r($value);
     // return true;
    }
    public function logOut(){
        if(isset($_SESSION['id'])){
            unset($_SESSION['id']);
            session_destroy();
            if(!isset($_SESSION)){
                 return '../../../index.php';

            }
        }
    }

     public function completData ($name,$id)

     { 
            $this->connect();
            $ps = $this->pdo->prepare("UPDATE user SET name =?, mail=? WHERE id =?");
            $ps->execute([$name, $id]);

     }
    
}


?>