<?php require_once __DIR__ . '/controller/plant/display.php'; ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="./public/logo/logo-1.png" />
    <link rel="stylesheet" href="./public/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Botanica</title>
  </head>
  <body>
    <!-- <div id="app"></div> -->
    <script type="module" src="/src/main.js"></script>

    <div class="section-1">
      <header class="header">
        <div class="logo-container">
          <img src="./public/logo/logo-2.png" alt="logo" class="logo" />
        </div>

        <input type="checkbox" id="menu-toggle" class="menu-toggle" />
        <label for="menu-toggle" class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </label>

        <nav class="main-menu">
          <div class="menu-items">
            <a href="">Home</a>
            <a href="">Cart</a>
            <a href="./view/profile.php">My Profile</a>
            <a href="./view/login.php"><img src="./public/icons/login.gif" alt=""></a>
          </div>
        </nav>
      </header>

      <div class="banner">
        <div class="left-span">
          <h1 class="title-1">Bring the nature close to you</h1>
          <p class="description">
            Botanica brings nature indoors with a curated selection of lush
            indoor and herbal plants. From air-purifying greens to aromatic
            herbs, we help you create a fresh, healthy, and vibrant living
            space. Grow wellness and beauty—naturally.
          </p>
          <button class="buttons">
            Discover now <img src="./public/icons/arrow-right.png" alt="arrow" />
          </button>
        </div>

        <img src="./public/icons/ficus.png" class="banner-img" alt="ficus" />
      </div>
    </div>

    <div class="lower-banner">
      <div class="content">
        <img src="./public/icons/shipped (1).png" alt="" />
        <div class="content-description">
          <h2 class="title">Free Delivery</h2>
          <p class="description">Enjoy free delivery on all orders over 25€!</p>
        </div>
      </div>

      <div class="content">
        <img src="./public/icons/credit-card (1).png" alt="" />
        <div class="content-description">
          <h2 class="title">Safe Payment</h2>
          <p class="description">
            Shop with confidence — secure payment guaranteed!
          </p>
        </div>
      </div>

      <div class="content">
        <img src="./public/icons/in-love (1).png" alt="" />
        <div class="content-description">
          <h2 class="title">Friendly Services</h2>
          <p class="description">
            Experience friendly and reliable customer service every time!
          </p>
        </div>
      </div>
    </div>

    <div class="card-display">
      <div class="card">
        <div class="card-content">
          <p class="tag">Big Sale Products</p>
          <h3 class="title">Indoor Plants</h3>
        </div>

        <img src="./public/indoor-plant.png" class="plant-img" alt="" />
      </div>

      <div class="card">
        <div class="card-content">
          <p class="tag">Top Products</p>
          <h3 class="title">Herbal Plants</h3>
        </div>
        <img src="./public/herbal-plant.png" class="plant-img" alt="" />
      </div>
    </div>

    <div class="products-gallery">
      <h2 class="title">Our Products</h2>
      <div class="products-container">
        <ul class="tags">
          <li><a class="tag-element" href="">WHAT'S NEW</a></li>
          <li><a class="tag-element" href="">BEST SELLERS</a></li>
          <li><a class="tag-element" href="">CUSTOMER FAVOURITES</a></li>
        </ul>

        
      <?php
foreach ($plants as $plant) {
    echo '<div class="card">';
    echo '  <div class="img-container">';
    echo '<form action="../controllers/cart_controller.php" method="POST">';
    echo '    <input type="hidden" name="action" value="add_to_cart">';
    echo '    <input type="hidden" name="plant_id" value="' . htmlspecialchars($plant['id']) . '">';
    echo '    <button type="submit" class="like-btn">';
    echo '        <img src="./public/icons/cart.png" alt="" />';
    echo '    </button>';
    echo '</form>';
    echo '    <img src="./public/plants/' . htmlspecialchars($plant['image_url']). '" class="card-img" alt="' . htmlspecialchars($plant['name']) . '" />';
    echo '  </div>';
    echo '  <div class="card-text">';
    echo '    <p class="label">' . htmlspecialchars($plant['name']) . '</p>';
    echo '    <p class="price">' . htmlspecialchars($plant['price']) . ' €</p>';
    echo '  </div>';
    echo '</div>';
}
?>


      
      </div>
    </div>

    <div class="info-banner">
      <h2 class="title">Grow Plant For A Better Life</h2>
      <div class="banner-img">
        <!-- <img src="public/plants/plant-stand-1.jpg" alt=""> -->
        <img src="public/plants/plant-stand-2.jpg" alt="" />
      </div>
      <div class="right-span">
        <p class="description">
          Cultivating plants enhances well-being and contributes to a healthier
          environment, fostering a more fulfilling life.
        </p>
        <button class="btn">Read More</button>
      </div>
    </div>

    <div class="care-container">
      <h2 class="title">Steps to start taking care of your plants</h2>
      <p class="description-1">
        The right solution for the care of green and smart plants
      </p>

      <div class="care-tips">
        <div class="tip">
          <img
            src="./public/icons/drop-of-liquid.png"
            class="care-icon"
            alt=""
          />
          <h3 class="subtitle">Humidity Control</h3>
          <p class="description-2">
            Effective humidity control is essential for proper caring of plants,
            ensuring optimal growth and overall health.
          </p>
        </div>
        <div class="tip">
          <img src="./public/icons/spray.png" class="care-icon" alt="" />
          <h3 class="subtitle">Pest Anticipation</h3>
          <p class="description-2">
            Implementing proactive pest anticipation measures is essential to
            safeguard and nurture the well-being of plants.
          </p>
        </div>
        <div class="tip">
          <img src="./public/icons/scissors.png" class="care-icon" alt="" />
          <h3 class="subtitle">Pruning Weeds</h3>
          <p class="description-2">
            Taking care of plants involves diligently managing unwanted growth
            to ensure their well-being.
          </p>
        </div>
      </div>
    </div>

    <div class="info-card">
      <img src="./public//plants/monstera.jpg" class="info-card-img" alt="" />
      <div class="content">
        <h3 class="title">
          Come with us to grow your plants to be better and healthier
        </h3>
        <p class="description">
          Come with us on a journey to learn the art of growing healthier and
          more vibrant plants. We're here to share tips and insights that will
          help you nurture your garden to its fullest potential. Come with us,
          and let's explore the simple yet effective ways to make your place
          thrive, naturally.
        </p>
        <div class="btn">Read More</div>
      </div>
    </div>

    <div class="instagram-banner">
      <h3 class="title">Follow us on Instagram</h3>
      <div class="images">
        <img src="./public/plants/ig-post-1.jpg" class="ig-img" alt="" />
        <img src="./public/plants/ig-post-2.jpg" class="ig-img" alt="" />
        <img src="./public/plants/ig-post-3.jpg" class="ig-img" alt="" />
        <img src="./public/plants/ig-post-4.jpg" class="ig-img" alt="" />
      </div>
    </div>
    <div class="footer-banner">
      <p>Follow Us</p>
      <img src="./public//icons/instagram.png" alt="" />
      <img src="./public//icons/facebook.png" alt="" />
      <img src="./public//icons/youtube.png" alt="" />

      <footer>&#169; BOTANICA ALL RIGHTS RESERVED</footer>
    </div>
  </body>
</html>
