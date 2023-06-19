<?php
include('includes/config.php');

// Get the current date
$currentDate = date('Y-m-d');

// Select all the books that are overdue
$sql = "SELECT * FROM tblissuedbookdetails WHERE ReturnStatus is NULL AND DueDate < :currentDate";
$query = $dbh->prepare($sql);
$query->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

// Send reminder emails
foreach ($results as $result) {
    $studentId = $result['StudentID'];
    $bookName = $result['BookName'];
    $dueDate = $result['DueDate'];

    // Get student email address
    $sql = "SELECT Email FROM tblstudents WHERE StudentID = :studentId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentId', $studentId, PDO::PARAM_INT);
    $query->execute();
    $student = $query->fetch(PDO::FETCH_ASSOC);
    $headers = 'From: ananshamsudheen3011@gmail.com';


    $to = $student['Email'];
    $subject = 'Library Book Return Reminder';
    $message = "Dear Student,\n\nThis is a reminder that the book '$bookName' is due for return by $dueDate. Please return the book to the library as soon as possible.\n\nRegards,\nThe Library Management";

    // Send the reminder email
    mail($to, $subject, $message, $headers);

}

echo "Reminder emails sent successfully!";
?>
