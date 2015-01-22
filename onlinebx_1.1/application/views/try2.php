<?php 
require_once ('HttpClient.class.php');
				$term=$_POST['data'];
				$client=new HttpClient('osg.ops.ctripcorp.com');
				$params  = array('request_body'=>'','access_token'=>'204485ba58292e5354d498e977cc372a');
				$pageContents = $client->quickPost('http://osg.ops.ctripcorp.com/api/12103?keyword='.$term, json_encode($params));
				$result=json_decode($pageContents,true);
				$result=$result['empInfoList'];
	//			echo "<script>alert('".$term."');</script>";
				echo urlencode(json_encode($result));

			//echo urlencode(json_encode($result));
?>
