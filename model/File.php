<?php 
    
    class File extends Model{
        private $piecesDir = 'model/upload/pieces/';
        private $profileDir='model/upload/profiles/';
        public $name; // the file name sa an example : myImage.png
        public $file; // the temp_name directory
        public $maxSize = 10000000; // the max size wich can beuploaded
        public $size; // a size of uploaded file 
        private $validExt = array('png', 'gif', 'jpg','rar','docx','xlx','pdf','jpeg');
        public $fileType; //the fileType give us information on the directory where to stock the current file
        public $error;
        private $authorId; // the id authore store the $_SESSION id of the current user
        private $destId; // the destId store an Id of dest User
        private $newFileName; // store the name with an uniqueId that's the new fileName in upload directorie

       
        //Début des vérifications de sécurité...
        /**
         * the construct has 3 parameters
         * $global :An array that content file's information from $FILE
         * $type   : it give the type of file to lead file in bettter directory(piece,profile)
         * $destination : the id of destinator
         */
        public function __construct($global, $type,$destination){
            print_r(($global));
            $this->name = $global['file']['name'];
            $this->size = $global['file']['size'];
            $this->file = $global['file']['tmp_name'];
            $this->fileType = $type;
            $this->authorId = $_SESSION['id'];
            $this->destId = $destination;

        }
        /**
         * the markup is as a uniqueId of a message. by witch we can get a 
         * specific message in database. the markup has to elements : 
         * the first is the id of current user
         * the second is the id of destinator user
         */
        public function makMarkup(){
            return $this->authorId.$this->destId;
        }
         /**
             * here is insersion of file in pices table, 
             * after that theire is a private function called into the 
             * the current function which create a contact among the author
             * of message and destinator it's the function <<createContact>>
        */

        public function send(){
    
            $this->connect();
            $newMarkup = $this->makMarkup();
            /*On insere la pieces jointe dans la table de pieces puis dans la table de messages */
            $ps = $this->pdo->prepare("INSERT INTO piece(name,id_author,id_destination,markup,is_read) VALUES(?,?,?,?,?)");
            $ps->execute([$this->newFileName,$this->authorId,$this->destId,$newMarkup,0]);

            $ps = $this->pdo->prepare("INSERT INTO chat(joinedPiece,id_author,id_destination,markup,is_read) VALUES(?,?,?,?,?)");
            $ps->execute([$this->newFileName,$this->authorId,$this->destId,$newMarkup,0]);
            //We verify before if this the contact do not exist 
            /**
             * the call of createContact
             */
            $contact = new Contact($this->authorId, $this->destId);
            $contact->creat($newMarkup);
    
        }
        /**
         * cette fonction revoie l'extension du fichier uploadé
         */

        public function getExt($name){
            return $extension = strrchr($name, '.');;

        }
        /**
         * cette fonction se charge de mettre en ligne un fichier
         * donc de les deplacer dans les dossiers de pieces jointes
         * du site ensuite inserer son nom dans la base de donnees
         */
        public function upload(){
            if(!in_array($this->getExt($this->name), $this->validExt)) 
            //Si l'extension n'est pas dans le tableau
            {
                $this->error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
            
                if($this->size < $this->maxSize){
                    //$erreur = 'Le fichier est trop gros...';
            
            
                    //On formate le nom du fichier ici...
                    $this->newFileName = $this->fileType.uniqid().$this->name;
                    //if file is a piece joined, it'll move in the pieces directorie
                    if($this->fileType == 'piece'){
                        
                        if(move_uploaded_file($this->file, $this->piecesDir.$this->newFileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                        {
                        echo 'Upload  de la piece effectué avec succès !';
                        $this->send();
                        }
                        else //else( the fonction put an error into error property)..
                        
                        {
                         $this->error = 'upload Failed';
                        }

                    }
                    //if the piece is a profile image, it'll move to the profile directory
                    if($this->fileType == 'profile'){
                        
                        if(move_uploaded_file($this->file, $this->profileDir.$this->newFileName)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                        {   $user = new User();
                            $user->update('profile', $this->newFileName, $_SESSION['id']);
                            echo 'Upload effectué avec succès !';
                        }
                        else //else( the fonction put an error into error property).
                        {

                            $this->error = 'upload Failed';
                        }

                    }
                  
              
                }else {
                    $this->error = 'large Size';
                }
            }
        }
        /**
         * cette fonction renvoie la taille du fichier
         * venant d'etre uploadé
         */
        public function getSize(){
            return $this->size;
        }
        /**
         * cette fonction localise un fichier dans
         * les dossiers du site a partire du nom de fichier
         * provenant de la base de donnée
         */
        public static function getLink($fileName){
            if(strpos($fileName,'profile',0) === 0){
                   return 'model/upload/profile/'.$fileName;
            }
            elseif(strpos($fileName,'piece',0) === 0){
                return 'model/upload/pieces/'.$fileName;
            }
        }

    }
?>