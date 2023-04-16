<!DOCTYPE html>
<html>
  <head>
    <title>Home Page</title>
    <?php include('boilar_plate/custom_import.php') ?>
  </head>
  <body>
  <?php include('boilar_plate/header.php') ?>
    <div class="container">
      <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <fieldset>
            <legend>Login</legend>

            <form>
              <!-- Email input -->
              <div class="form-outline mb-4">
                <input type="text" class="form-control" />
                <label class="form-label">User Name </label>
              </div>

              <!-- Password input -->
              <div class="form-outline mb-4">
                <input
                  type="password"
                  id="form2Example2"
                  class="form-control"
                />
                <label class="form-label" for="form2Example2">Password</label>
              </div>

              <!-- Submit button -->
              <button type="button" class="btn btn-primary btn-block mb-4">
                Sign in
              </button>

              <!-- Register buttons -->
              <div class="text-center">
                <p>Not a member? <a href="#!">Register</a></p>
                <p>or sign up with:</p>
                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-facebook-f"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-google"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-twitter"></i>
                </button>

                <button type="button" class="btn btn-link btn-floating mx-1">
                  <i class="fab fa-github"></i>
                </button>
              </div>
            </form>
          </fieldset>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
    <?php include('boilar_plate/footer.php') ?>
  </body>
</html>
