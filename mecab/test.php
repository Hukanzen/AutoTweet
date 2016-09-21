<?php
	$str="すももももももものうち";
	$str="(タバコすって)ないです";
	$mecab=new MeCab_Tagger();

	$nodes=$mecab->parseToNode($str);

	foreach($nodes as $n){
		echo $n->getId()."\t:";
		//echo $n->getFeature()."\n";
		echo $n->getSurface()."\n";
	}
?>
