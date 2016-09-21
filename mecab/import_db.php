<?php
	require_once(dirname(__FILE__).'/../myfunc/func.php');	
	require_once(dirname(__FILE__).'/../mysqli_connection.php');	
?>
<?php

	$link=db_connect();

	$mecab=new MeCab_Tagger();
 
	// ファイル取得
	$filepath = "tweets.csv";
	$file = new SplFileObject($filepath); 
	$file->setFlags(SplFileObject::READ_CSV);
	// ファイル内のデータループ
	foreach ($file as $key => $line) {
		foreach( $line as $str ){
				$records[ $key ][] = $str ;
		}
		
		$text=$records[$key][5];

		if(!preg_match("/@/",$text)){
			#echo $key." ";

			$text=mb_ereg_replace("\\\\","￥￥￥￥",$text);
			$text=mysqli_real_escape_string($link,$text);
			$sql="INSERT INTO mecab.Tweet(Data) VALUES(\"".$text."\")";
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
	
	db_close($link);	
?>
