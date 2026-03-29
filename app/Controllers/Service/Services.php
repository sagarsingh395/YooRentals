<?php

namespace App\Controllers\Service;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AuthModel;

class Services extends BaseController
{
    public $data;
    public $authmodel;
    public $commonmodel;
    public function __construct()
    {
        $this->authmodel = model('App\Models\AuthModel', false);
        $this->commonmodel = model('App\Models\CommonModel', false);
    }
    public function index()
    {
        $data = [];
        $data['servicelist'] = $this->commonmodel->getAllRecord('tbl_service', null, ['service_id', 'ASC']);
        return view('Admin/services/serviceindex', $data);
    }
    public function service()
    {
        $this->data['servicelist'] = $this->commonmodel->getAllRecord('tbl_service');
        return view("Admin/services/serviceindex", $this->data);
    }

    public function add_service()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            $validation->setRule('service_name', 'Service Name', 'required', ['required' => 'Service name is required']);
            $validation->setRule('status', 'Status', 'required', ['required' => 'Status is required']);
            if ($validation->withRequest($this->request)->run()) {
                $post = $this->request->getPost();
                $data = array();
                $data['service_name'] = $this->request->getPost('service_name');
                $data['status'] = $this->request->getPost('status');
                $data['create_at'] = date('Y-m-d');
                $data['updated_at'] = date('Y-m-d');
                $groupId = $this->commonmodel->insertRecord('tbl_service', $data);
                if (isset($post['menu_id']) && isset($post['crudid'])) {
                    foreach ($post['menu_id'] as $key => $menuid) {
                        $prvlgarr = array();
                        $prvlgarr['group_id'] = $groupId;
                        $prvlgarr['menu_id'] = $menuid;
                        $prvlgarr['crud_ids'] = implode(',', $post['crudid'][$key]);
                        $prvlgarr['added_at'] = date('Y-m-d');
                        $this->commonmodel->insertRecord('tbl_group_privilege', $prvlgarr);
                    }
                    // echo '<pre>';print_r($post);exit;	
                }
                if ($groupId) {
                    session()->setFlashdata(['message' => 'New Service Added Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong. Please Try After Sometimes...', 'type' => 'danger']);
                }
                return redirect()->to(base_url('admin/service'));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }
        $this->data['menulist'] = $this->commonmodel->getAllRecord('tbl_group_menu_list', ['status' => 1]);
        return view('Admin/services/add_service', $this->data);
    }

    public function edit_service($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            $validation->setRule('service_name', 'Service Name', 'required', ['required' => 'Service name is required']);
            $validation->setRule('status', 'Status', 'required', ['required' => 'Status is required']);
            if ($validation->withRequest($this->request)->run()) {
                $post = $this->request->getPost();
                $id = $this->request->getPost('id');
                $data = array();
                $data['service_name'] = $this->request->getPost('service_name');
                $data['status'] = $this->request->getPost('status');
                $data['updated_at'] = date('Y-m-d');
                $updated = $this->commonmodel->updateRecord('tbl_service', $data, ['service_id' => $id]);
                $loginId = session('user_id');
                //echo $loginId; exit;
                if ($loginId == 1 || $loginId == 20) {
                    $deleteAllPrivilege = $this->commonmodel->deleteRecord('tbl_group_privilege', ['group_id' => $id, 'menu_id !=' => 2]);
                } else {
                    $deleteAllPrivilege = $this->commonmodel->deleteRecord('tbl_group_privilege', ['group_id' => $id]);
                }
                if (isset($post['menu_id']) && isset($post['crudid'])) {
                    foreach ($post['menu_id'] as $key => $menuid) {
                        $prvlgarr = array();
                        $prvlgarr['group_id'] = $id;
                        $prvlgarr['menu_id'] = $menuid;
                        $prvlgarr['crud_ids'] = implode(',', $post['crudid'][$key]);
                        $prvlgarr['added_at'] = date('Y-m-d');
                        $inserted = $this->commonmodel->insertRecord('tbl_group_privilege', $prvlgarr);
                    }
                    //echo '<pre>';print_r($post);exit;	
                }
                if ($updated) {
                    session()->setFlashdata(['message' => 'Service Updated Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }
                return redirect()->to(base_url('admin/service'));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }
        $this->data['prev_details'] = $this->commonmodel->getOneRecord('tbl_service', array('service_id' => $id));
        // $this->data['menulist'] = $this->commonmodel->getAllRecord('tbl_group_menu_list', ['status' => 1]);
        return view('Admin/services/edit_service', $this->data);
    }

    public function delete_service($id = false)
    {
        $deleteAllPrivilege = $this->commonmodel->deleteRecord('tbl_service', ['service_id' => $id]);
        $deleted = $this->commonmodel->deleteRecord('tbl_service', array('service_id' => $id));
        if ($deleted && $deleteAllPrivilege) {
            session()->setFlashdata(['message' => 'Service delete successfully', 'type' => 'success']);
        } else {
            session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
        }
        return redirect()->to(base_url('admin/service'));
    }

    /*******************************************Settings************************************** */
    public function setting()
    {
        if ($this->request->getMethod() === 'POST' && $_POST['submit'] == 'gen_setting') {
            //print_r($_POST); exit;
            $data = array();
            $data = $_POST;
            unset($data['submit']);
            /*if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ''){
                if($img = $this->request->getFile('logo')){ 
                    $imgname = $img->getName();
                    if($img->isValid() && !$img->hasMoved()){
                        $ext = explode('.',$imgname);
                        $ext = end($ext);
                        $newName = 'logo'.time().'.'.$ext;
                        $img->move('./public/assets/upload/images/',$newName);
                    }
                }
                $data['logo'] = $newName;
            }*/
            $updated = $this->commonmodel->update_setting($data, 1);
            if ($updated) {
                // $this->session->setFlashdata(['message'=>'Setting Update Successfully','type'=>'success']);
                return redirect()->to(base_url('admin/setting'));
            } else {
                // $this->session->setFlashdata(['message'=>'Something went wrong.','type'=>'danger']);
                return redirect()->to(base_url('admin/setting'));
            }
        } else if (isset($_POST['submit']) && $_POST['submit'] == 'msg_setting') {
            print_r($_POST);
            exit;
        } else {
            $this->data['settings'] = $this->commonmodel->get_setting(1);
            return view("admin/setting/setting_edit", $this->data);
        }
    }
}
