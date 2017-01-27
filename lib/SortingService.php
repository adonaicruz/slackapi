<?php
/*!
 * Sorting Service Class
 * 
 * @version     0.0.2
 * @author adonaicruz <adonai.cruz@gmail.com>
 * @license This software is licensed under the MIT license: http://opensource.org/licenses/MIT
 * 
 */


class SortingService {
	protected $data,$header;
	var $sort;

	 /**
     * Create instance and load data
     *
     * @param null|json|array   $data   Table data to be sorted
     * @return SS
     * @throws Exception
     *
     */
    function __construct($data) {
    	if($data === null){
    		throw new Exception('Table data can not be null .');
    	}else{
            $this->load($data);
        }
        return $this;
    }

     /**
     * Load table data
     *
     * @param json|array   $data   Table data to be sorted
     * @param bolean       $header It says if the table has headers
     * @return array
     * @throws Exception
     *
     */
    function load($data) {

        $this->data = $data;
        return $this->data;
    }
    
    /**
     * Get table data
     *
     * @return array
     *
     */
    public function getData() {
    	return $this->data;
    }

    /**
     * Get table header
     *
     * @return array
     *
     */
    public function getHeader() {
    	return $this->header;
    }
    /**
     * Get table id
     *
     * @return array
     *
     */
    public function getId() {
    	$vId = array();
    	foreach($this->data as $data):
    		$vId[] = $data[0];
    	endforeach;
    	return $vId;
    }

    /**
     * Method to Sort Array
     *
     * @param  array   $sort   array('column'=>'order') - Column=[0,1,n], order=[asc,desc]
     * @return array
     *
     */
    public function sort($sort) {
    	if($sort === null){
    		throw new Exception('Sort param must be an array.');
    	}
    	if(is_array($sort)){
	    	$this->sort = $sort;
	    	usort($this->data, array($this, 'check'));
    	}
    	return $this->data;
    }

    public function filter($collumn,$param,$value) {      
        $this->data = array_filter($this->data, function ($array) use($param,$collumn,$value){
            $cases = array(
                '='=>$array[$collumn] == $value,
                '>='=>$array[$collumn] >= $value,
                '<='=>$array[$collumn] <= $value,
                '>'=>$array[$collumn] > $value,
                '<'=>$array[$collumn] < $value,
            );
            return $cases[$param];
        });
        
    }

    public function limit($page,$rpp) {   
        $qnt = count($this->data);
        $offset = $rpp*($page-1);
        $this->data = array_slice($this->data, $offset,$rpp);
    }


    /**
     * Helper to check the data order. Compare 2 rows [a,b] and check the position
     *
     * @return int
     *
     */
	protected function check($a, $b){
		foreach($this->sort as $column=>$order):
			if ($a[$column] == $b[$column]) {
				$return = 0;
			}else{
				if($order == "desc"){
					return ($a[$column] > $b[$column]) ? -1 : 1;
				}else{
					return ($a[$column] < $b[$column]) ? -1 : 1;
				}
			}
		endforeach;

		return $return;
		
	}
}