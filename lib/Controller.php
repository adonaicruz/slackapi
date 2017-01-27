<?php 
require_once 'lib/Api.php';
require_once 'lib/SortingService.php';
class Controller extends Api{
	
	function question(){
		if ($this->method !== 'GET') {
        	throw new Exception("Method not allowed");
        }

		//loading json data to be sorted
		$json_data = file_get_contents("data.json");
		
		//Create a var with the orinal data to compare
		$arrayData = json_decode($json_data, true);

       $ss = new SortingService($arrayData['content']);
       if(array_key_exists('score', $this->request)){
       		$ss->filter('score','>=',$this->request['score']);
       }
       if(array_key_exists('sort', $this->request)){
       		$ss->sort(array($this->request['sort']=>'asc'));
       }
       if(array_key_exists('page', $this->request) && $this->request['page'] > 0 && array_key_exists('rpp', $this->request) && $this->request['rpp'] > 0){
       		$ss->limit($this->request['page'],$this->request['rpp']);
       }
       
       $arrayData['content'] = $ss->getData();

       return $arrayData;
	}



}