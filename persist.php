<?php
header('Content-Type: application/json; charset=utf-8');


$url = "https://api.stackexchange.com/2.2/questions?order=desc&sort=creation&pagesize=99&tagged=PHP&site=stackoverflow";

try {
	//GET StackOverflow API Data
    $content = @file_get_contents($url);
    $content = gzdecode($content);
    

    if ($content === false) {
        throw new Exception("empty data", 1);

    }else{

    	$vArrayContent = json_decode($content,1);
	    $vArrayResult = array('last_update'=>time(),'content'=>array());
	    
	    foreach($vArrayContent['items'] as $arrayContent):
	    	
	    	$vArrayResult['content'][] = array(
				"question_id"=>$arrayContent['question_id'],
				"title"=>$arrayContent['title'],
				"owner_name"=>$arrayContent['owner']['display_name'],
				"score"=>$arrayContent['score'],
				"creation_date"=>$arrayContent['creation_date'],
				"link"=>$arrayContent['link'],
				"is_answered"=>$arrayContent['is_answered'],
	    	);
	    endforeach;

    	//write local data
    	$filename = "data.json";
    	
    	if($fp = @fopen($filename, "w")){
			fwrite($fp, json_encode($vArrayResult));
			fclose($fp);
    	}else{
    		throw new Exception("File can not be generated", 1);
    	}

    	$return = array('status'=>1,'message'=>'Dados armazenados com sucesso');
    }
} catch (Exception $e) {
	header('HTTP/1.1 500 Internal Server');
    $return = array('status'=>0,'message'=>'Ops! Ocorreu um erro ao processar a sua solicitação.');
}

echo json_encode($return);