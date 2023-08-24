<?php
//require 'Model.php';
//include 'User.php';
class Contact extends Model{
    private $authorId;
    private $destId;
    private $currentUserId;

    public function __construct($dest=null){
        $this->authorId = $_SESSION['id'];
        $this->destId = $dest;
    }
    public function getByMarkup($markup){
      /**
       * cette fonction nous servira a verifier si un contact n'a pas encpore ete creer
       * si ce contact est dejà crée alors il renvoi true sinon c'est false
      */
        $this->connect();
        $contactMarkup = $markup; 
        $ps = $this->pdo->prepare("SELECT * FROM contact WHERE markup=?");
        $ps->execute([$markup]);
        $response = $ps->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($response)){
            //if user's data has fund requesteError will be at TRUE or 1
            return true;
        }
        else{
            return false;
        }

    }
    public function creat(){
        /**
         * Ici se fait la creation de contact
         */
        $newMarkup = $this->authorId.$this->destId;
        $this->connect();
        // la verification d'un contact existant on cree si ce contact n'existe pas.
        if(!$this->getByMarkup($newMarkup)){
            $ps = $this->pdo->prepare("INSERT INTO contact(first,second,markup) VALUES(?,?,?)");
            $ps->execute([$this->authorId,$this->destId,$newMarkup]);
        }else{
            return false;
        }
        
    }
    public function delete($markup){
        $this->connect();
        if($this->getByMarkup($markup)){
            $ps = $this->pdo->prepare("DELETE FROM contact WHERE markup = ?");
            $ps->execute([$markup]);
            return true;
        }else{
            return false;
        }
    }
    public function getAll($id){
        $this->connect(); 
        $ps = $this->pdo->prepare("SELECT second FROM contact WHERE first=? OR second=?");
        $ps->execute([$id,$id]);
        $idlist = $ps->fetchAll();
        $contactsList = [];
        $i = 0;

       while($i < count($idlist)){
            $contacts = new User();
            $contactsList[$i] = $contacts->getInfos($idlist[$i]['second']);
            $i++;
        }
         if($contactsList){
            
            return $contactsList;

           }else{
           return [];
            
       }
        
        
    }
}



?>