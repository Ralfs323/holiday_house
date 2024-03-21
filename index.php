<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in
    $user_id = $_SESSION['user_id'];
    // You can perform actions for authenticated users here
    $buttonText = "Profile";
    $buttonAction = "profile.php"; // Change "#" to the URL of the user profile page
} else {
    // User is not logged in
    $buttonText = "Login";
    $buttonAction = "#";
}

if (isset($_SESSION['signup_success']) && $_SESSION['signup_success'] === true) {
    echo "<script>alert('Successfully signed up!');</script>";
    // Unset the session variable to prevent showing the message again on page refresh
    unset($_SESSION['signup_success']);
}

// Check if the user is an admin
if (isset($_SESSION['user_id'])) {
    require_once("db/db.php");

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT is_admin FROM User WHERE id = ?");

    // Pārbauda, vai sagatavošana bija veiksmīga
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $_SESSION['user_id']); // 'i' indicates the type of the parameter (integer)

    // Execute the statement
    $stmt->execute();

    // Get the result
    $stmt->bind_result($is_admin);
    $stmt->fetch();

    // Set the is_admin session variable based on the result
    $_SESSION['is_admin'] = ($is_admin == 1);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle the case when the user is not logged in
}

?>

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
        <?php if (isset($_SESSION['user_id'])) : ?>
            <a href="<?php echo $buttonAction; ?>" class="btn"><?php echo $buttonText; ?></a>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) : ?>
                <a href="admin/admin_dashboard.php" class="btn">Admin Dashboard</a>
            <?php endif; ?>
        <?php else : ?>
            <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn">Login</button>
        <?php endif; ?>
        <div id="id01" class="modal">
            <form class="modal-content animate" action="index.php" method="post">
                <div class="split-container">
                    <div class="left-half">
                        <div class="img-container">
                            <img src="/admin/images/picture1.jpg" alt="Avatar Image">
                            <div class="overlay-text">
                                <h2 id="modal-title">Welcome Back!</h2>
                            </div>
                        </div>
                    </div>
                    <div class="right-half">
                        <span onclick="closeModal()" class="close" title="Close Modal">&times;</span>

                        <div class="form-container">
                            <div id="login-container">
                                <?php include "auth/login.php"; ?>
                                <span id="modal-login-button" onclick="switchModal()">Don't have an account? SignUp</span>
                            </div>

                            <div id="register-container" hidden>
                                <?php include "auth/signup.html"; ?>
                                <span id="modal-signup-button" onclick="switchModal()">Already have an account? Login</span>
                            </div>
                        </div>

                        <script>
                            window.addEventListener('click', function(event) {
                                const modal = document.getElementById('id01');
                                // Check if the click event occurred outside of the modal content
                                if (event.target == modal) {
                                    // If so, close the modal
                                    closeModal();
                                }
                            });

                            // Function to close the modal
                            function closeModal() {
                                document.getElementById('id01').style.display = 'none';
                            }

                            // Function to close the modal when clicking the close button
                            function closeBtnClick() {
                                closeModal();
                            }

                            let modal = "login";
                            const loginText = "Already have an account? Login";
                            const registerText = "Don't have an account? SignUp";
                            const loginTitle = "Welcome back!";
                            const registerTitle = "Welcome!";

                            function switchModal() {
                                const loginContainer = document.getElementById("login-container");
                                const registerContainer = document.getElementById("register-container");
                                const loginButton = document.getElementById("modal-login-button");
                                const signupButton = document.getElementById("modal-signup-button");
                                const modalTitle = document.getElementById("modal-title");

                                if (modal === "login") {
                                    loginContainer.hidden = true;
                                    registerContainer.hidden = false;
                                    signupButton.textContent = loginText;
                                    modalTitle.textContent = registerTitle;
                                    modal = "signup";
                                } else {
                                    loginContainer.hidden = false;
                                    registerContainer.hidden = true;
                                    loginButton.textContent = registerText;
                                    modalTitle.textContent = loginTitle;
                                    modal = "login";
                                }
                            }
                        </script>




                    </div>
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

            <div class="swiper-slide slide" style="background: url(admin/images/picture1.jpg) no-repeat;">
                <div class="content">
                    <h3>it's where dreams come true</h3>
                    <a href="#" class="btn"> visit our offer</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background: url(admin/images/picture2.jpg) no-repeat;">
                <div class="content">
                    <h3>it's where dreams come true</h3>
                    <a href="#" class="btn"> visit our offer</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background: url(admin/images/picture3.jpg) no-repeat;">
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

<?php
function generateSelectOptions($name, $max, $includeNoOption = false) {
    echo '<select name="' . $name . '" id="' . $name . '" class="input">';

    if ($includeNoOption) {
        echo '<option value="0">No ' . $name . '</option>';
    }

    for ($i = 1; $i <= $max; $i++) {
        $pluralSuffix = ($i !== 1) ? 's' : ''; // Pievieno "s", ja ir vairāki
        echo '<option value="' . $i . '">' . $i . ' ' . $name . $pluralSuffix . '</option>';
    }

    echo '</select>';
}
?>



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
            <label for="adults">Adults <span>*</span></label>
            <?php generateSelectOptions("adult", 6); ?>
        </div>

        <div class="box">
            <label for="children">Children <span>*</span></label>
            <?php generateSelectOptions("child", 6, true); ?>
        </div>



        <input type="submit" value="check availability" class="btn">

    </form>
