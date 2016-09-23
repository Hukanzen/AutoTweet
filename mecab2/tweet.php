<?php 
	require dirname(__FILE__).'/../TwistOAuth.phar'   ;
	require dirname(__FILE__).'/../main/user.php'     ;
	require dirname(__FILE__).'/../main/try_catch.php';
	require dirname(__FILE__).'//func.php'   ;

	require dirname(__FILE__).'/../mysqli_connection.php'   ;
	
	$ln=db_connect('mecab2');

	$pattern=array();
	
	$sql=array("SELECT * FROM mecab2.Junban WHERE j0 = -1");
	$aRES=db_a_fetch_assoc($sql,$ln);
	$count=count($aRES[0])-1;

	$seed=rand(0,$count);

	array_push($pattern,$aRES[0][$seed]['j0']);
	array_push($pattern,$aRES[0][$seed]['j1']);
	array_push($pattern,$aRES[0][$seed]['j2']);
	
//	var_dump($aRES);
	//for($i=0;$i<10;$i++){
	while(1){
		//echo "seed".$seed."\n";
	//	print_r($aRES[0]);
		$sql=array("SELECT * FROM mecab2.Junban WHERE j0 = ".$aRES[0][$seed]['j2'].";");
		/* $a[RES][0][$seed]['j2']の値がうまく、j0にない場合、エラーで終了 */
//		echo $sql[0];
		$aRES=db_a_fetch_assoc($sql,$ln);
		$count=count($aRES[0])-1;

//		RETRY_seed1:
		$seed=rand(0,$count);
//		if((($aRES[0][$seed]['j2'])===''&&($aRES[0][$seed]['j2']) != 0) || (($aRES[0][$seed]['j2'])===null &&($aRES[0][$seed]['j2']) != 0 )){
//			goto RETRY_seed1;
//		}
	//	echo $seed;
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
	$tweet_data="#自作自動エロツイート生成bot\n";
	//for($i=0;$i<rand(1,5);$i++){
		foreach($pattern as $key => $value){
			if($value == -1)	continue;
			elseif($key == 0)     continue;
			$sql=array("SELECT * FROM mecab2.POSpeech_".$value."_db;");
			$aRES=db_a_fetch_assoc($sql,$ln);
			$count=count($aRES[0]);

	//		RETRY_text:
			$text=' ';
			$text=$aRES[0][rand(0,$count)]['Data'];
	//		if((($text)===''&&($text) != 0) || (($text)===null &&($text) != 0 )){
	//			goto RETRY_text;
	//		}


			$text=mb_ereg_replace("￥￥￥￥","\\\\",$text);
			$tweet_data.=$text;
			//if(preg_match(
		}
		$tweet_data.="。 ";
	//}
	
	if(mb_strlen($tweet_data) >140){
		goto make_tweet;
	}
	
	db_close($ln);

//	echo $tweet_data;
	try_catch($cK,$cS,$aT,$aTS,$tweet_data);
?>
