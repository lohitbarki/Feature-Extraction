<html>
<body>
<a href='index.html'>Home</a>
</br>
</br>
<?php

$email = null;
$flag = 1;
$subscription = "other";

if(isset($_GET['email']))
{
  $email = $_GET['email'];
}

if (!empty($_POST['subscription']))
{
	$subscription = $_POST["subscription"];
		
	if($subscription == "subscribe")
	{
		$command = "C:/Users/lbarki/PycharmProjects/ApplyRules/venv/Scripts/python.exe C:/Users/lbarki/PycharmProjects/ApplyRules/addSubscriber.py ".$email;
		$output = shell_exec($command);
		echo "<p>$output</p>";
	}
	else if ($subscription == "unsubscribe")
	{
		$command = "C:/Users/lbarki/PycharmProjects/ApplyRules/venv/Scripts/python.exe C:/Users/lbarki/PycharmProjects/ApplyRules/removeSubscriber.py ".$email;
		$output = shell_exec($command);
		echo "<p>$output</p>";
	}
}

if(!empty($_POST['feed_list']) || !empty($_POST['cutomUrl'])) 
{
	if(!empty($_POST['cutomUrl']))
	{
		$selected = "https://";
		$selected .= $_POST['cutomUrl'];
		
		if(isset($_POST['save']))
		{
			if(!empty($_POST['vendor']) && !empty($_POST['version']))
			{
				$command = "C:/Users/lbarki/PycharmProjects/ApplyRules/venv/Scripts/python.exe C:/Users/lbarki/PycharmProjects/ApplyRules/processVendor.py ".$_POST['vendor']." ".$_POST['version']." ".$_POST['cutomUrl'];
				$output = shell_exec($command);
				echo $output;
				echo "</br><hr width=100% align=left></br>";
			}
			else
			{
				exit('Not saved!!, Please retry by filling all the details.');
			}
		}
	}
	else
	{
		$selected = $_POST['feed_list'];
	}
	$command = "C:/Users/lbarki/PycharmProjects/ApplyRules/venv/Scripts/python.exe C:/Users/lbarki/PycharmProjects/ApplyRules/ApplyRules.py ".$selected." ".$flag." ".$email;
	$output = shell_exec($command);
	echo $output;
	echo "</br><hr width=100% align=left></br>";
}
else
{
	echo "<b>Please Select atleast One Option.</b>";	
}



?>
</body>
</html>