<!DOCTYPE html>
<html lang="en">
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Feature list extraction</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>
				<form class="login100-form validate-form" action="callPythonScript.php?email=<?php if(isset($_POST['email']))echo $_POST['email'] ?>" enctype="multipart/form-data" method="post">
					<span class="login100-form-title">
						Supported feed list
					</span>
					<br>
					<div class="wrap-input100 validate-input" >
						<?php
						$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "feature";
						
						// Create connection
						$conn = new mysqli($servername, $username, $password, $dbname);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						} 
						
						$sql = "SELECT * from vendor";
						$result = $conn->query($sql);
						
						$sqlFramework = "SELECT * FROM `feed`";
						$resultFramework = $conn->query($sqlFramework);
						$rowFrameworkResult = array();
						if ($resultFramework->num_rows > 0) {
							while($rowFramework = mysqli_fetch_assoc($resultFramework)) {
								$rowFrameworkResult[] = $rowFramework;
							}
						}
						?>
						<select name="category" class="required-entry" id="category" onchange="javascript: dynamicdropdown(this.options[this.selectedIndex].value);">
								<option value="">Select Vendor</option>
								<option value="0">Custom url</option>
								<?php if ($result->num_rows > 0) { ?>
									<?php while($row = mysqli_fetch_assoc($result)) { ?>
									<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
									<?php } ?>
								<?php } ?>
						</select>
						<script type="text/javascript" language="JavaScript">
							document.write('<select name="feed_list" id="feed"><option value="">Select version</option></select>')
						</script>
						<noscript>
							<select name="feed_list" id="feed" >
								<option value="">Select Version</option>
							</select>
						</noscript>
						<?php $conn->close(); ?>
					</script>
					</div>
					<br>
					<div id="customURL">
						<span>https://</span>
						<input type="input"  name="cutomUrl" size="10" placeholder="link.."/>
						<input type="checkbox" id="save" name="save" value="save" onchange="isChecked(this, 'sub1')">
						<label for="save"> Save</label><br>
					</div><br>
					<div  id="addVendor">
						<label for="vendor">Vendor:</label>
						  <input type="text" id="vendor" name="vendor" placeholder="________________________"><br>
						  <label for="version">Version:</label>
						  <input type="text" id="version" name="version" placeholder="________________________">
					</div>
					<div class="text-center p-t-12" id="allButtons">
						
						<a class="txt2" href="#">
							<input type="radio" id="other" name="subscription" value="other" checked>
							<label for="other">Other</label> &emsp;
							<input type="radio" id="subscribe" name="subscription" value="subscribe">
							<label for="subscribe">Subscribe</label> &emsp;
							<input type="radio" id="unsubscribe" name="subscription" value="unsubscribe" onclick="alert('Are you sure to unscubscribe?');">
							<label for="unsubscribe">Unsubscribe</label>
						</a>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Process
						</button>
					</div>
					<div class="text-center p-t-136">
						<?php
						$email = null;
						if(isset($_POST['email']))
						{
							$email = $_POST['email'];
						}
						echo "<a class='txt2' href='listFeed.php?email=$email'>
							List subscribed feeds
							<i class='fa fa-long-arrow-right m-l-5' aria-hidden='true'></i>
							</a>"
						?>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	<script language="javascript" type="text/javascript">
    $(document).ready(function () {
		$("#customURL").hide();
		$("#addVendor").hide();
        $('#category').on('change', function() {
            if ( this.value == '0')
			  {
				$("#allButtons").hide();
				$("#feed").hide();
				$("#customURL").show();
			  }
			  else
			  {
				$("#allButtons").show();
				$("#feed").show();
				$("#customURL").hide();
				$("#addVendor").hide();
			  }
        });
    });
	
	var rowFrameworkResultInJs =<?php echo json_encode($rowFrameworkResult);?>;
	function dynamicdropdown(listindex)
	{
		document.getElementById("feed").length = 0;
		document.getElementById("feed").options[0]=new Option("Select Version","");
		if (listindex != 0) {
			var lookup = {};
			var j = 1;
			for (var i = 0, len = rowFrameworkResultInJs.length; i < len; i++) {
				if (rowFrameworkResultInJs[i].vendor_id == listindex) {
					document.getElementById("feed").options[j]=new Option(rowFrameworkResultInJs[i].feed_name,rowFrameworkResultInJs[i].url);
					j = j+1;
				}
			}
		}
		return true;
	}
	
	function isChecked(checkbox, sub1) {
    var button = document.getElementById(sub1);

    if (checkbox.checked === true) {
        $("#addVendor").show();
    } else {
        $("#addVendor").hide();
    }
}
	</script>
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>