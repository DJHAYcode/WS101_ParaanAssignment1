<?php
session_start();

$errors = [];
$data = [];

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $data['name'] = sanitize($_POST['name']);
    if (!preg_match("/^[a-zA-Z\s]+$/", $data['name'])) {
        $errors['name'] = "Name is required and can only contain letters and spaces.";
    }

    $data['email'] = sanitize($_POST['email']);
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "A valid email is required.";
    }

    $data['facebook_url'] = sanitize($_POST['facebook_url']);
    if (!filter_var($data['facebook_url'], FILTER_VALIDATE_URL)) {
        $errors['facebook_url'] = "A valid URL is required.";
    }

    $data['password'] = sanitize($_POST['password']);
    if (strlen($data['password']) < 8 || !preg_match("/[A-Z]/", $data['password']) || !preg_match("/[0-9]/", $data['password'])) {
        $errors['password'] = "Password must be at least 8 characters long, with at least one uppercase letter and one number.";
    }

    $data['confirm_password'] = sanitize($_POST['confirm_password']);
    if ($data['confirm_password'] !== $data['password']) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    $data['phone'] = sanitize($_POST['phone']);
    if (!preg_match("/^[0-9]+$/", $data['phone'])) {
        $errors['phone'] = "A valid phone number is required.";
    }

    $data['gender'] = isset($_POST['gender']) ? sanitize($_POST['gender']) : '';
    if (empty($data['gender'])) {
        $errors['gender'] = "Gender is required.";
    }

    $data['country'] = sanitize($_POST['country']);
    if (empty($data['country'])) {
        $errors['country'] = "Country is required.";
    }

    $data['skills'] = isset($_POST['skills']) ? $_POST['skills'] : [];
    if (empty($data['skills'])) {
        $errors['skills'] = "At least one skill must be selected.";
    }

    $data['biography'] = sanitize($_POST['biography']);
    if (strlen($data['biography']) > 200) {
        $errors['biography'] = "Biography cannot exceed 200 characters.";
    }

    // If no errors, save data to session and redirect
    if (empty($errors)) {
        $_SESSION['user_data'] = $data;
        header("Location: about.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e3e7e8;
      font-family: Arial, sans-serif;
    }
    .registration-form {
      max-width: 600px;
      margin: 50px auto;
      background: #ffffff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .form-header {
      text-align: center;
      margin-bottom: 25px;
    }
    .form-header h2 {
      font-weight: 600;
      color: #555555;
    }
    .form-control {
      background-color: #f1f1f1;
      border-radius: 25px;
      padding: 10px 20px;
      border: none;
      outline: none;
      box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus {
      background-color: #ffffff;
      border-color: #3d5af1;
      box-shadow: 0 0 5px rgba(61, 90, 241, 0.5);
    }
    .submit-btn {
      background-color: #3d5af1;
      border-color: #3d5af1;
      border-radius: 25px;
      padding: 10px 30px;
      color: #fff;
      font-size: 16px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .submit-btn:hover {
      background-color: #354ac2;
      border-color: #354ac2;
    }
    .error {
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="registration-form">
    <div class="form-header">
        <h2>REGISTRATION FORM</h2>
    </div>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= isset($data['name']) ? $data['name'] : '' ?>">
            <div class="error"><?= isset($errors['name']) ? $errors['name'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= isset($data['email']) ? $data['email'] : '' ?>">
            <div class="error"><?= isset($errors['email']) ? $errors['email'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="facebook_url" class="form-label">Facebook URL</label>
            <input type="text" class="form-control" id="facebook_url" name="facebook_url" value="<?= isset($data['facebook_url']) ? $data['facebook_url'] : '' ?>">
            <div class="error"><?= isset($errors['facebook_url']) ? $errors['facebook_url'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <div class="error"><?= isset($errors['password']) ? $errors['password'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            <div class="error"><?= isset($errors['confirm_password']) ? $errors['confirm_password'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($data['phone']) ? $data['phone'] : '' ?>">
            <div class="error"><?= isset($errors['phone']) ? $errors['phone'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <div>
                <input type="radio" name="gender" value="Male" id="gender_male" <?= (isset($data['gender']) && $data['gender'] === 'Male') ? 'checked' : '' ?>>
                <label for="gender_male"> Male</label>
                <input type="radio" name="gender" value="Female" id="gender_female" <?= (isset($data['gender']) && $data['gender'] === 'Female') ? 'checked' : '' ?>>
                <label for="gender_female"> Female</label>
                <input type="radio" name="gender" value="Others" id="gender_others" <?= (isset($data['gender']) && $data['gender'] === 'Others') ? 'checked' : '' ?>>
                <label for="gender_female"> Others</label>
            </div>
            <div class="error"><?= isset($errors['gender']) ? $errors['gender'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country</label>
            <select class="form-select" id="country" name="country">
                <option value="">Select your country</option>
                <option value="usa" <?= (isset($data['country']) && $data['country'] === 'usa') ? 'selected' : '' ?>>USA</option>
                <option value="canada" <?= (isset($data['country']) && $data['country'] === 'canada') ? 'selected' : '' ?>>Canada</option>
                <option value="Philippines" <?= (isset($data['country']) && $data['country'] === 'philippines') ? 'selected' : '' ?>>Philippines</option>
                <option value="uk" <?= (isset($data['country']) && $data['country'] === 'uk') ? 'selected' : '' ?>>UK</option>
            </select>
            <div class="error"><?= isset($errors['country']) ? $errors['country'] : '' ?></div>
        </div>

        <div class="mb-3">
    <label for="skills" class="form-label">Skills</label>
    <div>
        <input type="checkbox" name="skills[]" value="Junior Programmer" id="skill_junior_programmer" <?= (isset($data['skills']) && in_array('Junior Programmer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_junior_programmer"> Junior Programmer</label><br>

        <input type="checkbox" name="skills[]" value="Data Analyst" id="skill_data_analyst" <?= (isset($data['skills']) && in_array('Data Analyst', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_data_analyst"> Data Analyst</label><br>

        <input type="checkbox" name="skills[]" value="Web Developer" id="skill_web_developer" <?= (isset($data['skills']) && in_array('Web Developer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_web_developer"> Web Developer</label><br>

        <input type="checkbox" name="skills[]" value="Software Tester" id="skill_software_tester" <?= (isset($data['skills']) && in_array('Software Tester', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_software_tester"> Software Tester</label><br>

        <input type="checkbox" name="skills[]" value="Database Administrator" id="skill_database_admin" <?= (isset($data['skills']) && in_array('Database Administrator', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_database_admin"> Database Administrator</label><br>

        <input type="checkbox" name="skills[]" value="Network Engineer" id="skill_network_engineer" <?= (isset($data['skills']) && in_array('Network Engineer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_network_engineer"> Network Engineer</label><br>

        <input type="checkbox" name="skills[]" value="DevOps Engineer" id="skill_devops_engineer" <?= (isset($data['skills']) && in_array('DevOps Engineer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_devops_engineer"> DevOps Engineer</label><br>

        <input type="checkbox" name="skills[]" value="Cybersecurity Analyst" id="skill_cybersecurity_analyst" <?= (isset($data['skills']) && in_array('Cybersecurity Analyst', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_cybersecurity_analyst"> Cybersecurity Analyst</label><br>

        <input type="checkbox" name="skills[]" value="Machine Learning Engineer" id="skill_machine_learning" <?= (isset($data['skills']) && in_array('Machine Learning Engineer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_machine_learning"> Machine Learning Engineer</label><br>

        <input type="checkbox" name="skills[]" value="UI/UX Designer" id="skill_uiux_designer" <?= (isset($data['skills']) && in_array('UI/UX Designer', $data['skills'])) ? 'checked' : '' ?>>
        <label for="skill_uiux_designer"> UI/UX Designer</label><br>
    </div>
    <div class="error"><?= isset($errors['skills']) ? $errors['skills'] : '' ?></div>
</div>


        <div class="mb-3">
            <label for="biography" class="form-label">Biography (max 200 characters)</label>
            <textarea class="form-control" id="biography" name="biography" rows="3"><?= isset($data['biography']) ? $data['biography'] : '' ?></textarea>
            <div class="error"><?= isset($errors['biography']) ? $errors['biography'] : '' ?></div>
        </div>

        <button type="submit" class="btn submit-btn">Register</button>
    </form>
</div>
</body>
</html>
