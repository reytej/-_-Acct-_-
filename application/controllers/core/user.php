<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	var $data = null;
	public function index(){
        $this->load->helper('site/site_forms_helper');   
		$result = $this->site_model->get_tbl('user_roles');
        $th = array('Username','Name','Role','Date Registered','Inactive');
        $data = $this->syter->spawn('user');
        $data['code'] = create_rtable('users','id','users-tbl',$th,null,false,'grid');
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'usersListJs';
        $data['page_no_padding'] = true;
        // $data['sideBarHide'] = true;
        $this->load->view('page',$data);
	}
    public function get_users($id=null,$asJson=true){
        $post = array();
        $page = "";

        $joinTables['user_roles'] = array('content'=>'users.role = user_roles.id');
        $select = 'users.*, user_roles.role';
        $items = $this->site_model->get_tbl('users',array(),array('users.id'=>'asc'),$joinTables,true,$select);
        $json = array();
        if(count($items) > 0){
            foreach ($items as $res) {
                $json[$res->id] = array(
                    // "id"=>$res->id,   
                    // "subtitle"=>$res->username,   
                    "title"=>$res->fname." ".$res->mname." ".$res->lname." ".$res->suffix,   
                    "subtitle"=>$res->role,   
                    "caption"=>sql2Date($res->reg_date),
                    "inactive"=>($res->inactive == 0 ? 'No' : 'Yes')
                );
                $ids[] = $res->id;
            }
            $images = $this->site_model->get_image(null,null,'users',array('images.img_ref_id'=>$ids)); 
            foreach ($images as $res) {
                if(isset($json[$res->img_ref_id])){
                    $js = $json[$res->img_ref_id];
                    $js['image'] = $res->img_path;
                    $json[$res->img_ref_id] = $js;
                }
            }
        }
        if($asJson){
            // echo json_encode($json);
            echo json_encode(array('rows'=>$json,'page'=>"",'post'=>$post));
        }
        else{
            return array('rows'=>$json,'page'=>"",'post'=>$post);   
            // return $json;
        }
    }
	public function users_form($ref=null){
        $this->load->helper('core/user_helper');
        $this->load->model('core/user_model');
        $data = $this->syter->spawn('user');
        $user = array();
        $img = array();
        if($ref != null){
            $users = $this->user_model->get_users($ref);
            $user = $users[0];
            $result = $this->site_model->get_image(null,$ref,'users');
            if(count($result) > 0){
                $img = $result[0];
            }
        }
        // echo var_dump($user);
        $data['code'] = makeUserForm($user,$img);
        $data['load_js'] = 'site/admin';
        $data['use_js'] = 'userFormJs';
        $this->load->view('page',$data);
    }
    public function users_db(){
        $this->load->model('core/user_model');
        $this->load->model('site/site_model');
        $items = array();

        if($this->input->post('id')){
            $items = array(
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
                "pin"=>$this->input->post('pin'),
                "inactive"=>(int)$this->input->post('inactive'),
            );

            $this->user_model->update_users($items,$this->input->post('id'));
            $id = $this->input->post('id');
            $act = 'update';
            $msg = 'Updated User '.$this->input->post('fname').' '.$this->input->post('lname');
        }
        else{
            $items = array(
                "username"=>$this->input->post('uname'),
                "password"=>md5($this->input->post('password')),
                "fname"=>$this->input->post('fname'),
                "mname"=>$this->input->post('mname'),
                "lname"=>$this->input->post('lname'),
                "role"=>$this->input->post('role'),
                "suffix"=>$this->input->post('suffix'),
                "gender"=>$this->input->post('gender'),
                "email"=>$this->input->post('email'),
                "pin"=>$this->input->post('pin'),
                "inactive"=>(int)$this->input->post('inactive'),
            );

            $id = $this->user_model->add_users($items);
            $act = 'add';
            $msg = 'Added  new User '.$this->input->post('fname').' '.$this->input->post('lname');
        }

        $image = null;
        $ext = null;
        if(isset($_FILES['fileUpload'])){
            if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
                $this->site_model->delete_tbl('images',array('img_tbl'=>'users','img_ref_id'=>$id));
                $info = pathinfo($_FILES['fileUpload']['name']);
                if(isset($info['extension']))
                    $ext = $info['extension'];
                $newname = $id.".png";            
                $res_id = $id;
                if (!file_exists("uploads/".$res_id."/")) {
                    mkdir("uploads/users/", 0777, true);
                }
                $target = 'uploads/users/'.$newname;
                if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
                    $msg = "Image Upload failed";
                }
                else{
                    $new_image = $target;
                    $result = $this->site_model->get_image(null,$this->input->post('id'),'users');
                    $items = array(
                        "img_path" => $new_image,
                        "img_file_name" => $newname,
                        "img_ref_id" => $id,
                        "img_tbl" => 'users',
                    );
                    if(count($result) > 0){
                        $this->site_model->update_tbl('images','id',$items,$result[0]->img_id);
                    }
                    else{
                        $imgid = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
                    }
                }
                ####
            }
        }
        site_alert($msg,'success');
        echo json_encode(array("id"=>$id,"desc"=>$this->input->post('fname').' '.$this->input->post('lname'),"act"=>$act,'msg'=>$msg));
    }
    public function profile(){
        $this->load->helper('core/user_helper');
        $data = $this->syter->spawn('profile');
        $user = sess('user');
        // echo var_dump($user);
        $args = array();
        $join = array();
        $select = "users.*,user_roles.role";
        $args['users.id'] = $user['id'];

        $join['user_roles'] = array('content'=>'users.role=user_roles.id','mode'=>'left');
        $result = $this->site_model->get_tbl('users',$args,array(),$join,true,$select);
        $res=$result[0];
        $img = array();
        $resultIMG = $this->site_model->get_image(null,$user['id'],'users');
        if(count($resultIMG) > 0){
            $img = $resultIMG[0];
        }

        $data['code'] = userProfilePage($res,$img);
        $data['page_title'] = fa('fa-user')." User Profile";
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'profileJs';
        $this->load->view('page',$data);
    }
    public function edit_profile($id=null){
        $this->load->helper('core/user_helper');
        $select = "*";
        $args['users.id'] = $id;
        $result = $this->site_model->get_tbl('users',$args,array(),array(),true,$select);
        $user = $result[0];
        $data['code'] = editProfilePage($id,$user);
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'editProfileJs';
        $this->load->view('load',$data);
    }
    public function change_password($id=null){
        $this->load->helper('core/user_helper');
        $data['code'] = changePassword($id);
        $data['load_js'] = 'site/user';
        $data['use_js'] = 'changePasswordJs';
        $this->load->view('load',$data);
    }
    public function change_password_db(){
        $this->load->model('site/site_model');
        $user_id = $this->input->post('user_password_id');
        $select = "password";
        $args['users.id'] = $user_id;
        $result = $this->site_model->get_tbl('users',$args,array(),array(),true,$select);
        $pwd = $result[0];
        $error = 0;
        $user_pwd = $pwd->password;
        if(md5($this->input->post('old')) != $user_pwd){
            $error = 1;
            $msg = "Wrong Old Password.";
        }
        else if(md5($this->input->post('new')) != md5($this->input->post('retype'))){
            $error = 1;
            $msg = "New password and retype password doesn\'t match";
        }
        if($error == 0){
            $items = array('password'=>md5($this->input->post('new')));
            $this->site_model->update_tbl('users','id',$items,$user_id);
            $msg = "Your password has been changed.";
        }
        echo json_encode(array('error'=>$error,'msg'=>$msg));
    }
    public function upload_picture(){
        $id = $this->input->post('img_user_id');
        $msg = "";
        if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
            $this->site_model->delete_tbl('images',array('img_tbl'=>'users','img_ref_id'=>$id));
            $info = pathinfo($_FILES['fileUpload']['name']);
            if(isset($info['extension']))
                $ext = $info['extension'];
            $newname = $id.".png";            
            $res_id = $id;
            if (!file_exists("uploads/users/")) {
                mkdir("uploads/users/", 0777, true);
            }
            $target = 'uploads/users/'.$newname;
            if(!move_uploaded_file( $_FILES['fileUpload']['tmp_name'], $target)){
                $msg = "Image Upload failed";
            }
            else{
                $new_image = $target;
                $result = $this->site_model->get_image(null,$this->input->post('img_user_id'),'users');
                $items = array(
                    "img_path" => $new_image,
                    "img_file_name" => $newname,
                    "img_ref_id" => $id,
                    "img_tbl" => 'users',
                );
                if(count($result) > 0){
                    $this->site_model->update_tbl('images','img_id',$items,$result[0]->img_id);
                }
                else{
                    $id = $this->site_model->add_tbl('images',$items,array('datetime'=>'NOW()'));
                }

            }
            ####
        }
        site_alert('User Image updated','success');
        echo json_encode(array('msg'=>$msg));
    }
}