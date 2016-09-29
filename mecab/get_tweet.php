<?php
	require dirname(__FILE__).'/../TwistOAuth.phar'   ;
	require dirname(__FILE__).'/TwistOAuth.php'   ;
	require dirname(__FILE__).'/../main/user.php'     ;
	require dirname(__FILE__).'/../main/try_catch.php';
	require dirname(__FILE__).'/../myfunc/func.php'   ;

	require dirname(__FILE__).'/../mysqli_connection.php'   ;

	set_time_limit(0);

	$to=new TwistOAuth($cK,$cS,$aT,$aTS);
//	$to=new TwistCredential($cK,$cS,$aT,$aTS);
	
	$mecab=new MeCab_Tagger();

	$data=$to->get('',$to);
//	foreach(new TwistLterator($data) as $req){
//		echo $req->response->text;
//	}
//	$data=$to->streaming(
	//	'statuses/sample',
	//	function($status)use($to){
	//		$text=$status->text;
	//		if(preg_match("/@/",$text) || preg_match("/?/",$text)){
	//			;
	//		}else{
	//			echo $text;
	//		}
	//		//echo $i;
	//		//exit;
	//	}
//		'statuses/sample',
//		function($status) use($to){
//			if(isset($status->text)){
//				try{
//	//				echo $status->text;
	$link=db_connect('mecab');
	
	foreach($data as $key => $value){
		$text=$value->text;
//		var_dump($value);
		if(!preg_match("/@/",$text)){
			$text=mb_ereg_replace("\\\\","￥",$text);
			$text=mysqli_real_escape_string($link,$text);
			$sql="INSERT INTO mecab.Tweet(Data) VALUES(\"".$text."\")";
			echo $sql."\n";
			db_query($sql,$link);

			$nodes=$mecab->parseToNode($text);
			
			$i=0;
			$junban=array(-1,-1,-1);
			foreach($nodes as $n){
				table_check_create($link,$n->getId());
			//	if(($n->getId())<=68){
					$word=$n->getSurface();
					$word=mb_ereg_replace("\\\\","￥",$word);
					$word=mysqli_real_escape_string($link,$word);
					$sql="INSERT INTO mecab.POSpeech_".$n->getId()."_db(Data) VALUES(\"".$word."\");";
					db_query($sql,$link);
					$junban[$i%3]=$n->getId();
					if($i==2){
						$sql="INSERT INTO mecab.Junban(j0,j1,j2) VALUES("."-1".",".$junban[1].",".$junban[2].");";
						db_query($sql,$link);
						$junban=array(-1,-1,-1);
					}elseif($i!=0 && !($i%3)){
						$sql="INSERT INTO mecab.Junban(j0,j1,j2) VALUES(".$junban[0].",".$junban[1].",".$junban[2].");";
						db_query($sql,$link);
						$junban=array(-1,-1,-1);
					}
					$i++;
			//	}
			}
		}else{
			continue;
		}
	}

//	var_dump($data);
//	exit;


	db_close($link);	
//	var_dump($data);
?>
