<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            color: #27ae60;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect form data
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $subject = htmlspecialchars($_POST['subject']);
            $message = htmlspecialchars($_POST['message']);
            $contact_method = htmlspecialchars($_POST['contact_method']);
            
            // Validate inputs
            $errors = [];
            if (empty($name)) $errors[] = 'Name is required';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
            if (empty($message)) $errors[] = 'Message is required';
            
            if (empty($errors)) {
                // Prepare email
                $to = 'jatpropertymanagementllc@gmail.com';
                $email_subject = "New Contact Form Submission: $subject";
                $email_body = "
                    <h2>New Contact Form Submission</h2>
                    <p><strong>Name:</strong> $name</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone:</strong> $phone</p>
                    <p><strong>Preferred Contact Method:</strong> $contact_method</p>
                    <p><strong>Subject:</strong> $subject</p>
                    <p><strong>Message:</strong></p>
                    <p>$message</p>
                ";
                
                // Email headers
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                $headers .= "From: $name <$email>\r\n";
                $headers .= "Reply-To: $email\r\n";
                
                // Send email
                if (mail($to, $email_subject, $email_body, $headers)) {
                    echo '<div class="success-message">Thank you! Your message has been sent successfully.</div>';
                } else {
                    echo '<div class="error">Sorry, there was an error sending your message. Please try again later.</div>';
                }
            } else {
                foreach ($errors as $error) {
                    echo '<div class="error">' . $error . '</div>';
                }
            }
        }
        ?>
        
        <form id="contactForm" action="" method="POST">
            <div class="form-group">
                <label for="name">Full Name*</label>
                <input type="text" id="name" name="name" required>
                <div id="nameError" class="error"></div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="email" id="email" name="email" required>
                <div id="emailError" class="error"></div>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone">
            </div>
            
            <div class="form-group">
                <label for="contact_method">Preferred Contact Method</label>
                <select id="contact_method" name="contact_method">
                    <option value="email">Email</option>
                    <option value="phone">Phone Call</option>
                    <option value="text">Text Message</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject">
            </div>
            
            <div class="form-group">
                <label for="message">Your Message*</label>
                <textarea id="message" name="message" required></textarea>
                <div id="messageError" class="error"></div>
            </div>
            
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>

    <script>
        // Enhanced client-side validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error').forEach(el => el.textContent = '');
            
            // Name validation
            const name = document.getElementById('name').value.trim();
            if (name === '') {
                document.getElementById('nameError').textContent = 'Please enter your name';
                isValid = false;
            }
            
            // Email validation
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '') {
                document.getElementById('emailError').textContent = 'Please enter your email';
                isValid = false;
            } else if (!emailRegex.test(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email';
                isValid = false;
            }
            
            // Message validation
            const message = document.getElementById('message').value.trim();
            if (message === '') {
                document.getElementById('messageError').textContent = 'Please enter your message';
                isValid = false;
            } else if (message.length < 10) {
                document.getElementById('messageError').textContent = 'Message should be at least 10 characters';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
