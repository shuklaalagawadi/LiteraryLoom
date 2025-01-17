
<!-- Start Defing Database Variables -->
<?php
if(isset($_POST))
{
  $bookid= $_POST['bookid'];
  $firstname=$_POST['firstname'];
  $lastname=$_POST['lastname'];
  $gender=$_POST['gender'];
  $number=$_POST['number'];
  $semail=$_POST['email'];
  $add1=$_POST['add1'];
  $add2=$_POST['add2'];
  $city=$_POST['city'];
  $state=$_POST['state'];
  $pin=$_POST['pin'];
  $uid=$_POST['uid'];
  $username=$_POST['username'];
  $bookname=$_POST['bookname'];
  $amount=$_POST['amount'];
  $bookname=myUrlEncode($bookname);
  $add1=myUrlEncode($add1);
  $add2=myUrlEncode($add2);
  $trackid="BP-TRACK-".rand();
  $invoice="B-P-I-".rand();
}
?>
<!-- End Defing Database Variables -->


<!-- Start SQL Database Storing -->
<?php
function myUrlEncode($string) {
    $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", " ", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
}
?>
<?php
$conn = mysqli_connect("localhost","root","","shop");
	$sql = "INSERT INTO shipping(b_id,u_id,sf_name,sl_name,ssex,smobile,semail,saddress1,saddress2,stown,sstate,spin) VALUES('$bookid','$uid','$firstname','$lastname','$gender','$number','$semail','$add1','$add2','$city','$state','$pin')";
	if($conn->query($sql) === TRUE) {
    	echo '';
	} else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>
<!-- End SQL Database Storing -->


<!-- Start Messege Display -->

<?php
  $con=mysqli_connect("localhost","root","","shop");
  $sql2="SELECT book_count from book where book_id='$bookid'";
  $res=$con->query($sql2);
  if($res->num_rows>0)
      {
        while($row=$res->fetch_assoc())
        {
          $count=$row["book_count"];
        }
      }
  $count=$count-1;
  $sql3="UPDATE book SET book_count='$count' WHERE book_id='$bookid'";
  if($con->query($sql3)===TRUE)
  {
    echo '
    <div class="alert alert-success" role="alert" style="margin: 15 300 15 300;">
      <center> Payment Successful! Your order has been placed. Thank you for using Book Planet!</center>
    </div>';
  }
  else
  {
     echo "Database error";
  }
  $con->close();
?>
<!-- End Messege Display -->


<!-- Start Invoice HTML -->
<html>
<head>
	<title> Literary Loom | Order Details </title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

  <div id="invoice" class="container mb-4" style="border:2px #1515a2 solid;">

      <div class="invoice overflow-auto">
          <div style="min-width: 600px">
              <header>
                  <div class="row">
                      <div class="col">
                        <img src="images/logo.png" data-holder-rendered="true" style="max-height:85px;"/>
                      </div>
                      <div class="col company-details">
                          <h2 class="name" style="color:purple;">
                            Literary Loom
                          </h2>
                          <div>Dr V PG Hallkatti BLDEA's college of Engineering</div>
                          <div>hello@literaryloom.ml</div>
                      </div>
                  </div>
              </header>
              <main>
                  <div class="row contacts">
                      <div class="col invoice-to">
                          <div class="text-gray-light">INVOICE TO:</div>
                          <h2 class="to"><?php echo $firstname ?>&nbsp;<?php echo $lastname ?></h2>
                          <div class="address">+91 <?php echo $number?></div>
                          <div class="address"><?php echo $add1?>, <?php echo $add2?> , <?php echo $city?> , <?php echo $state?>, <?php echo $pin?></div>
                          <div class="email"><a href="mailto:john@example.com"><?php echo $semail?></a></div>
                      </div>
                      <div class="col invoice-details">
                          <h1 class="invoice-id"><?php echo $invoice ?></h1>
                          <div class="date">Date of Invoice: <?php echo date("d/m/Y") ?></div>
                          <div class="date">Due Date: <?php echo date('d/m/Y', strtotime(' + 10 days')); ?></div>
                      </div>
                  </div>
                  <table border="0" cellspacing="0" cellpadding="0">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th class="text-left">BOOK Name</th>
                              <th class="text-right">PRICE</th>
                              <th class="text-right">QUANTITY</th>
                              <th class="text-right">TOTAL</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td class="no">01</td>
                              <td class="text-left"><h3>
                                  <a> <?php echo $bookname?> </a>
                                  </h3>
                              </td>
                              <td class="unit">Rs.<?php echo $amount?>.00</td>
                              <td class="qty">01</td>
                              <td class="total">Rs.<?php echo $amount?>.00</td>
                          </tr>
                      </tbody>
                      <tfoot>
                          <tr>
                              <td colspan="2"></td>
                              <td colspan="2">SUBTOTAL</td>
                              <td>Rs.<?php echo $amount?>.00</td>
                          </tr>
                          <tr>
                              <td colspan="2"></td>
                              <td colspan="2">SHIPPING</td>
                              <td>Rs. 00.00</td>
                          </tr>
                          <tr>
                              <td colspan="2"></td>
                              <td colspan="2">GRAND TOTAL</td>
                              <td>Rs.<?php echo $amount?>.00</td>
                          </tr>
                      </tfoot>
                  </table>
                  <div class="thanks">Thank you!</div>
                  <div class="notices">
                      <div>NOTICE:</div>
                      <div class="notice">Expect delivery within a week at your address. Kindly check your email and sms for tracking deatils.</div>
                  </div>
              </main>
              <footer>
                <center class="mt-3 mb-3">
                  <div id="editor"></div>
                <button onclick="printPage()" class="btn btn-warning">Print as PDF</button>
                <a class="btn btn-outline-info" href="bookplanet.php" role="button">Back To Home</a>
                  </center>
                  Invoice was created on a computer and is valid without the signature and seal.
              </footer>
          </div>
          <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
          <div></div>
      </div>
  </div>
