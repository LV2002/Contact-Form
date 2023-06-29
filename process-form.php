<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $errors = [];

    // Validate name (required)
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

    // Validate email (required and valid email format)
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate phone number (required)
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }

    // Validate message (required)
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are no validation errors, send the message
    if (empty($errors)) {
        // Compose email message
        $to = "contact@afdindia.com";
        $subject = "New Contact Form Submission";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Message:\n$message\n";

        // Send email
        $headers = "From: $email\r\n";
        $success = mail($to, $subject, $email_content, $headers);

        // Check if email sending was successful
        if ($success) {
            // Return success response
            http_response_code(200);
            echo json_encode(array("message" => "Message sent successfully!"));
            exit;
        } else {
            // Return error response
            http_response_code(500);
            echo json_encode(array("message" => "Failed to send message. Please try again."));
            exit;
        }
    } else {
        // Return validation error response
        http_response_code(400);
        echo json_encode(array("message" => "Validation errors occurred.", "errors" => $errors));
        exit;
    }
} else {
    // Return error for invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Invalid request method."));
    exit;
}
?>