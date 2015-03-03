<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model {

    var $title   = '';
    var $type = '';
    var $season    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_meal()
    {
        $this->load->database();
        $meals=array();
        $param=array();
        $queryDay = date("z");

        $seasonId = 1;

        if ($queryDay <= 79 )
                $seasonId = 8 ;
        elseif ($queryDay <= 171 )
                $seasonId = 1 ;
        elseif ($queryDay <= 255 )
                $seasonId = 2 ;
        elseif ($queryDay <= 345 )
                $seasonId = 4 ;
        else $seasonId = 8 ;

    //0-79 : hiver
    //80-171 : printemps
    //172-255 : été
    //256 - 345 : autome 
    //346 - 365 : hiver 


    $sql = "SELECT RECIPES.id, RECIPES.name, REF_TYPE.libelle as 'type' FROM RECIPES,REF_TYPE WHERE RECIPES.type=REF_TYPE.id AND ((RECIPES.season/ ".$seasonId.")%2)>0 ORDER BY RANDOM() LIMIT 1";
    
    $query = $this->db->query($sql, $param);
    $results = $query->result_array();
    foreach ($results as $row) {
        $meals[] = $this->meal_format($row);
    }        
    return $meals;
    }

    function new_meal($name,$type,$season,$datetime)
    {
        $this->load->database();
        $data = array(
               'name'         => $name ,
               'type'         => $type,
//               'datetime'     => $add_date->format('Y-m-d H:i:s'),
               'season'   => $season
            );
        $sql = $this->db->insert_string('recipes', $data);
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    function meal_format($row)
    {
        return array(
                    'id'            =>  $row['id'],
                    'name'          =>  $row['name'],
                    'type'   =>  $row['type'] 
                    );
    }

}

