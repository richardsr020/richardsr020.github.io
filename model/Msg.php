<?php 
// require 'Model.php';
// require 'Contact.php';
class Msg extends Model{
    private $text;
    private $destId;
    private $authorId;

    public function __construct($textMessage=null,$destId=null){
        $this->text = $textMessage;
        $this->destId = $destId;
        $this->authorId = $_SESSION['id'];

    }
    /**
     * this function make a markup for message table a pieces table in database
     * if $reverse has 0, the function return a correct markup ex(12)
     * else if $reverse has 1, the function return a reverse markup ex(21) 
     */
    public function makMarkup($reverse=0){
        if($reverse == 0){
            return $this->authorId.$this->destId;
        }elseif($reverse == 1){
            return $this->destId.$this->authorId;
        }
        
    }
    
    public function send(){
        /**
         * here is insersion of messages in chat table, 
         * after that there is a private function called into the 
         * the current function which create a contact among the author
         * of message and destinator it the function <<createContact>>
         */
        $this->connect();
        $newMarkup = (int)$this->makMarkup();
        $ps = $this->pdo->prepare("INSERT INTO chat(text,id_author,id_destination,markup,is_read) VALUES(?,?,?,?,?)");
        $ps->execute([$this->text,$this->authorId,$this->destId,$newMarkup,0]);
        print_r(gettype($newMarkup));
        //We verify before if this the contact do not exist 
        /**
         * the call of createContact
         */
        $contact = new Contact($this->authorId, $this->destId);
        $contact->creat($newMarkup);

    }
    public function getByMarkup(){
        $this->connect();
        $markup = $this->makMarkup();
        $markupReverse = $this->makMarkup(1);
        $ps = $this->pdo->prepare("SELECT * FROM chat WHERE markup=? OR markup=?");
        $ps->execute([$markup,$markupReverse]);
        $result = $ps->fetchAll(PDO::FETCH_ASSOC);
        if($result){
            return $result;
        }
        else{
            echo 'nothig'; 
            return false;}

    }
    /**
     * theire we can get all the messages sent to the
     * current user
     */

    public function getAll(){
        $this->connect();
        $myId = $this->authorId;
        $ps = $this->pdo->prepare("SELECT * FROM chat WHERE id_destination=?");
        $ps->execute([$myId]);
        $result = $ps->fetchAll(PDO::FETCH_ASSOC);
        
        if($result){
            return $result;
        }
        else{ return false;}

    }
    public function update($field,$value,$id){
        $this->connect();
        $ps = $this->pdo->prepare("UPDATE chat SET $field = '$value' WHERE id =?");
        $ps->execute([$id]); 
        
    }
}

// $msg=new Msg('salut les amies', 27);
// $msg->send();
?>