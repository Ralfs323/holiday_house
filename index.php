<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Website</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
  <style>
    input[type=email], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: var(--primary);
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 7px;
    }


    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: green;
    }


    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
      position: relative;
    }

    img.avatar {
      width: 40%;
      border-radius: 50%;
    }

    .container {
      padding: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }


    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0,0.4);
      padding-top: 60px;
    }


    .modal-content {
      background-color: #fefefe;
      margin: 5% auto 15% auto;
      border: 1px solid #888;
      width: 80%;
    }

    .close {
      position: absolute;
      right: 25px;
      top: 0;
      color: #000;
      font-size: 35px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: green;
      cursor: pointer;
    }

    .animate {
      -webkit-animation: animatezoom 0.6s;
      animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
      from {-webkit-transform: scale(0)}
      to {-webkit-transform: scale(1)}
    }

    @keyframes animatezoom {
      from {transform: scale(0)}
      to {transform: scale(1)}
    }

    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }
      .cancelbtn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<!-- header -->

<header class="header">

  <a href="#" class="logo"> <i class="fas fa-hotel"></i> Holiday house ESTERE </a>

  <nav class="navbar">
    <a href="#home">home</a>
    <a href="#about">about</a>
    <a href="#room">prices</a>
    <a href="#gallery">gallery</a>
    <a href="#review">review</a>
    <a href="#faq">faq</a>
    <a href="#reservation" class="btn"> book now</a>
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn">Login</button>

    <div id="id01" class="modal">

      <form class="modal-content animate" action="/auth/index.php" method="post">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <img src="/images/picture1.jpg">
        </div>
        <div class="container">
            <?php
            include "auth/login.php";
            ?>
        </div>
      </form>
    </div>

  </nav>


  <div id="menu-btn" class="fas fa-bars"></div>

</header>

<!-- end -->

<!-- home -->

<section class="home" id="home">

  <div class="swiper home-slider">

    <div class="swiper-wrapper">

      <div class="swiper-slide slide" style="background: url(images/picture1.jpg) no-repeat;">
        <div class="content">
          <h3>it's where dreams come true</h3>
          <a href="#" class="btn"> visit our offer</a>
        </div>
      </div>

      <div class="swiper-slide slide" style="background: url(images/picture2.jpg) no-repeat;">
        <div class="content">
          <h3>it's where dreams come true</h3>
          <a href="#" class="btn"> visit our offer</a>
        </div>
      </div>

      <div class="swiper-slide slide" style="background: url(images/picture3.jpg) no-repeat;">
        <div class="content">
          <h3>it's where dreams come true</h3>
          <a href="#" class="btn"> visit our offer</a>
        </div>
      </div>

    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

  </div>

</section>

<!-- end -->

<!-- availability -->

<section class="availability">

  <form action="">

    <div class="box">
      <p>check in <span>*</span></p>
      <input type="date" class="input">
    </div>

    <div class="box">
      <p>check out <span>*</span></p>
      <input type="date" class="input">
    </div>

    <div class="box">
      <p>adults <span>*</span></p>
      <select name="adults" id="" class="input">
        <option value="1">1 adults</option>
        <option value="2">2 adults</option>
        <option value="3">3 adults</option>
        <option value="4">4 adults</option>
        <option value="5">5 adults</option>
        <option value="6">6 adults</option>
      </select>
    </div>

    <div class="box">
      <p>children <span>*</span></p>
      <select name="child" id="" class="input">
        <option value="1">1 child</option>
        <option value="2">2 child</option>
        <option value="3">3 child</option>
        <option value="4">4 child</option>
        <option value="5">5 child</option>
        <option value="6">6 child</option>
      </select>
    </div>

    <div class="box">
      <p>rooms <span>*</span></p>
      <select name="rooms" id="" class="input">
        <option value="1">1 rooms</option>
        <option value="2">2 rooms</option>
        <option value="3">3 rooms</option>
        <option value="4">4 rooms</option>
        <option value="5">5 rooms</option>
        <option value="6">6 rooms</option>
      </select>
    </div>

    <input type="submit" value="check availability" class="btn">

  </form>

</section>

<!-- end -->


<!-- about -->

