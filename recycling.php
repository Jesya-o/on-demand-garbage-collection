<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Tallinn University of Technology – Web Technologies Project - HTML & CSS">
    <meta name="keywords" content="web_project, Throw It, book a collection">
    <meta name="author" content="Dark Side">
    <meta name="viewport" content="initial-scale=1">

    <title>Home page</title>
    <link href="https://fonts.googleapis.com/css?family=Nanum+Myeongjo&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/how.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/pricing.css">
    <link rel="stylesheet" href="styles/pages.css">
    <link rel="stylesheet" href="styles/testimonials.css">
    <link rel="stylesheet" href="styles/services.css">

</head>

<body>
    <!-- Header section of the document -->
    <?php require_once('header.php'); ?>

    <!-- Content section of the document -->
    <div id="main" class="content">
        <h2 class="links-back">
            <a href="index.php#pricing">Services</a>
            <span>&#8594;</span>
            <a href="recycling.php">Recycling</a>
        </h2>
        <div class="row justify-content-center">
            <div class="card-col left-col single-pricing">
                <div class="what-included">
                    <h4>What is included?</h4>
                    <p><span>&#8594;</span> &nbsp; &nbsp;Taking out the garbage at preplanned time from any Tallinn
                        house</p>
                    <p><span>&#8594;</span> &nbsp; &nbsp;Eco-friendly way of garbage collection.</p>
                </div>
                <div class="small-bottom-text">At the processing facility, the recyclables
                    are sorted, cleaned of contaminants,
                    and prepared for transport to a milling
                    facility or directly to a manufacturing facility.</div>
            </div>
            <div class="card-col right-col single-pricing">
                <div id="regular-pickup-card-header" class="pricing-header">
                    <h4>Recycling</h4>
                    <p>10 EUR/time</p>
                </div>
                <div>
                    <div class="pricing-content">
                        <ul>
                            <li>
                                <i class="checkmark"></i>
                                Cancel at any time
                            </li>
                        </ul>
                    </div>
                    <div class="pricing-btn">
                        <a href="booking.php">Book!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer section of the document -->
    <?php require_once('footer.php'); ?>
</body>

</html>