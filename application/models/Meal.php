<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Meal extends CI_Model {

    var $id;
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


    $sql = "SELECT RECIPES.ID, RECIPES.NAME, REF_TYPE.LIBELLE as 'TYPE', REF_SEASON.LIBELLE as 'SEASON'  FROM RECIPES,REF_TYPE, REF_SEASON WHERE RECIPES.IS_DELETED ISNULL AND RECIPES.type=REF_TYPE.id AND ((RECIPES.SEASON/$seasonId)%2)>0  AND RECIPES.SEASON=REF_SEASON.id ORDER BY RANDOM() LIMIT 1";
   //  $sql = "SELECT RECIPES.ID, RECIPES.NAME, REF_TYPE.LIBELLE as 'TYPE', REF_SEASON.LIBELLE as 'SEASON'  FROM RECIPES,REF_TYPE, REF_SEASON WHERE  RECIPES.type=REF_TYPE.id  AND RECIPES.SEASON=REF_SEASON.id ORDER BY RANDOM() LIMIT 1";
    $query = $this->db->query($sql, $param);
    $results = $query->result_array();
    foreach ($results as $row) {
        $meals[] = $this->meal_format($row);
    }        
    return $meals;
    }

    function get_meals()
    {
        $this->load->database();
        $meals=array();
        $param=array();

    $sql = "SELECT RECIPES.ID, RECIPES.NAME, REF_TYPE.LIBELLE as 'TYPE', REF_SEASON.LIBELLE as 'SEASON' FROM RECIPES,REF_TYPE, REF_SEASON WHERE RECIPES.IS_DELETED ISNULL AND RECIPES.TYPE=REF_TYPE.ID AND RECIPES.SEASON=REF_SEASON.ID ORDER BY RECIPES.CREATED DESC";
    
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
               'created'     => $datetime->format('Y-m-d H:i:s'),
               'season'   => $season
            );
        $sql = $this->db->insert_string('recipes', $data);
        $this->db->query($sql);
        return $this->db->insert_id();
    }

    function suppr_meal($id,$datetime) 
    {
        $this->load->database();
        //$sql ="DELETE FROM RECIPES WHERE RECIPES.id = ".$id ; // ne pas faire de delete physique mais logique. 
        $sql= "UPDATE RECIPES SET IS_DELETED = \"".$datetime->format('Y-m-d H:i:s')."\" WHERE RECIPES.ID=".$id; // s'il est déjà supprimé, ,ne pas dire ok mais un message d'info
        $query = $this->db->query($sql);
        if ($this->db->affected_rows()!=0)
            return true;
        else
            return false;

    }


    function meal_format($row)
    {
        return array(
                    'id'        =>  $row['ID'],
                    'name'      =>  $row['NAME'],
                    'type'      =>  $row['TYPE'],
                    'season'    =>  $row['SEASON']
                    );
    }

}

