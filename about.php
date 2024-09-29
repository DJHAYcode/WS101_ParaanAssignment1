<?php
session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: register.php");
    exit;
}

$user_data = $_SESSION['user_data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fc; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333; 
            line-height: 1.6; 
        }
        .user-details {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); 
            border: 1px solid #ddd; 
        }
        .user-details h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #3d5af1; 
        }
        .user-details p {
            font-size: 16px;
            margin-bottom: 10px;
            padding: 10px; 
            background-color: #f1f1f1; 
            border-radius: 10px; 
        }
        .user-details a {
            text-decoration: none; 
            margin-top: 20px; 
            display: inline-block; 
        }
        .user-details a.btn {
            background-color: #3d5af1; 
            border: none; 
            border-radius: 25px; 
            padding: 10px 20px; 
            color: #fff; 
            font-size: 16px; 
            transition: background-color 0.3s ease; 
        }
        .user-details a.btn:hover {
            background-color: #354ac2; 
        }
    </style>
</head>
<body>
<div class="user-details">
    <h2>YOUR DETAILS</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($user_data['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user_data['email']) ?></p>
    <p><strong>Facebook URL:</strong> <a href="<?= htmlspecialchars($user_data['facebook_url']) ?>" target="_blank"><?= htmlspecialchars($user_data['facebook_url']) ?></a></p>
    <p><strong>Phone Number:</strong> <?= htmlspecialchars($user_data['phone']) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($user_data['gender']) ?></p>
    <p><strong>Country:</strong> <?= htmlspecialchars($user_data['country']) ?></p>
    <p><strong>Skills:</strong> <?= htmlspecialchars(implode(", ", $user_data['skills'])) ?></p>
    <p><strong>Biography:</strong> <?= htmlspecialchars($user_data['biography']) ?></p>
    <a href="register.php" class="btn btn-primary">Go Back to Registration</a>
</div>
</body>
</html>
