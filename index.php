<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home | Smile Hero Clinic</title>
    <link rel="stylesheet" href="src/dist/styles.css" />
  </head>
  <body class="homepage">
    <main>
      <?php include("nav.php"); ?>

      <header>
        <div class="header-container">
          <div class="header-texts">
              <h1>
                Seamless <strong>smiles</strong> begin here
              </h1>
              <p>
                Expert dental care for a confident, healthy smile.
                Streamlined dental appointments for your convenience
              </p>
            </div>
            
            <div class="form-links">
              <li><a href="signup.php" class="signup-link">Create an account</a></li>
            <li><a href="login.php" class="login-link">Login</a></li>
          </div>
        </div>

        <div class="image-container">
          <img src="././assets/landing-page/hero-images.png" alt="hero-image">
        </div>
      </header>
    </main>
    <?php include("footer.php"); ?>
  </body>
  <script src="././js/nav.js"></script>
</html>
