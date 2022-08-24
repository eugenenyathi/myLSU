<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>myLSU | Sign In</title>
    <!-- Css-->
    <link rel="stylesheet" href="./css/index.css" />
    <!--Font Awesome-->
    <script src="./fontawesome/js/all.js"></script>
  </head>

  <body>
    <main class="sign-in-container">
      <div class="logo"><img src="./img/lupane.png" alt="" /></div>
      <form>
        <div class="sign-in-input-wrapper">
          <input
            type="text"
            name="studentnumber"
            id="studentnumber"
            placeholder="Student Number"
            class="sign-in-input"
            valsue="L0202873T"
          />
        </div>

        <div class="sign-in-input-wrapper">
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            class="sign-in-input"
            valsue="12345678"
          />

          <a class="eye-icon" id="eye-slash">
            <i class="fas fa-eye-slash"></i>
          </a>
          <a class="eye-icon" id="eye-clear">
            <i class="fas fa-eye"></i>
          </a>
        </div>

        <div class="links">
          <a href="reset-password.php">Forgot password?</a>
        </div>

        <button type="submit" class="login-btn">Sign In</button>
      </form>
    </main>
    <footer class="footer">
      <p>
        Lupane State University Copyright &copy;
        <span class="footer-year">2022</span>. All Rights Reserved.
      </p>
    </footer>
    <script src="./js/index.js"></script>
  </body>
</html>