<section class="about" id="about">

  <div class="row">

    <div class="image">
      <img src="images/picture4.jpg" alt="">
    </div>

    <div class="content">
      <h3>about us</h3>
      <p>Located within the Gauja National Park, the largest in Latvia, the stylish, family-run Estere offers self-catering accommodation with free wired internet and private parking. Cēsis Castle is 1.6 km away.

        The cottage at Estere, surrounded by greenery, is spacious, air-conditioned and decorated in a modern style featuring rustic elements. There is a flat-screen TV with a DVD player and a bathroom is equipped with a shower. Guests have access to a sauna at a surcharge.</p>
      <p>Guests have use of a kitchenette which comes with a refrigerator, a stove and a microwave and a dining area is also provided. Barbecue facilities are available in the garden.

        Cēsis Train Station is 2 km away and Žagarkalns and Ozolkalns ski centres are only 800 metres away.

        Couples particularly like the location — they rated it 9.8 for a two-person trip.</p>
    </div>

  </div>

</section>

<section class="room" id="room">

  <h1 class="heading">prices</h1>

  <div class="swiper room-slider">

    <div class="swiper-wrapper">

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 85/night</span>
          <img src="images/per1.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>for 1 person</h3>
          <p></p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 85/night</span>
          <img src="images/per2.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>for 2 persons</h3>
          <p></p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 98/night</span>
          <img src="images/per3.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>for 3 persons</h3>
          <p></p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 120/night</span>
          <img src="images/per4.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>for 4 persons</h3>
          <p></p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 60/night</span>
          <img src="images/hottub.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>Hot tub</h3>
          <p>EXTRA</p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

      <div class="swiper-slide slide">
        <div class="image">
          <span class="price">€ 60/night</span>
          <img src="images/sauna.jpg" alt="">
          <a href="#" class="fas fa-shopping-cart"></a>
        </div>
        <div class="content">
          <h3>Sauna</h3>
          <p>EXTRA</p>
          <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
          <a href="#" class="btn">book now</a>
        </div>
      </div>

    </div>

    <div class="swiper-pagination"></div>

  </div>

</section>

<!-- end -->

<!-- services -->

<section class="services">

  <div class="box-container">

    <div class="box">
      <img src="images/service1.png" alt="">
      <h3>nearby swimming spots</h3>
    </div>

    <div class="box">
      <img src="images/service2.png" alt="">
      <h3>breakfest</h3>
    </div>

    <div class="box">
      <img src="images/service3.png" alt="">
      <h3>nearby shop</h3>
    </div>

  </div>

</section>

<!-- end -->

<!-- gallery -->

<section class="gallery" id="gallery">

  <h1 class="heading">our gallery</h1>

  <div class="swiper gallery-slider">

    <div class="swiper-wrapper">

      <div class="swiper-slide slide">
        <img src="images/gal1.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

      <div class="swiper-slide slide">
        <img src="images/gal2.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

      <div class="swiper-slide slide">
        <img src="images/gal3.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

      <div class="swiper-slide slide">
        <img src="images/gal4.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

      <div class="swiper-slide slide">
        <img src="images/gal5.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

      <div class="swiper-slide slide">
        <img src="images/gal6.jpg" alt="">
        <div class="icon">
          <i class="fas fa-magnifying-glass-plus"></i>
        </div>
      </div>

    </div>

  </div>

</section>

<!-- end -->

<!-- review -->

<section class="review" id="review">

  <div class="swiper review-slider">
    <div class="swiper-wrapper">

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>„Lieliska vieta, ļoti mājīga un sakopta. Kamīns, baļļa, tējas&kafijas&medus.“</p>
        <div class="user">
          <img src="images/pic-1.png" alt="">
          <div class="user-info">
            <h3>Alvis</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>
          Apkārtne un pats namiņš ļoti sakopts un skaists. Padomāts arī par bērniem (pieejams mazais podiņš, rotaļu zona, grāmatas, pagalmā rotaļu laukumiņš)
          virtuve praktiski aprīkota ar visu nepieciešamo.
          Ja labs laiks, tad pagalmā var atpūsties. Mašīnai vieta aiz sētas.
          Mums tur ļoti patīk.!</p>
        <div class="user">
          <img src="images/pic-2.png" alt="">
          <div class="user-info">
            <h3>Sintija</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>Brīnišķiga vieta, brīnišķīgi saimnieki, lieliska vieta un atmosfēra. Jutāmies ļoti gaidīti, viss bija tīrs un sakopts!
          Mājiņā bija viss, kas nepieciešams atpūtai, padomāts pat par vismazāko sīkumu. Noteikti atgriezīsimies! ❤️</p>
        <div class="user">
          <img src="images/pic-3.png" alt="">
          <div class="user-info">
            <h3>Aldis</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>
          Mums patika pilnīgi viss - gan mājiņa, gan brīnišķīgais ziedošais un tumsā skaisti izgaismotais dārzs, gan burbuļkubls ar LED gaismām... Īpaši jāatzīmē saimnieku sarūpētie dažādu izmēru dvieļi (ar lielu rezervi) un halāti.
          Virtuvē - uz galda vāzē ziedi, skaisti trauki un glāzes (arī šampanieša), kafija, tēja, pat medus. Atpūtas un guļamzonā - ērtas gultas, pledi, rezerves spilveni un segas. Siltu omulību radīja iekurtais kamīns. Mēs izbaudījām patiešām brīnišķīgu atpūtu!</p>
        <div class="user">
          <img src="images/pic-4.png" alt="">
          <div class="user-info">
            <h3>Ligita</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>Iekārtojums,atmosfēra,...sauna,kubls...vienkārši fantastiski. Noteikti brauksim vēl.</p>
        <div class="user">
          <img src="images/pic-5.png" alt="">
          <div class="user-info">
            <h3>Kaspars</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="swiper-slide slide">
        <h2 class="heading">client's review</h2>
        <i class="fas fa-quote-right"></i>
        <p>Brīnišķīga, klusa vieta, laipni un atsaucīgi saimnieki. daudzas izklaides iespējas, 1min attālumā veikals</p>
        <div class="user">
          <img src="images/pic-6.png" alt="">
          <div class="user-info">
            <h3>Evija</h3>
            <div class="stars">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="swiper-pagination"></div>
  </div>