</div>

<style media="screen">
#invoice{
  padding: 30px;
}

.invoice {
  position: relative;
  background-color: #FFF;
  min-height: 680px;
  padding: 15px
}

.invoice header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #3989c6
}

.invoice .company-details {
  text-align: right
}

.invoice .company-details .name {
  margin-top: 0;
  margin-bottom: 0
}

.invoice .contacts {
  margin-bottom: 20px
}

.invoice .invoice-to {
  text-align: left
}

.invoice .invoice-to .to {
  margin-top: 0;
  margin-bottom: 0
}

.invoice .invoice-details {
  text-align: right
}

.invoice .invoice-details .invoice-id {
  margin-top: 0;
  color: #3989c6
}

.invoice main {
  padding-bottom: 50px
}

.invoice main .thanks {
  margin-top: -100px;
  font-size: 2em;
  margin-bottom: 50px
}

.invoice main .notices {
  padding-left: 6px;
  border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
  font-size: 1.2em
}

.invoice table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px
}

.invoice table td,.invoice table th {
  padding: 15px;
  background: #eee;
  border-bottom: 1px solid #fff
}

.invoice table th {
  white-space: nowrap;
  font-weight: 400;
  font-size: 16px
}

.invoice table td h3 {
  margin: 0;
  font-weight: 400;
  color: #3989c6;
  font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
  text-align: right;
  font-size: 1.2em
}

.invoice table .no {
  color: #fff;
  font-size: 1.6em;
  background: #3989c6;
}

.invoice table .unit {
  background: #ddd
}

.invoice table .total {
  background: #3989c6;
  color: #fff
}

.invoice table tbody tr:last-child td {
  border: none
}

.invoice table tfoot td {
  background: 0 0;
  border-bottom: none;
  white-space: nowrap;
  text-align: right;
  padding: 10px 20px;
  font-size: 1.2em;
  border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
  border-top: none
}

.invoice table tfoot tr:last-child td {
  color: #3989c6;
  font-size: 1.4em;
  border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
  border: none
}

.invoice footer {
  width: 100%;
  text-align: center;
  color: #777;
  border-top: 1px solid #aaa;
  padding: 8px 0
}

@media print {
  .invoice {
      font-size: 11px!important;
      overflow: hidden!important
  }

  .invoice footer {
      position: absolute;
      bottom: 10px;
      page-break-after: always
  }

  .invoice>div:last-child {
      page-break-before: always
  }
}
</style>

<style>
.height {
    min-height: 200px;
}

.icon {
    font-size: 47px;
    color: #5CB85C;
}

.iconbig {
    font-size: 77px;
    color: #5CB85C;
}

.table > tbody > tr > .emptyrow {
    border-top: none;
}

.table > thead > tr > .emptyrow {
    border-bottom: none;
}

.table > tbody > tr > .highrow {
    border-top: 3px solid;
}
</style>


</body>
<script>
        function printPage() {
            window.print();
        }
</script>
</html>

<!-- End Invoice HTML -->


<!-- Start Sendgrid Email  -->
<?php
  if(isset($_POST))
  {
    require 'vendor/autoload.php';
    $API_KEY = "YOUR_SENDGRID_API_KEY";
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("admin@bookplanet.ml", "Admin - Book Planet");
    $email->setSubject("Shipment Confirmation");
    $email->addTo("$semail", "Book Planet Order");
    // $email->addContent("text/plain", "Your Shipment is succesfully created");
    $email->addContent("text/html", "<center><h1>Book Planet Order Confirmation</h1></center>
        <hr style='max-width:18%;'>
        <center>
          <p>Hello $firstname $lastname, your order number $invoice with Book Planet for the book $bookname is Confirmed.</p>
          <p>Expect the delivery within 72 hours with the Shipment ID : $trackid <br> with our courier partner Xpressbee.</p>
          <br>
          Regards,<br>
          <strong>Team Book Planet</strong>
        </center>"
    );

    $sendgrid = new \SendGrid($API_KEY);
    if ($sendgrid->send($email)) {
      print "";
    }
  }
?>
<!-- End Sendgrid Email  -->

<!-- Start textlocal SMS  -->
<?php
	// Authorisation details.
	$username = "YOUR_TEXT_LOCAL_USERNAME";
	$hash = "HASH_CODE_GOES_HERE";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";

	// Data for text message. This is the text message data.
	$sender = "TXTLCL"; // This is who the message appears to be from.

  // uncomment below line to send sms
  $numbers = "$number"; // A single number or a comma-seperated list of numbers

  // 612 chars or less
  $message = "Hi $firstname, your Book Planet order has been confirmed. Check your email for details regarding shipment of package.";
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
?>
<!-- End textlocal SMS  -->
