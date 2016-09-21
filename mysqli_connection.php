<?php

	//mysqli 関連の自作関数

	function db_connect(){
		$linkid=mysqli_connect('localhost','twitter','twitter','mecab');
		if(!$linkid) die("Failure mysqli_connect".mysqli_error($linkid));
		mysqli_set_charset($linkid,"utf8");
		return $linkid;
	}

	function db_select($linkid){
		$db_rslt=mysqli_select_db('mecab',$linkid);
		if(!$db_rslt) die("Failure select db".mysqli_error($linkid));
	}

	function db_query($SQL,$linkid){
		$rslt=mysqli_query($linkid,$SQL);
		if(!$rslt) die("$SQL is Failure".mysqli_error($linkid));
		return $rslt;
	}

	function db_fetch($SQL,$linkid){
		$data=array();
		$rslt=db_query($SQL,$linkid);
		while($fet=mysqli_fetch_assoc($rslt)){
			array_push($data,$fet);
		}
		return $data;
	}

	function db_a_query($aSQL,$linkid){
		$aRSLT=array();
		foreach($aSQL as $sql){
			$rslt=db_query($sql,$linkid);
			if(!$rslt){
				die("$sql is Failure.".mysqli_error($linkid));
				break;
			}
			array_push($aRSLT,$rslt);
		}
		return $aRSLT;
	}

	function db_a_fetch_assoc($aSQL,$linkid){
		$aRSLT=db_a_query($aSQL,$linkid);
		$aFET=array();
		$i=0;
		foreach($aRSLT as $rslt){
				array_push($aFET,array());
			while($fet=mysqli_fetch_assoc($rslt)){
				array_push($aFET[$i],$fet);
			}
			$i++;
		}
		return $aFET;
	}

	function db_close($linkid){
		mysqli_close($linkid);
	}
?>
