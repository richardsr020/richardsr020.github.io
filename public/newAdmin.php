<?php require "../assets/partials/header.php";?> 
<!-- Pills navs -->
<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
  <li class="container-fluid  bg-primary" role="presentation">
    <h4 class="text-center text-white">Ajouter un administrateur</h4>
  </li>
  
</ul>

      <div class="container col-md-6">

          <form  method="POST" action="">
                  <!-- User name input -->
              <label class="form-label" for="loginName">Nom du Nouveau Admin</label>
              <input type="text" name="loginName" id="loginName" class="form-control mb-4" />

              <!-- phone input -->
              <label class="form-label" for="loginPone">Phone</label>
              <input type="text" name="loginPone" id="loginPone" class="form-control mb-4" />
              
                <!-- Password input -->
              <label class="form-label" for="loginPassword">Mot de passe</label>
              <input type="password" name="loginPassword" id="loginPassword" class="form-control mb-4" />
                

                <!-- 2 column grid layout -->
                <div class="row mb-4">
                  <div class="col-md-6 d-flex justify-content-center">
                    <!-- Simple link -->
                    <a href="">Forgot password?</a>
                  </div>
                </div>

          <!-- Submit button -->
              <input type="submit" name ="submit" class="btn btn-primary mb-4">



          </form>


      </div>

        <!-- Register buttons -->
      
<?php require "../assets/partials/footer.php";?> 
