<?php 
// include 'connection/style.php';

// function fetchMessages($conn) {
//     $sql = "SELECT fullname, email, contact_num, discord, message FROM contact";
//     $result = $conn->query($sql);
//     $messages = [];
//     if ($result && $result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $messages[] = $row;
//         }
//     }
//     return $messages;
// }

session_start(); 
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'style.php';


$conn = connectToDatabase();

$home_content_query = "SELECT home_content, name, position FROM home LIMIT 1";
$home_content_result = $conn->query($home_content_query);
$home_content_data = $home_content_result->fetch_assoc();

// Fetch education data
$education_query = "SELECT id, school, school_content, year FROM education";
$education_result = $conn->query($education_query);
$educationalData = $education_result->fetch_all(MYSQLI_ASSOC);


// Fetch messages
$messages_query = "SELECT id, fullname, email, contact_num, discord, message FROM contact";
$messages_result = $conn->query($messages_query);
$messages = $messages_result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            height: 100%;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2 class="text-center py-3">Dashboard</h2>
        <a href="#home-section">Home</a>
        <a href="#education-section">Education</a>
        <a href="#skills-section">Skills</a>
        <a href="#messages-section">Messages</a>
        <a href="logout.php" class="logout btn btn-danger">Logout</a>
    </div>

    <div class="content">
        <!-- Home Section -->
        <div id="home-section" class="card mb-3">
            <div class="card-header">
                <b>Home Content</b>
            </div>
            <div class="card-body">
            <form action="update_home.php" method="post">
                <div class="form-group">
                    <label for="home_content">Home Content</label>
                    <input type="text" class="form-control" id="home_content" name="home_content" value="<?php echo htmlspecialchars($home_content_data['home_content']); ?>">
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($home_content_data['name']); ?>">
                </div>
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($home_content_data['position']); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update Home Content</button>
            </form>

            </div>
        </div>

        
        <!-- Education Section -->
        <div id="education-section" class="card mb-3">
            <div class="card-header">
                Education Details
            </div>
            <div class="card-body">
                <!-- Add Education Form -->
                <form action="manage_education.php" method="post" class="mb-4">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="new_school">School</label>
                        <input type="text" class="form-control" id="new_school" name="school" required>
                    </div>
                    <div class="form-group">
                        <label for="new_school_content">School Content</label>
                        <input type="text" class="form-control" id="new_school_content" name="school_content" required>
                    </div>
                    <div class="form-group">
                        <label for="new_year">Year</label>
                        <input type="text" class="form-control" id="new_year" name="year" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Education</button>
                </form>

    <!-- Existing Education Records -->
        <!-- Education Section -->
        <div id="education-section" class="card mb-3">
            <div class="card-header">
                Education Details
            </div>
            <div class="card-body">
                <?php foreach ($educationalData as $education): ?>
                    <form action="manage_education.php" method="post">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($education['id']); ?>">
                        <input type="hidden" name="action" value="edit">
                        <div class="form-group">
                            <label for="school">School</label>
                            <input type="text" class="form-control" id="school" name="school" value="<?php echo htmlspecialchars($education['school']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="school_content">School Content</label>
                            <input type="text" class="form-control" id="school_content" name="school_content" value="<?php echo htmlspecialchars($education['school_content']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="year">Year</label>
                            <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($education['year']); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Education</button>
                        <button type="submit" formaction="manage_education.php?action=delete" class="btn btn-danger">Delete Education</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    



        <!-- Skills Section -->
        <div id="skills-section" class="card mb-3">
            <div class="card-header">
                <b>Skills</b>
            </div>
            <div class="card-body">
                <?php foreach ($skillsData as $property => $value): ?>
                    <form action="update_skills.php" method="post" class="mb-3">
                        <div class="form-group">
                            <label for="property">Property</label>
                            <input type="text" class="form-control" id="property" name="property" value="<?php echo $property; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" class="form-control" id="value" name="value" value="<?php echo $value; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Skill</button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="card mb-3" id="messages">
    <div class="card-header">
    <b>Messages</b>
    </div>
    <div class="card-body">
        <?php foreach ($messages as $message): ?>
            <div class="mb-3">
                <h5>From: <?php echo htmlspecialchars($message['fullname']); ?></h5>
                <p>Email: <?php echo htmlspecialchars($message['email']); ?></p>
                <p>Contact Number: <?php echo htmlspecialchars($message['contact_num']); ?></p>
                <p>Discord ID: <?php echo htmlspecialchars($message['discord']); ?></p>
                <p>Message: <?php echo htmlspecialchars($message['message']); ?></p>
                <form action="delete_message.php" method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($message['id']); ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete Message</button>
                </form>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>


                            
    </div>
</body>
</html>