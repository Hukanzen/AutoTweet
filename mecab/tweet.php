<?php 
	require dirname(__FILE__).'/../TwistOAuth.phar'   ;
	require dirname(__FILE__).'/../main/user.php'     ;
	require dirname(__FILE__).'/../main/try_catch.php';
	require dirname(__FILE__).'/../myfunc/func.php'   ;

	require dirname(__FILE__).'/../mysqli_connection.php'   ;
	
	$ln=db_connect('mecab');

	make_tweet:
	$pattern=array();
	
	$sql=array("SELECT * FROM mecab.Junban WHERE j0 = -1");
	$aRES=db_a_fetch_assoc($sql,$ln);
	$count=count($aRES[0]);
	$seed=rand(0,$count);
	
//	echo "id=".$aRES[0][$seed]['ID']."\n";
	echo "ID:".$aRES[0][$seed]['ID']."\tj0:".$aRES[0][$seed]['j0']."\tj1:".$aRES[0][$seed]['j1']."\tj2:".$aRES[0][$seed]['j2']."\n";

	array_push($pattern,$aRES[0][$seed]['j0']);
	array_push($pattern,$aRES[0][$seed]['j1']);
	array_push($pattern,$aRES[0][$seed]['j2']);
	
//	var_dump($aRES);
	
	//for($i=0;$i<10;$i++){
	while(1){
		RELOAD:
		$sql=array("SELECT * FROM mecab.Junban WHERE j0 = ".$aRES[0][$seed]['j2'].";");
		if(!db_num_rows($sql[0],$ln)){
			echo "num make_tweet\n";
			goto make_tweet;
		}
		$aRES=db_a_fetch_assoc($sql,$ln);
		//elseif(!mysql_num_rows
		$count=count($aRES[0]);
		$seed=rand(0,$count);

		echo "ID:".$aRES[0][$seed]['ID']."\tj0:".$aRES[0][$seed]['j0']."\tj1:".$aRES[0][$seed]['j1']."\tj2:".$aRES[0][$seed]['j2']."\n";

		if(!isset($aRES[0][$seed]['j2'])){
			echo "isset RELOAD\n";
			goto RELOAD;
		}


//		array_push($pattern,$aRES[0][$seed]['j0']);
		array_push($pattern,$aRES[0][$seed]['j1']);
		array_push($pattern,$aRES[0][$seed]['j2']);


		if($aRES[0][$seed]['j1']==-1 || $aRES[0][$seed]['j2']==-1){
			break;
		}
	}

	foreach($pattern as $key => $value) echo $value." ";
	
//	var_dump($pattern);
	echo "\n";
	$tweet_data="#自作自動ツイート生成bot\n";
//	for($i=0;$i<rand(1,5);$i++){
		foreach($pattern as $key => $value){
			if($value == -1)	continue;
			elseif($key == 0)     continue;
			$sql=array("SELECT * FROM mecab.POSpeech_".$value."_db;");
			$count=db_num_rows($sql[0],$ln);
			$rndm=rand(0,$count);
			
			$sql=("SELECT * FROM mecab.POSpeech_".$value."_db WHERE ID = ".$rndm.";");
			$rslt=db_fetch($sql,$ln);
			//$count=count($aRES[0]);
			//$text=$aRES[0][rand(0,$count)]['Data'];
			//var_dump($rslt);
			$text=$rslt[0]['Data'];
			$text=mb_ereg_replace("￥￥￥￥","\\\\",$text);
			echo $value.":".$text."\n";
			if(!only_kana_kanji($text)){
				echo "only\n";
				goto make_tweet;
			}
			$tweet_data.=$text;
			//if(preg_match(
		}
		$tweet_data.="。 ";
//	}
	
	if(mb_strlen($tweet_data) >140){
		goto make_tweet;
	}
	
	db_close($ln);

	echo $tweet_data;
	try_catch($cK,$cS,$aT,$aTS,$tweet_data);
?>
