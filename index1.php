<?php 
include 'style.php'; 
//include 'submit_contact_form.php'
        function insertContactMessage($conn, $fullname, $email, $contact_num, $discord, $message) {
            $stmt = $conn->prepare("INSERT INTO contact (fullname, email, contact_num, discord, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $fullname, $email, $contact_num, $discord, $message);
            
            if ($stmt->execute()) {
                return true; // Message sent successfully
            } else {
                return false; // Failed to send message
            }
            
        // $stmt->close();
        }

        $messageSent = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $contact_num = $_POST['contact_num'];
            $discord = $_POST['discord'];
            $message = $_POST['message'];

            $messageSent = insertContactMessage($conn, $fullname, $email, $contact_num, $discord, $message);
        }


        // Include JavaScript to show the alert if message was sent
        if ($messageSent) {
            echo "<script type='text/javascript'>alert('Message Sent');</script>";
        }
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" type="text/css" href="style.php">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="js/script.js" defer></script>
</head>
<body>
    <header class="header">
        <a href="login.php" class="logo">Semilla Portfolio</a>
        <div class="bx bx-menu" id="menu-icon"></div>
        <nav class="navbar">
            <a href="#home" class="nav-item">Home</a>
            <a href="#about" class="nav-item">About</a>
            <a href="#education" class="nav-item">Education</a>
            <a href="#skills" class="nav-item">Skills</a>
            <a href="#contact" class="nav-item">Contacts</a>
        </nav>
    </header>

    <section class="home" id="home">
        <div class="home-content">
            <img class="myPic" src="images/samplebg.jpg" alt="self portrait">
            <?php if ($homeContent): ?>
                <h1>Hi!, I'am <span><?php echo htmlspecialchars($homeContent['name']); ?></span></h1>
                <div class="text-animate">
                    <h3><?php echo htmlspecialchars($homeContent['position']); ?></h3>
                </div>
                <p><?php echo htmlspecialchars($homeContent['home_content']); ?></p>
            <?php else: ?>
                <h1>Hi!, I'am <span>Zayne Patrick Semilla</span></h1>
                <div class="text-animate">
                    <h3>A BSIT Student</h3>
                </div>
                <p>I am an aspiring programming student aiming to become a web developer in the future, 
                    this website is my Portfolio that contains my information and other stuffs! Enjoy reading!</p>
            <?php endif; ?>
            <div class="btn-box">
                <a href="#contact" class="btn">Contact Me</a>
            </div>
        </div>
        
        <div class="home-sci">
            <?php if ($contactinfo): ?>
            <a href="<?php echo htmlspecialchars($contactinfo['facebook']) ?>" target="_blank"><i class='bx bxl-facebook-circle'></i></a>
            <a href="<?php echo htmlspecialchars($contactinfo['twitter']) ?>" target="_blank"><i class='bx bxl-twitter'></i></a>
            <a href="<?php echo htmlspecialchars($contactinfo['gmail']) ?>" target="_blank"><i class='bx bxl-gmail'></i></a>
            <a href="<?php echo htmlspecialchars($contactinfo['linkedin']) ?>" target="_blank"><i class='bx bxl-linkedin'></i></a>
            <?php else: ?>
                <a href="https://www.facebook.com/zay.semilla" target="_blank"><i class='bx bxl-facebook-circle' ></i></a>
                <a href="https://twitter.com/zpasemilla" target="_blank"><i class='bx bxl-twitter' ></i></a>
                <a href="https://mail.google.com/mail/u/0/#inbox?compose=DmwnWtMqhRDhkxQgkRWjjSWLDhhRqfZSXqbHQNgwDnXTjpHDPmBSfgRpQHrcWwFDlJLkSXKxfWFV" target="_blank"><i class='bx bxl-gmail' ></i></a>
                <a href="https://www.linkedin.com/in/zayne-patrick-semilla-32b3a72b3/" target="_blank"><i class='bx bxl-linkedin' ></i></a>
            <?php endif; ?>
        </div>

    </section>

    <section class="about" id="about">
        <h2 class="heading">About <span>Me</span></h2>
        <div class="about-content">
            <div class="aboutme">
            <?php foreach ($aboutData as $data): ?>
                <h3><?php echo $data['about_me_header']; ?></h3>
                <p><?php echo $data['about_me_content']; ?></p>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="education" id="education">
        <h2 class="edu-heading">Education</h2>
        <div class="cards-container">
            <?php foreach ($educationalData as $row): ?>
            <div class="card">
                <p class="year"><i class='bx bx-calendar'></i><?php echo htmlspecialchars($row['year']) ?></p>
                <h2 class="school"><?php echo htmlspecialchars($row['school']) ?></h2>
                <p class="school_content"><?php echo htmlspecialchars($row['school_content']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="skills" id="skills">
        <h2 class="heading">My <span>Skills</span></h2>
        <div class="skills-row">
            <div class="skills-column">
                <h3 class="title">Coding Skills</h3>
                <div class="skills-box">
                    <div class="skills-content">
                        <?php foreach ($skillsData as $skill => $value): ?>
                        <div class="progress">
                            <h3><?= ucfirst($skill) ?> <span><?= $value ?>%</span></h3>
                            <div class="bar"><span style="width: <?= $value ?>%;"></span></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="contact" id="contact">
    <h2 class="heading">Contact <span>ME!</span></h2>
    <form action="index1.php" method="post">
        <div class="input-box">
            <div class="input-field">
                <input type="text" name="fullname" placeholder="Fullname" required>
                <span class="focus"></span>
            </div>
            <div class="input-field">
                <input type="email" name="email" placeholder="Email Address" required>
                <span class="focus"></span>
            </div>
            <div class="input-field">
                <input type="tel" name="contact_num" placeholder="Contact Number" required>
                <span class="focus"></span>
            </div>
            <div class="input-field">
                <input type="text" name="discord" placeholder="Discord ID" required>
                <span class="focus"></span>
            </div>
            <div class="text-areafield">
                <textarea name="message" cols="300" rows="10" placeholder="Type your Message here" required></textarea>
                <span class="focus"></span>
            </div>
            <div class="btn-box btns">
                <button type="submit" class="btn">Submit</button>
            </div>
        </div>
    </form>
</section>


    <footer class="footer">
        <div class="footer-text">
            <p>Copyright © 2024 by Zayne Patrick Semilla | All Rights Reserved</p>
        </div>
        <div class="footer-iconTop">
            <a href="#home"><i class='bx bx-up-arrow-alt'></i></a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

<script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            
            $.ajax({
                url: 'style.php',
                type: 'post',
                data: $('#contactForm').serialize(),
                success: function(response) {
                    alert('Message Sent');
                    $('#contactForm')[0].reset(); // Reset the form fields
                },
                error: function() {
                    alert('There was an error sending the message.');
                }
            });
        });
    });
</script>