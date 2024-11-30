<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}
//session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$database = "house_rental";

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    echo "<script>alert('Connection failed: " . mysqli_connect_error() . "');</script>";
    exit();
}
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi;

require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\PHPMailer.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\Exception.php';
require 'C:\XAMPP\htdocs\houserental-master\PHPMailer-master\src\SMTP.php';

$email=$_SESSION['email'];
$rentID = $_COOKIE['rentID'];           
//$rentID = 21;
//$email="22bmiit150@gmail.com";
// Fetch details from the database
$result = mysqli_query($conn, "SELECT 
        p.id , 
        p.rid , 
        p.amount, 
        p.status AS payment_status, 
        p.pdate, 
        t.adress 
    FROM tblpayment p 
    INNER JOIN tblrent r ON r.rid = p.rid 
    INNER JOIN property t ON t.pid = r.pid 
    WHERE p.rid = '$rentID'");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "Payment item details not found.";
    exit;
}




// Function to send email with OTP and attached PDF
function sendEmail($recipient_email, $paymentDetails) {
    try {
        // Generate PDF and get the saved file path
        $pdfPath = generatePDF($paymentDetails);

        // Initialize PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ashishvaghasiya150@gmail.com';
        $mail->Password = 'dnvjaacfmzrpovwi';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set sender and recipient
        $mail->setFrom('ashishvaghasiya150@gmail.com', 'RentEase');
        $mail->addAddress($recipient_email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Invoice from RentEase';
        $mail->Body = getEmailTemplate($paymentDetails);

        // Attach the saved PDF
        $mail->addAttachment($pdfPath, 'invoice.pdf');

        // Send the email
        $mail->send();

        $_SESSION['pdf']="Email with PDF sent successfully";
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}

//class BillPDF extends Fpdi {
//
//    // Header
//    function Header() {
//        $this->Image('C:\XAMPP\htdocs\houserental-master\homlisti\wp-content\uploads\2021\09\cropped-favicon-homlisti-180x180.png', 10, 6, 15); // Adjust the path as needed
//        $this->SetFont('Arial', 'B', 15);
//        $this->Cell(50);
//        $this->Cell(90, 10, 'RentEase', 0, 0, 'C');
//        $this->Ln(20);
//    }
//
//    // Footer
//    function Footer() {
//        $this->SetY(-15);
//        $this->SetFont('Arial', 'I', 8);
//        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
//    }
//}
class BillPDF extends Fpdi {

    protected $angle = 0;

    // Rotate method for watermark
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angleRad = $angle * M_PI / 180;
            $c = cos($angleRad);
            $s = sin($angleRad);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.5F %.5F cm 1 0 0 1 %.5F %.5F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    // Custom Header
    function Header() {
        // Add header background
        
        // Add logo
       $this->Image('C:\XAMPP\htdocs\houserental-master\homlisti\wp-content\uploads\2021\09\cropped-favicon-homlisti-180x180.png', 10, 6, 15); // Adjust the path as needed
      
        // Add watermark
        $this->SetFont('Arial', 'B', 100);
        $this->SetTextColor(220, 220, 220); // Light gray for watermark
// Center watermark by calculating page center
        $x = ($this->w - $this->GetStringWidth('RentEase')) / 2; // Center horizontally
        $y = $this->h / 2; // Center vertically

        $this->Rotate(60, $this->w / 2, $this->h / 2.5); // Diagonal rotation centered
        $this->Text($x, $y, 'RentEase'); // Apply centered watermark text
        $this->Rotate(0); // Reset rotation
        // Add header text
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(255, 255, 255); // White text
        $this->Cell(80);
         $this->Cell(90, 10, 'RentEase', 0, 0, 'C');
//       
       $this->Ln(10);

        $this->SetTextColor(0, 0, 0); // Reset text color for content
    }

    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Thank you for your business! This pdf not need signature', 0, 1, 'C');
        $this->Cell(0, 10, 'For queries, contact us at support@rentease.com', 0, 1, 'C');
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

function generatePDF($paymentDetails) {
    // Define the path to store invoices and load the invoice counter
    $invoicesDir = 'invoices';
    $counterFile = $invoicesDir . '/invoice_counter.txt';

    // Create the invoices directory if it doesn't exist
    if (!file_exists($invoicesDir)) {
        mkdir($invoicesDir, 0777, true);
    }

    // Read the current invoice number from the counter file or start from 1
    if (file_exists($counterFile)) {
        $invoiceNum = (int) file_get_contents($counterFile) + 1;
    } else {
        $invoiceNum = 1;
    }

    // Save the new invoice number back to the counter file
    file_put_contents($counterFile, $invoiceNum);

    // Generate the PDF
    $pdf = new BillPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Customer Information
    $pdf->Cell(0, 10, 'Invoice #: ' . $invoiceNum, 0, 1);
    $pdf->Cell(0, 10, 'Payment ID: ' . $paymentDetails['id'], 0, 1);
    $pdf->Cell(0, 10, 'Rent ID: ' . $paymentDetails['rid'], 0, 1);
    $pdf->Cell(0, 10, 'Property: ' . $paymentDetails['adress'], 0, 1);
    $pdf->Cell(0, 10, 'User Email: ' . $_SESSION['email'], 0, 1);
    
    $pdf->Cell(0, 10, 'Payment Date: ' . $paymentDetails['pdate'], 0, 1);
    $pdf->Ln(10);

    // Table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Description', 1);
    $pdf->Cell(40, 10, 'Amount', 1);
    $pdf->Ln();

    // Payment details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Rent Payment', 1);
    $pdf->Cell(40, 10, 'Rs.' . number_format($paymentDetails['amount'], 2), 1);
    $pdf->Ln(10);

    // Save the PDF with a unique filename in the invoices directory
    $filename = $invoicesDir . '/Invoice_' . $invoiceNum . '.pdf';
    $pdf->Output('F', $filename); // Save file to disk

    return $filename;
}

// HTML email template
function getEmailTemplate($paymentDetails) {
    return '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { padding: 20px; }
            .header { background-color: #004f9f; color: white; padding: 10px; }
            .content { margin-top: 20px; }
            .footer { color: gray; margin-top: 20px; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>RentEase</h1>
            </div>
            <div class="content">
                <p>Dear User,</p>
                <p>Your payment details:</p>
                <ul>
                    <li>Payment ID: ' . $paymentDetails['id'] . '</li>
                    <li>Rent ID: ' . $paymentDetails['rid'] . '</li>
                    <li>Amount: Rs.' . number_format($paymentDetails['amount'], 2) . '</li>
                    <li>Status: ' . $paymentDetails['payment_status'] . '</li>
                    <li>Payment Date: ' . $paymentDetails['pdate'] . '</li>
                </ul>
                <p>The invoice is attached to this email.</p>
            </div>
            <div class="footer">
                <p>© 2024 RentEase. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';
}


// Example usage
sendEmail($email,$row);
header("Location:/houserental-master/homlisti/Payment.php");
die();// Call sendEmail with the recipient's email address
?>