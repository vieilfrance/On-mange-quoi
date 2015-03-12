<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Refs extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_refs()
    {
        //return array('refs' => array ($this->get_RefType(),$this->get_refComplexity(),$this->get_refSeasons()));
        //return array('refs' => array ($this->get_RefType()));
        $t[]=$this->get_RefType();
        $t[]=$this->get_refComplexity();
        $t[]=$this->get_refSeasons();
        return array('refs' => $t);
    }

    function get_RefType()
    {
    $this->load->database();
    $ref=array();
    $param=array();

    $sql = "SELECT ID, LIBELLE FROM REF_TYPE";
    
    $query = $this->db->query($sql, $param);
    $results = $query->result_array();
    $ref = array('name'=>'type','ref' => $this->format($results));
    return $ref;
    }

    function get_refComplexity()
    {
    $this->load->database();
    $ref=array();
    $param=array();

    $sql = "SELECT ID, LIBELLE FROM REF_COMPLEXITY";
    
    $query = $this->db->query($sql, $param);
    $results = $query->result_array();
    $ref = array('name'=>'complexity','ref' => $this->format($results));
    return $ref;
    }

    function get_refSeasons()
    {
    $this->load->database();
    $ref=array();
    $param=array();

    $sql = "SELECT ID, LIBELLE FROM REF_SEASON";
    
    $query = $this->db->query($sql, $param);
    $results = $query->result_array();
    $ref = array('name'=>'season','ref' => $this->format($results));
    return $ref;
    }

    function format($row)
    {
    $formatedResult=Array();
    if ($row)
        {
        foreach ($row as $resultPart) {
            $formatedResultPart=Array(
                'id'=>(is_null($resultPart['ID']) ? '' : $resultPart['ID']),
                'label'=>(is_null($resultPart['LIBELLE']) ? '' : $resultPart['LIBELLE'] ));
            array_push($formatedResult,$formatedResultPart);
            }
        }
    return $formatedResult;
    }

}

