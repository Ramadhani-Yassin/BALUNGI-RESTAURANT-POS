<?php include_once('../components/header.php')?>
<!-- Hero Section with Video Background and Text Overlay -->
<section id="hero" style="position: relative;">
    
<img src="../image/CAFE-MARUU.jpg" alt="Steak on Grill" 
     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; filter: contrast(60%);">
     
    <div class="hero container" style="position: relative; z-index: 1;">
        <div>
            <h1><strong><h1 class="text-center" style="font-family:Copperplate; color:whitesmoke;"> CAFÉ MARUU</h1><span></span></strong></h1>
            <h1><strong style="color:white;">COFFEE & DINING<span></span></strong></h1>
            <a href="#projects" type="button" class="cta">MENU</a>
        </div>
    </div>
</section>
<!-- End Hero Section -->
  
  
  
 <!-- menu Section -->
<section id="projects">
  <div class="projects container">
    <div class="projects-header">
      <h1 class="section-title">Me<span>n</span>u</h1>
    </div>

    <!-- Category Selector (Optional) -->
    <select style="text-align:center;" id="menu-category" class="menu-category">
      <option value="blue">Welcome to Café Maruu's Menu</option>
      <option value="yellow">MAIN DISHES</option>
      <!-- Comment out Side Dishes and Drinks options -->
      <!-- <option value="red">SIDE DISHES</option> -->
      <!-- <option value="green">DRINKS</option> -->
    </select>

    <!-- Main Dishes Section -->
    <div class="yellow msg" style="display: flex; justify-content: center;">
      <div class="mainDish">
        <h1 style="text-align:center;">MAIN DISHES</h1>
        <?php foreach ($mainDishes as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Comment out Side Dishes Section -->
    <!--
    <div class="red msg">
      <div class="sideDish">
        <h1 style="text-align:center">SIDE DISHES</h1>
        <?php foreach ($sides as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>
    </div>
    -->

    <!-- Comment out Drinks Section -->
    <!--
    <div class="green msg">
      <div class="drinks">
        <h1 style="text-align:center">DRINKS</h1>
        <?php foreach ($drinks as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>
    </div>
    -->

    <!-- Comment out the Combined Section -->
    <!--
    <div class="blue msg">
      <div class="mainDish">
        <h1 style="text-align:center">MAIN DISHES</h1>
        <?php foreach ($mainDishes as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>

      <div class="sideDish">
        <h1 style="text-align:center">SIDE DISHES</h1>
        <?php foreach ($sides as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>

      <div class="drinks">
        <h1 style="text-align:center">DRINKS</h1>
        <?php foreach ($drinks as $item): ?>
          <p>
            <span class="item-name"> <strong><?php echo $item['item_name']; ?></strong></span>
            <span class="item-price">TZS<?php echo $item['item_price']; ?></span><br>
            <span class="item_type"><i><?php echo $item['item_type']; ?></i></span>
            <hr>
          </p>
        <?php endforeach; ?>
      </div>
    </div>
    -->
  </div>
</section>
<!-- End menu Section -->


  <!-- About Section -->
<section id="about">
  <div class="about container">
    <div class="col-right">
        <h1 class="section-title" >About <span>Us</span></h1>
        <h2>Welcome to Café Maruu</h2>
 <p>Welcome to Café Maruu, nestled in the heart of Marumbi, Zanzibar—a true paradise for food lovers and coffee enthusiasts! Located along the serene coastline, our café offers a perfect blend of exquisite flavors, soothing ambiance, and the unparalleled beauty of Zanzibar. Whether you're seeking a place to relax with a cup of freshly brewed coffee or indulge in mouthwatering meals, Café Maruu promises an unforgettable experience.
 </p>
 <p>At Café Maruu, we take pride in offering premium services to ensure every visit is memorable. Savor the rich aroma and bold flavors of our handpicked coffee blends. Every cup is crafted with love, offering the perfect balance of freshness and taste to delight your senses.
 </p>
 <p>Enjoy a menu that celebrates both local and international cuisine, with dishes crafted to perfection using the freshest ingredients Zanzibar has to offer. From tantalizing seafood platters to hearty breakfasts, we cater to all tastes. Step into a cozy, tranquil atmosphere where the sound of the waves complements every bite and sip.
 </p>
 <p>Whether you're dining indoors or enjoying the coastal breeze on our outdoor terrace, the experience is unmatched. Our team ensures every guest feels at home with friendly and attentive service, while you enjoy stunning views of the Indian Ocean.
 </p>
    
      </div>
    </div>
  </section>
  <!-- End About Section -->
  
  
 <!-- Contact Section -->
<section id="contact">
  <div class="contact container">
    <div>
      <h1 class="section-title">Contact <span>info</span></h1>
    </div>
    <div class="contact-items">
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-phone-100.png" alt=""/></div>
          <h1>Phone</h1>
          <h2>+255 676 456 679</h2>
        </div>
      </div>
      
      <div class="contact-item contact-item-bg"> 
        <div class="contact-info">
          <div class='icon'><img src="../image/icons8-email-100.png" alt=""/></div>
          <h1>Email</h1>
          <h2>cafemaruu@gmail.com</h2> 
        </div>
      </div>
      
      <div class="contact-item contact-item-bg">
        <div class="contact-info">
          <div class='icon'> <img src="../image/icons8-home-address-100.png" alt=""/></div>
          <h1>Address</h1>
          <h2>Marumbi, Zanzibar</h2>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- End Contact Section -->

<?php 
include_once('../components/footer.php');
?>