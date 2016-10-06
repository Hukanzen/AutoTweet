<?php
//	//function cov_youbi($e_youbi,$j_youbi)
//	function cov_youbi($e_youbi)
//	{
//		$j_youbi=array(
//				"1" => "月",
//				"2" => "火",
//				"3" => "水",
//				"4" => "木",
//				"5" => "金",
//				"6" => "土",
//				"0" => "日"
//		);
//		return $j_youbi[$e_youbi];
//	}
//
//	function holiday($year,$month,$day){
//		$holi=file_get_contents("http://calendar-service.net/cal?start_year=".$year."&start_mon=".$month."&end_year=".$year."&end_mon=".$month."&year_style=normal&month_style=numeric&wday_style=ja&format=csv&holiday_only=1&zero_padding=1");
//		//$holi=file_get_contents("http://calendar-service.net/cal?start_year=2016&start_mon=01&end_year=2016&end_mon=01&year_style=normal&month_style=ja&wday_style=ja&format=csv&holiday_only=1&zero_padding=1");
//		if(!$holi){
//			$holi=file_get_contents("http://calendar-service.net/cal?start_year=".$year."&start_mon=".$nomth."&end_year=".$year."&end_mon=".$month."&year_style=normal&month_style=ja&wday_style=ja&format=csv&holiday_only=1&zero_padding=1");
//		}
//
//	/*=== mojibake ===*/
//		$holi=mb_convert_encoding($holi,"utf-8","auto");
//		
//	/*=== to 1 array ===*/
//		$holi_1=explode("\n",$holi);
//	
//	/*=== holi_2's height size ===*/
//		$cnt=0;
//
//	/*=== to 2 array ===*/
//		for($i=0;$holi_1[$i]!=NULL;$i++){
//			$holi_2[$i]=explode(",",$holi_1[$i]);
//			$cnt++;
//		}
//
//	/*=== 0year,1month,2day,3heisei,4japanese_year,5day of the week,6number_day_of_the_week,7name_of_shukujitsu ===*/
//
//		for($i=1;$i<$cnt;$i++){
//			if($day == $holi_2[$i][2]){
//				return $holi_2[$i][7];
//			}
//		}
//
//		return "";
//
//	}
//
//function create_tweet($type){
//
//	$now=array(
//		"year"  => date("Y"),
//		"month" => date("m"),
//		"day"   => date("d"),
//		"hour"  => date("H"),
//		"min"   => date("i"),
//		"sec"   => date("s"),
//		"youbi" => date("w")
//	);
//
//	$holi_tweet_data=holiday($now["year"],$now["month"],$now["day"]);
//
//	//$now["youbi"]=cov_youbi($now["youbi"],$j_youbi)."曜日";
//	$now["youbi"]=cov_youbi($now["youbi"])."曜日";
//	
//	if($type==0){
//		return $tweet_data=
//						//$to_tweet_data." ".
//						'今は' ." ".
//						$now["year"]    ."/".
//						$now["month"]   ."/".
//						$now["day"]     .' '.
//						$now["hour"]    .':'.
//						$now["min"]     .':'.
//						$now["sec"]     .' '.
//						$now["youbi"]   .' '.
//						$holi_tweet_data.' '.
//						'です. #TwitterBot制作';
//
//	}else if($type==1){
//		return " ";
//	}else if($type==2){
//		return $tweet_data=
//			output_book_data()." ".$now["hour"]."h".$now["min"]."m".$now["sec"]."s";
//	}else if($type==3){
//		return output_birthday();
//	}else if($type==4){
//		return top_data();
//	}
//}
//
//function output_book_data(){
//	require dirname(__FILE__).'/connect.php';
//	
//	$query="SELECT id,book_name,kansu,release_date FROM twitter.book_release;";
//	
//	$i=0;
//	if($result=mysqli_query($link,$query)){
//		while($row_id[$i]=mysqli_fetch_row($result)) $i++;
//	}
//
//	if($row_id[0]==NULL) return "登録がありません";
//
//	srand((float) microtime() * 10000000);
//	
//	$j=0;
//	do{
//		/*=== random ===*/
//		$rand_id=rand(0,$i-1);
//		$current=date("Y-m-d");
//		$j++;
//
//	}while($current>$row_id[$rand_id][3] && $i+1!=$j);
//
//	if($row_id[$rand_id]==NULL) return "MISS";
//
//	$day_diff=calc_d_diff($current,$row_id[$rand_id][3]);
//
//	//var_dump($row_id[$rand_id][1]);
//	
//	return $output=
//						$row_id[$rand_id][1]." ".
//						$row_id[$rand_id][2]."巻".
//						"の発売日まで あと"." ".
//						$day_diff." ".
//						"日です.";
//}
//
//function calc_d_diff($current,$release_data){
//
//	//var_dump($current);
//	//var_dump($release_data);
//
//	$current     =new Datetime($current);
//	$release_data=new Datetime($release_data);
//
//	$diff=date_diff($release_data,$current);
//	//var_dump($diff->days);
//
//	return ($diff->days);
//}
//
//function output_birthday(){
//	require dirname(__FILE__).'/connect.php';
//	
//	$query="SELECT id,name,birthday FROM twitter.birthday;";
//	
//	$n=0;
//	if($result=mysqli_query($link,$query)){
//		while($row_id[$n]=mysqli_fetch_row($result)) $n++;
//	}
//
//	$current="1000-".date("m-d");
//
//	$bir_jname=NULL;	
//	$bir_ename=NULL;	
//
//	$k=0;
//	for($i=0;$i<$n;$i++){
//		if($row_id[$i][2]==$current){
//			if($bir_jname==NULL){
//				$bir_jname=$row_id[$i][1];
//				$bir_ename=$row_id[$i][1];
//			}else{
//				$bir_jname=$bir_jname."と".$row_id[$i][1];
//				$bir_ename=$bir_ename."'s and".$row_id[$i][1];
//			}			
//			$k++;
//		}
//	}
//
//	if($bir_jname==NULL){
//		return "今日誕生日の人は知りません．\n";
//					
//	}else{
//		return 	"今日は".$bir_jname."の誕生日です．\n";
//	}
//}
//
//function top_data(){
//	system("top -b -n 1 > top_result.log");
//	system("perl top_cut.pl");
//}

function table_check_create($link,$table){
	$sql="SHOW TABLES FROM mecab;";
	$aRST=db_fetch($sql,$link);
	//var_dump($aRST);
	foreach($aRST as $key => $table_name){
		if($table_name['Tables_in_mecab'] == ("POSpeech_".$table."_db")){
			return 0;
		}
	}
	
	$sql="create table mecab.POSpeech_".$table."_db(ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,Data TEXT);";
	db_query($sql,$link);
	return 1;
}

function is_alpha($str){
    if (preg_match("/[a-zA-Z0-9]+/",$str)) {
        return 1;
    } else {
        return 0;
    }
}

function only_kana_kanji($str){
	if(preg_match("/^[ぁ-んァ-ヶー一-龠、 ]+$/u",$str)){
		/* ひらがな・カタカナ漢字のみ */
		return 1;
	}else{
		return 0;
	}
}
?>

