<?
    function getLifts($lifts){
        $string="";
        $lifts = rtrim($lifts,"|");
        $lifts = ltrim($lifts,"|");
        $lifts = explode("|",$lifts);
        
        
        $i=1;
        foreach($lifts as $lift){
            $result = db::query("select * from lifts where lift_id = $lift");
            $string .= $result[0]['lift_name'];
            if($i<sizeof($lifts))
                $string .= ", ";
            $i++;
        }
        return $string;
    }

    function query($query){
		$result = mysqli_query(db::$conn,$query);
		return $result;
	}

    function get_query($query)
    {
            $rows = array();
            
            $result = mysqli_query(db::$conn,$query);
            
            if(is_object($result)){
                while($row=mysqli_fetch_array($result)){
                    $rows[] = $row;
                }
            }
           
            return $rows;
    }     

?>