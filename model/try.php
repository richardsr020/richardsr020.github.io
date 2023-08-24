
<?php
require 'Model.php';
require 'User.php';
require 'Contact.php';

$con = new Contact();
?><pre><?php
$i=0;
while($i < count($con->getAll(22))){
    print_r($con->getAll(22)[$i][0]['id']);
    $i++;
}

?></pre><?php







// session_start();
// require 'File.php';
// $_SESSION['id']=3;

// if(!empty($_FILES)){
//   $file = $_FILES;
//   // print_r($file);
//   //  $ext = strrchr($file['file']['name'], '.');
//   //  print_r($ext);
//   $f = new File($file,'profile',5);
//   $f->upload();
   
// }

?>
<!-- <form action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
  Le champs 'hidden' doit être défini avant le champs 'file' 
  <label>Votre fichier</label> :
  <input type="file" name="file"><br>
  <input type="submit" value="Envoyer">
</form> -->
