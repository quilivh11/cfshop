<?php
include("db.php");
include("auth_session.php");
$stmt = $con->prepare("SELECT username FROM accounts WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
    echo "<script>
    function Menu() {
        var option = document.querySelector('.optionlogged');
        option.classList.toggle('visible');
        var button = document.querySelector('.menubtn');
        button.classList.toggle('roll');
        searchForm.classList.remove('active');
        cartItem.classList.remove('active');
    }
    </script>";
} else {
    echo "<script>
    function Menu() {
        var option = document.querySelector('.option');
        option.classList.toggle('visible');
        var button = document.querySelector('.menubtn');
        button.classList.toggle('roll');
        searchForm.classList.remove('active');
        cartItem.classList.remove('active');
    }
    </script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KapeTann Brewed Coffee Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/convo.css">
    <link rel="stylesheet" href="/assets/css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- font awesome cdn link -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico"><!-- Favicon / Icon -->
</head>

<body>
    <!-- HEADER SECTION -->
    <header class="header">
        <a href="#" class="logo">
            <img src="/assets/images/logo.png" class="img-logo" alt="KapeTann Logo">
        </a>

        <!-- MAIN MENU FOR SMALLER DEVICES -->
        <nav class="navbar navbar-expand-lg">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="#home" class="text-decoration-none">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="text-decoration-none">About</a>
                </li>
                <li class="nav-item">
                    <a href="#menu" class="text-decoration-none">Menu</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="text-decoration-none">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="#blogs" class="text-decoration-none">Blogs</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="text-decoration-none">Contact</a>
                </li>
                <!-- <li class="nav-item 1" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Login</a>
                </li>
                <li class="nav-item 2" onclick="hide()">
                    <a href="/php/login.php" class="text-decoration-none">Logout</a>
                </li> -->

            </ul>

            </div>
        </nav>
        <div class="icons">
            <div class="fas fa-search" id="search-btn"></div>
            <a onclick="redirectCart()">
                <div class="fas fa-shopping-cart" id="cart-btn" data-view-id="cart"></div>
            </a>
            <div class="fas fa-bars" id="menu-btn"></div>
        </div>
        <div class="menu1">
            <button class="menubtn" onclick="Menu()">|||</button>
        </div>
        <div class="option">
            <a href="/php/Login.php" class="link">
                <button id="optionbtn">Sign in</button>
            </a>
            <a href="/phpconnect/registration.php" class="link">
                <button id="optionbtn">Sign up</button>
            </a>
        </div>
        <div class="optionlogged">
            <h1>Hi user, <?php echo "$name"; ?>!</h1>
            <a href="/php/changeinfo.php  " class="link">
                <button id="optionbtn">Account</button>
            </a>
            <a href="/php/history.php  " class="link">
                <button id="optionbtn">History order</button>
            </a>
            <a href="/php/logout.php" class="link">
                <button id="optionbtn">Log out</button>
            </a>
        </div>

        <!-- SEARCH TEXT BOX -->
        <div class="search-form">
            <input type="search" id="search-box" class="form-control" placeholder="search here..." autocomplete="off">
            <label for="search-box" class="fas fa-search"></label>
        </div>
        <div id="found"></div>

        <script type="text/javascript">
        $(document).ready(function() {
            $("#search-box").keyup(function() {
                var input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "/php/productsearch.php",
                        method: "POST",
                        data: {
                            input: input
                        },
                        success: function(data) {
                            $("#found").html(data).css("display", "block");
                        }
                    })
                } else {
                    $("#found").css("display", "none")
                }
            });
        });
        </script>
        <div class="cart">
            <h2 class="cart-title">Your Cart:</h2>
            <div class="cart-content">
                <!-- Cart items will be populated here -->
            </div>
            <div class="total">
                <div class="total-price">Total: <span id="total-price">0</span>VND</div>
            </div>
            <button type="button" class="btn-buy">Checkout Now</button>
        </div>


    </header>

    <!-- HERO SECTION -->
    <section class="home" id="home">
        <div class="content">
            <h3>Welcome to KapeTann Coffee Shop
                <?php if (!empty($_SESSION)) {
                    echo ", ";
                    $name = $_SESSION["name"];
                    echo $name;
                } ?>!</h3>
            <p>
                <strong>We are open 8:00 AM to 8:00 PM.</strong>
            </p>
            <a href="#menu" class="btn btn-dark text-decoration-none">Order Now!</a>
        </div>
    </section>

    <!-- ABOUT US SECTION -->
    <section class="about" id="about">
        <h1 class="heading"> <span>About</span> Us</h1>
        <div class="row g-0">
            <div class="image">
                <img src="/assets/images/about-img.png" alt="" class="img-fluid">
            </div>
            <div class="content">
                <h3>Welcome to KapeTann!</h3>
                <p>
                    At KapeTann Coffee Shop, we are passionate about coffee and believe
                    that every cup tells a story. We are a cozy coffee shop located
                    in the heart of the city, dedicated to providing an exceptional
                    coffee experience to our customers. Our love for coffee has led
                    us on a voyage of exploration and discovery, as we travel the
                    world in search of the finest coffee beans, carefully roasted
                    and brewed to perfection.
                </p>
                <p>
                    But coffee is not just a drink, it's an experience. Our warm and
                    inviting atmosphere at KapeTann is designed to be a haven
                    for coffee lovers, where they can relax, connect, and embark
                    on their own coffee voyages.
                </p>
                <a href="#" class="btn btn-dark text-decoration-none">Learn More</a>
            </div>
        </div>
    </section>
    <h1 class="heading">Our <span>Menu</span>
        <div class="bordersort">
            <span class="glyphicon glyphicon-sort"></span> Sort
            <select id="sort" class="sort btn-default btn-sm">
                <option value="1">Newest</option>
                <option value="2">Price: High to Low</option>
                <option value="3">Price: Low to High</option>
                <option value="4">Name: A to Z</option>
                <option value="5">Name: Z to A</option>
            </select>
        </div>
    </h1>

    <!-- MENU -->
    <?php
    include("product.php")
    ?>
    <center>
        <button id="showHideBtn" class="btn btn-dark">SHOW MORE</button>
    </center>
    </div>
    </div>
    </section>

    <!-- GALLERY SECTION -->
    <section class="gallery" id="gallery">
        <h1 class="heading">The <span>Gallery</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery1.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 1</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery2.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 2</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery3.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 3</h3>
                            </div>
                        </div>
                    </div>
                </div><br />
                <div class="row pic-to-hide">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery4.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery4.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 4</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/gallery5.jpg" alt="">
                            </div>
                            <div class="content">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h3 class="gallery-title">Picture 5</h3>
                            </div>
                        </div>
                    </div>
                </div><br />
                <center>
                    <button id="showBtn" class="btn btn-dark">SHOW MORE</button>
                </center>
            </div>
        </div>
    </section>

    <!-- BLOGS SECTION -->
    <section class="blogs" id="blogs">
        <h1 class="heading">Our <span>Blogs</span></h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/pour.jpg" alt="">
                            </div>
                            <div class="content">
                                <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank"
                                    class="title text-decoration-none">Batch Brew vs. Pour Over | The Pros and Cons
                                    Experienced by Coffee Professionals</a>
                                <span>by The Way to Coffee</span>
                                <p>Thinking back 15-20 years, I remember my parents going about their morning ritual of
                                    brewing coffee on weekends before burying...</p>
                                <center>
                                    <a href="https://www.thewaytocoffee.com/batch-brew-vs-pour-over/" target="_blank"
                                        class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/carbon.webp" alt="">
                            </div>
                            <div class="content">
                                <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee"
                                    target="_blank" class="title text-decoration-none">Carbon Neutral Tea and Coffee</a>
                                <span>by Taylors editorial team</span>
                                <p>All our tea and coffee is carbon neutral – but what does that actually mean? Here’s
                                    an explanation of how we’ve lowered our carbon footprint, and the three projects in
                                    Kenya, Malawi and Uganda which have reduced the emissions of our products to...</p>
                                <center>
                                    <a href="https://www.taylorsofharrogate.co.uk/news/carbon-neutral-tea-and-coffee"
                                        target="_blank" class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <div class="image">
                                <img src="/assets/images/coffeemaker.jpg" alt="">
                            </div>
                            <div class="content">
                                <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank"
                                    class="title text-decoration-none">BEST DRIP COFFEE MAKERS 2020</a>
                                <span>by CoffeeStylish.com</span>
                                <p>What is a good coffee maker? A good home coffee maker should have removable parts so
                                    it can be cleaned completely because you don’t want mold or buildups in your
                                    machine. It should be fast. It...</p>
                                <center>
                                    <a href="https://coffeestylish.com/best-drip-coffee-makers/" target="_blank"
                                        class="btn">Read More</a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS SECTION -->
    <section class="review" id="review">
        <h1 class="heading"><span>Testimo</span>nials</h1>
        <div class="box-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-1.png" alt="" class="user">
                            <h3>Jane Doe</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-2.png" alt="" class="user">
                            <h3>John Doe</h3>
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box">
                            <img src="/assets/images/quote-img.png" alt="" class="quote">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <img src="/assets/images/pic-3.png" alt="" class="user">
                            <h3>Jane Doe</h3>
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
        </div>
    </section>

    <!-- CONTACT US SECTION -->
    <section class="contact" id="contact">
        <h1 class="heading"><span>Contact</span> Us</h1>
        <div class="row">
            <div id="map" class="map pull-left"></div>
            <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
                <h3> Get in touch with us!</h3>
                <div class="inputBox">
                    <span class="fas fa-envelope"></span>
                    <input type="email" name="email" placeholder="Email Address">
                </div>
                <div class="inputBox">
                    <textarea name="message" placeholder="Enter your message..."></textarea>
                </div>
                <button type="submit" class="btn">Contact Now</button>
            </form>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <section class="footer">
        <div class="footer-container">
            <div class="logo">
                <img src="/assets/images/logo.png" class="img"><br />
                <i class="fas fa-envelope"></i>
                <p>abfiguerrez18@gmail.com</p><br />
                <i class="fas fa-phone"></i>
                <p>+63 917-134-1422</p><br />
                <i class="fab fa-facebook-messenger"></i>
                <p>@kapetanncoffee</p><br />
            </div>
            <div class="support">
                <h2>Support</h2>
                <br />
                <a href="#">Contact Us</a>
                <a href="#">Customer Service</a>
                <a href="#">Chatbot Inquiry</a>
                <a href="#">Submit a Ticket</a>
            </div>
            <div class="company">
                <h2>Company</h2>
                <br />
                <a href="#">About Us</a>
                <a href="#">Affiliates</a>
                <a href="#">Resources</a>
                <a href="#">Partnership</a>
                <a href="#">Suppliers</a>
            </div>
            <div class="newsletters">
                <h2>Newsletters</h2>
                <br />
                <p>Subscribe to our newsletter for news and updates!</p>
                <div class="input-wrapper">
                    <input type="email" class="newsletter" placeholder="Your email address">
                    <i id="paper-plane-icon" class="fas fa-paper-plane"></i>
                </div>
            </div>
            <div class="credit">
                <hr /><br />
                <h2>KapeTann Brewed Coffee © 2023 | All Rights Reserved.</h2>
                <h2>Designed by <span>Algo Filipino</span> | Teravision</h2>
            </div>
        </div>
    </section>

    <!-- CHAT BAR BLOCK -->
    <div class="chat-bar-collapsible">
        <button id="chat-button" type="button" class="collapsible">Chat with us! &nbsp;
            <i id="chat-icon" style="color: #fff;" class="fas fa-comments"></i>
        </button>
        <div class="content">
            <div class="full-chat-block">
                <!-- Message Container -->
                <div class="outer-container">
                    <div class="chat-container">
                        <!-- Messages -->
                        <div id="chatbox">
                            <h5 id="chat-timestamp"></h5>
                            <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                        </div>
                        <!-- User input box -->
                        <div class="chat-bar-input-block">
                            <div id="userInput">
                                <input id="textInput" class="input-box" type="text" name="msg"
                                    placeholder="Tap 'Enter' to send a message">
                                <p></p>
                            </div>
                            <div class="chat-bar-icons">
                                <i id="chat-icon" style="color: #333;" class="fa fa-fw fa-paper-plane"
                                    onclick="sendButton()"></i>
                            </div>
                        </div>
                        <div id="chat-bar-bottom">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS File Link -->
    <?php
    echo "<script src='/assets/js/script.js'></script>";
    // if (!empty($_SESSION)) {

    // }
    ?>
    <script src="/assets/js/responses.js"></script>
    <script src="/assets/js/convo.js"></script>


    <script>
    // CODE FOR THE FORMSPREE
    window.onbeforeunload = () => {
        for (const form of document.getElementsByTagName('form')) {
            form.reset();
        }
    }

    // CODE FOR THE GOOGLE MAPS API

    // CODE FOR THE REDIRECT CART
    function redirectCart() {
        // Check if the user is logged in
        if (!"<?php echo isset($_SESSION["username"]) ? $_SESSION["username"] : '' ?>") {
            // Redirect the user to the login page
            alert("You are not logged in. Please log into your account and try again.");
            window.location.href = "login.php";
        }
    }
    </script>

</body>

</html>