</section>


<!-- end -->


<!-- about -->
<section class="about" id="about">
    <div class="row">
        <div class="image">
            <img src="admin/images/picture4.jpg" alt="">
        </div>
        <div class="content">
            <h3>about us</h3>
            <p>
            <?php
            include "db/db.php";

            // Check if connection is successful
            if ($conn === false) {
                die("Error: Could not connect to the database. " . mysqli_connect_error());
            }

            // Execute SQL query
            $sql = "SELECT * FROM about_us";
            $result = $conn->query($sql);

            // Check if query executed successfully
            if ($result === false) {
                die("Error: " . $conn->error);
            }

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Output the content
                    echo $row["content"];
                }
            } else {
                echo "No content found.";
            }
            ?>
            </p>
        </div>
    </div>
</section>

<section class="room" id="room">
    <h1 class="heading">prices</h1>
    <div class="swiper room-slider">
        <div class="swiper-wrapper">

            <?php
            // Iekļauj datubāzes savienojuma failu
            require_once("db/db.php");

            // Izveido savienojumu ar datubāzi
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Pārbauda savienojuma veiksmīgumu
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Izgūst datus no datubāzes
            $sql = "SELECT price, description, image FROM RoomPrices";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Izvada datus uz HTML
                while($row = $result->fetch_assoc()) {
                    echo '<div class="swiper-slide slide">';
                    echo '<div class="image">';
                    echo '<span class="price">€ ' . $row["price"] . '/night</span>';
                    echo '<img src="' . $row["image"] . '" alt="">';
                    echo '<a href="#" class="fas fa-shopping-cart"></a>';
                    echo '</div>';
                    echo '<div class="content">';
                    echo '<h3>' . $row["description"] . '</h3>';
                    echo '<p></p>';
                    echo '<div class="stars">';

                    echo '</div>';
                    echo '<a href="#" class="btn">book now</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>


        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>


<!-- end -->

<!-- services -->

<section class="services">

    <div class="box-container">

        <div class="box">
            <img src="admin/images/service1.png" alt="">
            <h3>nearby swimming spots</h3>
        </div>

        <div class="box">
            <img src="admin/images/service2.png" alt="">
            <h3>breakfest</h3>
        </div>

        <div class="box">
            <img src="admin/images/service3.png" alt="">
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

            <?php
            // Pievieno datubāzes pieslēgumu failam
            include "db/db.php";

            // Izgūst attēlu informāciju no datubāzes
            $sql_select = "SELECT * FROM Gallery";
            $result = $conn->query($sql_select);

            // Pārbauda, vai ir iegūti rezultāti
            if ($result && $result->num_rows > 0) {
                // Iterē cauri katram rindiņai un attēlo attēlu HTML
                while($row = $result->fetch_assoc()) {
                    echo '<div class="swiper-slide slide">';
                    echo '<img src="' . $row["image"] . '" alt="">';
                    echo '<div class="icon">';
                    echo '<i class="fas fa-magnifying-glass-plus"></i>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Ja nav attēlu, izvada kļūdas ziņojumu
                echo "No images found.";
            }

            // Atbrīvo rezultātus un aizver datubāzes savienojumu
            $conn->close();
            ?>

        </div>

    </div>

</section>


<!-- end -->

<!-- review -->

<section class="review" id="review">

    <div class="swiper review-slider">
        <div class="swiper-wrapper">

            <?php
            include "db/db.php";
            // Izgūst visas atsauksmes no datubāzes
            $sql_select_reviews = "SELECT * FROM Reviews WHERE status = 'approved'";
            $result_reviews = $conn->query($sql_select_reviews);

            // Pārbauda, vai ir iegūti rezultāti
            if ($result_reviews && $result_reviews->num_rows > 0) {
                // Iterē cauri katram rezultātam un izvada atbilstošos HTML elementus
                while($row_review = $result_reviews->fetch_assoc()) {
                    ?>
                    <div class="swiper-slide slide">
                        <h2 class="heading">client's review</h2>
                        <i class="fas fa-quote-right"></i>
                        <p><?php echo $row_review['review_text']; ?></p>
                        <div class="user">
                            <img src="images/<?php echo $row_review['user_image']; ?>" alt="">
                            <div class="user-info">
                                <h3><?php echo $row_review['user_name']; ?></h3>
                                <div class="stars">
                                    <?php
                                    // Izvada zvaigznītes, atkarībā no vērtējuma
                                    for ($i = 1; $i <= $row_review['rating']; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Ja nav atsauksmju, izvada paziņojumu
                echo '<p>No reviews found.</p>';
            }
            ?>

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
            <img src="admin/images/FAQs.gif" alt="">
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
                <label for="adults">Adults <span>*</span></label>
                <?php generateSelectOptions("adult", 6); ?>
            </div>

            <div class="box">
                <label for="children">Children <span>*</span></label>
                <?php generateSelectOptions("child", 6, true); ?>
            </div>


            <input type="submit" value="check availability" class="btn">
        </div>

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

<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
<script src="/auth/js/validation.js" defer></script>
<script>
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>