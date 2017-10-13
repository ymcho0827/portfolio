<?php

 

 error_reporting(E_ALL);

 ini_set('display_errors', 1);

 

if(isset($_FILES) && (bool) $_FILES) {

  

	$allowedExtensions = array("pdf","doc","docx","gif","jpeg","jpg","png","rtf","txt");

	

	$files = array();

	$fullName = $_POST['fullName'];
	$phoneNumber = $_POST['phoneNumber'];
	$email = $_POST['email'];
	$price = $_POST['price'];
	$size = $_POST['size'];
	$brand = $_POST['brand'];
	$colour = $_POST['colour'];
	$timesWorn = $_POST['timesWorn'];
	$feedback = $_POST['feedback'];
	
	
	if(empty($fullName))
	{
		echo "Your name field is empty!\n";
		exit;
	}	elseif(empty($phoneNumber)) {
		echo "Phone Number field is empty!\n";
		exit;
	}	elseif(empty($email)) {
		echo "Email field is empty!\n";
		exit;
	}	elseif(empty($price)) {
		echo "Purchase Price field is empty!\n";
		exit;
	}	elseif(empty($size)) {
		echo "Size field is empty!\n";
		exit;
	}	elseif(empty($brand)) {
		echo "Brand/Store field is empty!\n";
		exit;
	}	elseif(empty($colour)) {
		echo "Colour field is empty!\n";
		exit;
	}	elseif(empty($timesWorn)) {
		echo "Times Worn field is empty!\n";
		exit;
	}
	
	foreach($_FILES as $name=>$file) {

		$file_name = $file['name']; 

		$temp_name = $file['tmp_name'];

		$file_type = $file['type'];

		$path_parts = pathinfo($file_name);

		$ext = $path_parts['extension'];

		if(!in_array($ext,$allowedExtensions)) {

			die("File $file_name has the extensions $ext which is not allowed");

		}

		array_push($files,$file);

	}



	// email fields: to, from, subject, and so on

	$to = "youremail@email.com";

	$from = "youremail@email.com"; 

	$subject ="test attachment"; 

	$message = "Name: $fullName\n\n";
	$message .=	"Phone Number: $phoneNumber\n\n";
	$message .= "Email: $email\n\n";
	$message .= "Purchase Price: $price\n\n";
	$message .= "Size: $size\n\n";
	$message .= "Brank/Store: $brand\n\n";
	$message .= "Colour: $colour\n\n";
	$message .= "Times Worn: $timesWorn\n\n";
	$message .= "Message: $feedback\n\n\n";
	
	$headers = "From: $from";

	



	// boundary 

	$semi_rand = md5(time()); 

	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

	 

	// headers for attachment 

	$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

	 

	// multipart boundary 

	$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 

	$message .= "--{$mime_boundary}\n";

	 

	// preparing attachments

	for($x=0;$x<count($files);$x++){

		$file = fopen($files[$x]['tmp_name'],"rb");

		$data = fread($file,filesize($files[$x]['tmp_name']));

		fclose($file);

		$data = chunk_split(base64_encode($data));

		$name = $files[$x]['name'];

		$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$name\"\n" . 

		"Content-Disposition: attachment;\n" . " filename=\"$name\"\n" . 

		"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";

		$message .= "--{$mime_boundary}\n";

	}



	// send

	 

	$ok = mail($to, $subject, $message, $headers); 

	if ($ok) { 

		//redirect to homepage if request quote has been successfully sent
		header('Location: success.php');exit();

	} else { 
		
		echo "<p>mail could not be sent!</p>"; 
		header('Location: failedToSent.php');exit();
	} 

}	

 

?>

 


<html>
<head><title>Contribute to the Cause</title>
<meta http-equiv="Content-type" content="html" charset= "UTF-8">

</head>

<body>

<!-- set up this form send to email (action) -->
<form style="font-family:verdana; padding: 30px; border-radius: 25px;border-style:groove; 
display:table; margin-right:auto; margin-left:auto" method="post" name="myemailform" enctype="multipart/form-data"
action="contributeForm.php">
<div style="width:400px;"></div>
<!-- header -->
<div style="color:white; border-radius: 25px; padding:50px; text-align:center; background-color:#75c4ff; font-size: 30px;">Contribution form</div>

<!-- Step 1 section -->
<div style="padding-top: 25px;"><ins><span style="border-radius: 10px;padding:5px;background-color:green; margin-right:2%; background-color:#75c4ff;">Step 1. </span><b>Tell us about yourself</b></span></ins></div>
<div style="display: flex; padding-bottom: 20px;width : 450px;">

<!-- Name field -->
<div style="margin-top:20px; margin-right : 1%; width : 49%;">Name<span style="color: red;"> *</span><br/>
<input type="text" id="fullName" name="fullName" style="width: 100%;" class="form-control"/>
</div>

<!-- Phone Number field -->
<div style="margin-top:20px; margin-left : 5%; margin-right : 0; width : 49%;">Phone Number<span style="color: red;"> *</span><br/>
<input type="text" id="phoneNumber" name="phoneNumber" style="width: 100%;" class="form-control"/>
</div>
</div>

<!-- Email field -->
<div style="padding-bottom: 20px;">Email<br/>
<input type="text" id="email" name="email" style="width : 450px;" class="form-control"/>
</div>

<!-- Step 2 section -->
<div style="padding-top: 25px;"><ins><span style="border-radius: 10px;padding:5px; background-color:green; margin-right:2%; background-color:#75c4ff;">Step 2. </span><b>Tell us about yourself</b></span></ins></div>
<div style="display: flex; padding-bottom: 20px;width : 450px;">

<!-- Purchase Price field -->
<div style="margin-top:20px; margin-right : 1%; width : 30%;">Purchase Price
<input type="text" id="price" name="price" style="width :100%;" class="form-control"/></div>

<!-- Size field -->
<div style="margin-top:20px; margin-left: 5%; margin-right : 1%; width : 20%;">Size
<input type="text" id="size" name="size" style="width :100%;" class="form-control"/></div>

<!-- Brand/Store field -->
<div style="margin-top:20px; margin-left: 5%; margin-right : 1%; width : 30%;">Brand/Store
<input type="text" id="brand" name="brand" style="width :100%;" class="form-control"/></div>
</div>

<!-- Colour field -->
<div style="display: flex; padding-bottom: 20px;width : 450px;">
<div style="margin-top:20px; margin-right : 1%; width : 30%;">Colour
<input type="text" id="colour" name="colour" style="width :100%;" class="form-control"/></div>

<!-- Times Worn field -->
<div style="font-size:16px; margin-top:20px; margin-left: 5%; margin-right : 1%; width : 30%;">Times Worn
<input type="text" id="timesWorn" name="timesWorn" style="width :100%;" class="form-control"/></div>
</div>

<!-- Upload photo -->
<div style="margin-bottom: 10px;">Upload Photo(s)</div>
<input type="file" name="attach1" multiple><br><br><br>

<!-- Comment field -->
<div style="margin-bottom:15px"> Feel free to leave a message</div>
<textarea name="feedback" rows="10" cols="40">
Comment line
</textarea>

<!-- submit button -->
<div style="text-align: right; margin-top:20px; padding-bottom: 20px;"><input style="font-weight:bold; padding:20px;background-color:#75c4ff; name="skip_Submit" value="Request Quote" type="submit"/></div>
<div>
</form>
</html>
