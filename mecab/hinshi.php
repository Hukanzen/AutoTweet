<?php
	require_once(dirname(__FILE__).'/../mysqli_connection.php');	

//	$link=db_connect();

//	$mecab=new MeCab_Tagger();
 
	// ファイル取得
	$filepath = "/usr/local/lib/mecab/dic/ipadic/pos-id.def";
	$file = new SplFileObject($filepath); 
	$file->setFlags(SplFileObject::READ_CSV);
	 
	// ファイル内のデータループ
	foreach ($file as $key => $line) {
 
		foreach( $line as $str ){
 
				$records[ $key ][] = $str ;
		}
		preg_match("/\d+/",$records[$key][3],$posid);
		//echo $posid."\n";
		print_r($posid);
		
//		$text=$records[$key][5];
//		if(!preg_match("/@/",$text)){
//			$sql="INSERT INTO mecab.Tweet(Data) VALUES(\"".$text."\")";
//			//echo $sql."\n";
//			db_query($sql,$link);
//
//			$nodes=$mecab->parseToNode($text);
//			foreach($nodes as $n){
//			//	echo $n->getId()."\n";
//			//	echo $n->getFeature()."\n";
//			//	echo $n->getSurface()."\n";
//				$sql="INSERT INTO mecab.POSpeech_".$n->getId()."_db(Data) VALUES(\"".$n->getSurface()."\");";
//				if($n->getId()==75){
//					echo $n->getSurface()."\n";
//					echo $text;
//					exit;
//				}
//				db_query($sql,$link);
//			}
//		}else{
//			continue;
//		}
// 
	}

//	print_r($records);
//	
//	db_close($link);	
?>
