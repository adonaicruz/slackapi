<?php
header('Content-Type: application/json; charset=utf-8');


$url = "https://api.stackexchange.com/2.2/questions?order=desc&sort=creation&pagesize=99&site=stackoverflow";

try {
	//GET StackOverflow API Data
    $content = @file_get_contents($url);
    $content = gzdecode($content);

    if ($content === false) {
        throw new Exception("empty data", 1);

    }else{
    	//write local data
    	$filename = "data.json";
    	
    	if($fp = @fopen($filename, "w")){
			fwrite($fp, $content);
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