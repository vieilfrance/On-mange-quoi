<?php defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller
{ // TODO : proposer un format de réponse pour l'api

// {
//     "metadata": {
//         "resultset": {
//             "count": 123,
//             "offset": 0,
//             "limit": 10
//         }
//     },
//     "results": [
//         {}
//         ]
//     }
// }

	function Meal_get(){
		$this->load->model('Meal');
		$meal = $this->Meal->get_meal();
	    if($meal)
	    {
		$this->response(array("results"=>$meal),200); // on doit avoir une réponse d'une idée à manger au hasard sans limitation mais en tenant compte de la saison. Faut prévoir une marge si on arrive en fin de saison pour aller choper un peu sur la saison d'apres
		// prévoir qu'on puisse filtrer sur la 'note' (sucré , salé)
	    }
	    else
	    {
	      $this->response(array('error' => 'No result'), 400); // TODO c'est pas vraiment ça ... quand y a zéro resultat ca doit être une 200. 
	    }
	}

	function Meals_get(){ // liste des idée à manger avec pagination et limite
    $this->load->model('Meal');
    $meal = $this->Meal->get_meals();
      if($meal)
      {
    $this->response(array("results"=>$meal),200); // on doit avoir une réponse d'une idée à manger au hasard sans limitation mais en tenant compte de la saison. Faut prévoir une marge si on arrive en fin de saison pour aller choper un peu sur la saison d'apres
    // prévoir qu'on puisse filtrer sur la 'note' (sucré , salé)
      }
      else
      {
        $this->response(array('error' => 'No result'), 400); // TODO c'est pas vraiment ça ... quand y a zéro resultat ca doit être une 200. 
      }
	}

	function Meal_post() { // ajouter une idée de repas.

    $this->load->model('Meal');
    $meal=array();
    foreach ($this->request->body as $key => $value) {
      switch ($key) {
        case 'name':
          $meal['name']=$value;
          break;
        case 'type':
          $meal['type']=$value;
          break;
        case 'season':
          $meal['season']=$value;
          break;
        default:
          # code...
          break;
      }
    }
    
    $the_id=false;
    if (isset($meal['name'])) {
      $the_id=$this->Meal->new_meal($meal['name'],
                                        $meal['type'],
                                        $meal['season'],
                                        isset($meal['datetime'])? $meal['datetime']:new DateTime('now'));
    }
    if ($the_id!=null)
    {
      $this->response(array('success' => $the_id), 200);      
    }
    else
    {
      $this->response(array('error' => 'insert failed'), 500);
    }

	}

	function Meal_delete() { // supprimer de manière logique un repas.
    $this->load->model('Meal');
    $meal=array();
    $meal['id']=$this->delete('id');
    $meal['datetime']=new DateTime('now');

    $the_id=false;
    if (isset($meal['id'])) {
      $the_id=$this->Meal->suppr_meal($meal['id'],$meal['datetime']);
    }
    if ($the_id)
    {
      $this->response(array('success' => $the_id), 200);      
    }
    else
    {
      $this->response(array('error' => 'suppression failed'), 500);
    }
    
	}

	function Refs_get() { // liste des référentiels. Le résultat est une liste de liste, pour éviter les multiples appels.
		$this->load->model('Refs');
		$refs = $this->Refs->get_refs();
	    if($refs)
	    {
		$this->response(array("results"=>$refs),200); // on doit avoir une réponse d'une idée à manger au hasard sans limitation mais en tenant compte de la saison. Faut prévoir une marge si on arrive en fin de saison pour aller choper un peu sur la saison d'apres
		// TODO prévoir qu'on puisse filtrer sur la 'note' (sucré , salé)
	    }
	    else
	    {
	      $this->response(array('error' => 'No result'), 400); // TODO c'est pas vraiment ça ... quand y a zéro resultat ca doit être une 200. 
	    }
	}

}

?>