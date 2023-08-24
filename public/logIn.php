<?php require "../assets/partials/header.php";?> 
<!-- Pills navs -->
<ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
  <li class="container-fluid  bg-primary" role="presentation">
    <h4 class="text-center text-white">Se connecter au panneau d'administrateur</h4>
  </li>
  
</ul>
<!-- Pills navs -->

<!-- Pills content -->
<div class="tab-content">
  <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
    <form>
      <div class="text-center mb-3">
        <p>Sign in with:</p>
        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-facebook-f"></i>
        </button>

        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-google"></i>
        </button>

        <button type="button" class="btn btn-link btn-floating mx-1">
          <i class="fab fa-twitter"></i>
        </button>

      
      </div>

      <p class="text-center">or:</p>

      <div class="container col-md-6">

          <form  method="POST" action="">
                  <!-- Email input -->
              <label class="form-label" for="loginName">Admin</label>
              <input type="text" name="loginName" id="loginName" class="form-control mb-4" />
              
                <!-- Password input -->
              
              <label class="form-label" for="loginPassword">Mot de passe</label>
              <input type="password" name="loginPassword" id="loginPassword" class="form-control mb-4" />
                

                <!-- 2 column grid layout -->
                <div class="row mb-4">
                  <div class="col-md-6 d-flex justify-content-center">
                    <!-- Simple link -->
                    <a href="#!">Forgot password?</a>
                  </div>
                </div>

          <!-- Submit button -->
              <input type="submit" name ="submit" class="btn btn-primary mb-4">



          </form>


      </div>

        <!-- Register buttons -->
      
<?php require "../assets/partials/footer.php";?> 
