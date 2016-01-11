<?php require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;
$CONSUMER_KEY= "k4HFxQnglNh9QWUrm8i3knWBM";
$CONSUMER_SECRET= "7WoAJ4nhtPFwvhdo8MbPx6J14T4pQDOWatJK4u0v9dgmzGBSmq";
$access_token="4739069604-w6jlCiISFFnI8PPoPkmTqgZR8uofret7diXliDw";
$access_token_secret="NvRzQslw0EbX6sTurfafhyXqolXXUscR9Jey4zz1UdkJW";
$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token, $access_token_secret);
$content = $connection->get("account/verify_credentials");


?>
<html>
<head>
	
</head>
<body>


</form>

<?php

if(isset($_GET['tweeter_id'])){
	
$tweets=$connection->get("statuses/user_timeline", array("screen_name" =>$_GET['tweeter_id'],"count" => "200"));
	//var_dump($tweets);
	//exit();
	// echo "<pre>";
	// print_r($tweets->statuses);
	// echo "</pre>";
	$created_times = [];
	$day_map=array("Sun"=>0,"Mon" => 1,"Tue" => 2,"Wed" => 3,"Thu" => 4, "Fri" => 5, "Sat" => 6);
	$times=[];
	$weekly = array("Sun"=>0,"Mon" => 0,"Tue" => 0,"Wed" => 0,"Thu" => 0, "Fri" => 0, "Sat" => 0);
	$hourly = [];
	foreach ($tweets as $status) {
		
		//$created_times[] = $status->created_at;
		$day=(string)substr($status->created_at,0,3);
		$weekly[$day]++;
		$hour=(string)substr($status->created_at,11,2);
		//echo "$hour | ";
		$hourly[$hour]++;


		# code...
	}
	//var_dump(max($weekly));
	//var_dump(max($hourly));
	$key_day_str = array_search(max($weekly), $weekly);
	$result_time= array_search(max($hourly), $hourly);
	$result_day=$day_map[$key_day_str];
	$result_time_count=max($hourly);
	$result_day_count=max($weekly);
	$result_array_day=array($result_day => $result_day_count);
	$result_array_time=array($result_time => $result_time_count);
	$tweets1=$connection->get("statuses/user_timeline", array("screen_name" =>$_GET['tweeter_id'],"count" => "200"));
	//var_dump($hashtags);
	//var_dump($hashtags);
	$freq_hashtag_count=[];
	$hashtags=[];
	$hashtags_final=[];
	foreach ($tweets1 as $tweet) {
		$hashtags[]= $tweet->entities->hashtags;
		# code...
	}
	foreach($hashtags as $key => $value)
	{
		if($value["0"]->text)
		{
			$hashtags_final[]=$value["0"]->text;
			$freq_hashtag_count[$value["0"]->text]++;


		}
	}
	//var_dump($freq_hashtag_count);
	 $result_array=[];
	//var_dump($result_array_day);
	//var_dump($result_array_time);



	//var_dump($key);
	//var_dump($weekly);
	//var_dump($hourly);
}
// function max($str)
// {
// 	if($str=="day")
// 	{
// 		$weekdays=array("Sun"=>0,"Mon" => 1,"Tue" => 2,"Wed" => 3,"Thu" => 4, "Fri" => 5, "Sat" => 6)
// 		$max=0;
// 		foreach($days as $day)
// 		{

// 		}

// 	}
// }


// foreach ($tweets as $tweet) {
// 	echo $tweet->text;
// 	# code...
// }

	//$hashtags=$connection->get(" https://api.twitter.com/1.1/search/tweets.json?q=from".$_POST['keyword1']."&result_type=popular");
	
	 //$n=10;
	 
	 
	 if(isset($_GET['tweeter_id']) && isset($_GET['time_span']))
	 {
	 	if($_GET['time_span']=="day")
	 	{
	 		echo json_encode($result_array_day);
	 	}
	 	else if($_GET['time_span']=="hour")
	 	{
	 		echo json_encode($result_array_time);
	 	}
	 }
	 else if(isset($_GET['tweeter_id']) && isset($_GET['n']))
	 {
	 	while($_GET['n']>0)
	 {
	 	$str = array_search(max($freq_hashtag_count), $freq_hashtag_count);
		$count=max($freq_hashtag_count);
	 	//var_dump(array_search(max($freq_hashtag_count), $freq_hashtag_count));
	 	$freq_hashtag_count[array_search(max($freq_hashtag_count), $freq_hashtag_count)]=-1;
	 	//unset($frequent_hashtag_count[array_search(max($freq_hashtag_count), $freq_hashtag_count)]);
	 	//var_dump($freq_hashtag_count)
		$result_array[$str]=$count;
		$_GET['n']--;
	 	//$n--;
	 	//var_dump($str);

	 }
	 echo json_encode($result_array);
	 //var_dump($result_array);

	 }
	
	
	

	
	

 ?>

</body>
</html>