</section>

<!-- end -->

<!-- faq -->

<section class="faqs" id="faq">

  <h1 class="heading">frequently asked questions</h1>

  <div class="row">

    <div class="image">
      <img src="images/FAQs.gif" alt="">
    </div>

    <div class="content">

      <div class="box active">
        <h3>what are payment methods?</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam cupiditate mollitia.</p>
      </div>


    </div>

  </div>

</section>

<!-- end -->

<!-- reservation -->

<section class="reservation" id="reservation">

  <h1 class="heading">book now</h1>

  <form action="">

    <div class="container">

      <div class="box">
        <p>name <span>*</span></p>
        <input type="text" class="input" placeholder="Your Name">
      </div>

      <div class="box">
        <p>email <span>*</span></p>
        <input type="text" class="input" placeholder="Your Email">
      </div>

      <div class="box">
        <p>check in <span>*</span></p>
        <input type="date" class="input">
      </div>

      <div class="box">
        <p>check out <span>*</span></p>
        <input type="date" class="input">
      </div>

      <div class="box">
        <p>adults <span>*</span></p>
        <select name="adults" class="input">
          <option value="1">1 adults</option>
          <option value="2">2 adults</option>
          <option value="3">3 adults</option>
          <option value="4">4 adults</option>
          <option value="5">5 adults</option>
          <option value="6">6 adults</option>
        </select>
      </div>

      <div class="box">
        <p>children <span>*</span></p>
        <select name="child" class="input">
          <option value="1">1 child</option>
          <option value="2">2 child</option>
          <option value="3">3 child</option>
          <option value="4">4 child</option>
          <option value="5">5 child</option>
          <option value="6">6 child</option>
        </select>
      </div>

    </div>

    <input type="submit" value="check availability" class="btn">

  </form>

</section>

<!-- end -->

<!-- footer -->

<section class="footer">

  <div class="box-container">

    <div class="box">
      <h3>contact info</h3>
      <a href="#"> <i class="fas fa-phone"></i> +371-20282118 </a>
      <a href="#"> <i class="fas fa-phone"></i> +371-26516600</a>
      <a href="#"> <i class="fas fa-envelope"></i> namins.estere@inbox.lv</a>
      <a href="#"> <i class="fas fa-map"></i> Cēsis, Latvia</a>
    </div>

    <div class="box">
      <h3>quick links</h3>
      <a href="#"> <i class="fas fa-arrow-right"></i> home</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> about</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> prices</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> gallery</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> reservation</a>
    </div>

    <div class="box">
      <h3>extra links</h3>
      <a href="#"> <i class="fas fa-arrow-right"></i> refund policy</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> refund policy</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> refund policy</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> refund policy</a>
      <a href="#"> <i class="fas fa-arrow-right"></i> refund policy</a>
    </div>

  </div>

  <div class="share">
    <a href="#" class="fab fa-facebook-f"></a>
    <a href="#" class="fab fa-instagram"></a>
    <a href="#" class="fab fa-twitter"></a>
    <a href="#" class="fab fa-pinterest"></a>
  </div>

  <div class="credit">&copy; Holiday house ESTERE</div>

</section>

<!-- end -->

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
  var modal = document.getElementById('id01');

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
</body>
</html>