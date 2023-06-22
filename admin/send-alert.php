<?php
include('includes/config.php');

// Fetch the overdue book records with student email
$sql = "SELECT ibd.StudentID, ibd.BookId, s.EmailId
        FROM tblissuedbookdetails ibd
        INNER JOIN tblstudents s ON ibd.StudentID = s.StudentID
        WHERE ibd.Due_date <= CURDATE() AND ibd.RetrunStatus is NULL";
$query = $dbh->prepare($sql);
$query->execute();
$overdueBooks = $query->fetchAll(PDO::FETCH_ASSOC);

// Iterate through each overdue book and send email alerts
foreach ($overdueBooks as $book) {
    $studentID = $book['StudentID'];
    $bookID = $book['BookId'];
    $email = $book['EmailId'];

    // Compose the email message
    $subject = "Book Return Alert";
    $message = "Dear Student,\n\nThis is a reminder that the due date for returning the book (Book ID: $bookID) has passed. Please return the book to the library as soon as possible.";

    // Send the email
    $headers = "From: vhfathima02@gmail.com"; // Replace with your email address
    if (mail($email, $subject, $message, $headers)) {
        echo "Email alert sent to Student ID: $studentID<br>";
    } else {
        echo "Failed to send email alert to Student ID: $studentID<br>";
    }
}
?>
