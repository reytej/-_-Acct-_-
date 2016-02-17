<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once (realpath(dirname(__FILE__) . '/..')."/dine/prints.php");
class Search extends Prints {
	var $data = null;
    public function __construct(){
        parent::__construct();        
    }
    public function modifiers(){
        // if ( !$this->input->post() )
        //     redirect(base_url());
        $reference = $this->input->post('q');

        $lk = $reference;
        $args["modifiers.name like '%".$lk."%'"] = array('use'=>'where','val'=>"",'third'=>false);
        $items = $this->site_model->get_tbl('modifiers',$args,array());
        
        $json_array = array();
        foreach ($items as $res) {
            $json_array[] = array(
                'Id'=>$res->mod_id,
                'Text'=>$res->name,
            );
        }
        echo json_encode($json_array);
    }
}