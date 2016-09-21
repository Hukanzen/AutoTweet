<?php 
	require dirname(__FILE__).'/../TwistOAuth.phar'   ;
	require dirname(__FILE__).'/../main/user.php'     ;
	require dirname(__FILE__).'/../main/try_catch.php';
	require dirname(__FILE__).'/../myfunc/func.php'   ;

	require dirname(__FILE__).'/../mysqli_connection.php'   ;
	
	$ln=db_connect();
	$pattern=array();
	
	$sql=array("SELECT * FROM mecab.Junban WHERE j0 = -1");
	$aRES=db_a_fetch_assoc($sql,$ln);
	$count=count($aRES[0]);
	$seed=rand(0,$count);
	
//	echo "id=".$aRES[0][$seed]['ID']."\n";

	array_push($pattern,$aRES[0][$seed]['j0']);
	array_push($pattern,$aRES[0][$seed]['j1']);
	array_push($pattern,$aRES[0][$seed]['j2']);
	
//	var_dump($aRES);
	
	//for($i=0;$i<10;$i++){
	while(1){
		$sql=array("SELECT * FROM mecab.Junban WHERE j0 = ".$aRES[0][$seed]['j2'].";");
		$aRES=db_a_fetch_assoc($sql,$ln);
		$count=count($aRES[0]);
		$seed=rand(0,$count);

		array_push($pattern,$aRES[0][$seed]['j0']);
		array_push($pattern,$aRES[0][$seed]['j1']);
		array_push($pattern,$aRES[0][$seed]['j2']);
//	echo "id=".$aRES[0][$seed]['ID']."\n";

		if($aRES[0][$seed]['j1']==-1 || $aRES[0][$seed]['j2']==-1){
			break;
		}
	}
	
//	var_dump($pattern);
	make_tweet:
	$tweet_data="#自作自動ツイート生成bot\n";
	for($i=0;$i<rand(1,5);$i++){
		foreach($pattern as $key => $value){
			if($value == -1)	continue;
			elseif($key == 0)     continue;
			$sql=array("SELECT * FROM mecab.POSpeech_".$value."_db;");
			$aRES=db_a_fetch_assoc($sql,$ln);
			$count=count($aRES[0]);
			$text=$aRES[0][rand(0,$count)]['Data'];
			$text=mb_ereg_replace("￥￥￥￥","\\\\",$text);
			$tweet_data.=$text;
			//if(preg_match(
		}
		$tweet_data.="。 ";
	}
	
	if(mb_strlen($tweet_data) >140){
		goto make_tweet;
	}
	
	db_close($ln);

	echo $tweet_data;
	try_catch($cK,$cS,$aT,$aTS,$tweet_data);
?>
