<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AuthModel;

class UserGroup extends BaseController
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
        $data['usersgrouplist'] = $this->commonmodel->getAllRecord('tbl_group', null, ['group_id', 'ASC']);
        return view('Admin/usergroup/usergroupindex', $data);
    }
    public function user_group()
    {
        $this->data['usersgrouplist'] = $this->commonmodel->getAllRecord('tbl_group');
        return view("Admin/usergroup/usergroupindex", $this->data);
    }

    public function add_group()
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            $validation->setRule('group_name', 'Group Name', 'required', ['required' => 'Group name is required']);
            $validation->setRule('status', 'Status', 'required', ['required' => 'Status is required']);
            if ($validation->withRequest($this->request)->run()) {
                $post = $this->request->getPost();
                $data = array();
                $data['group_name'] = $this->request->getPost('group_name');
                $data['status'] = $this->request->getPost('status');
                $data['create_at'] = date('Y-m-d');
                $data['updated_at'] = date('Y-m-d');
                $groupId = $this->commonmodel->insertRecord('tbl_group', $data);
                if (isset($post['menu_id']) && isset($post['crudid'])) {
                    foreach ($post['menu_id'] as $key => $menuid) {
                        $prvlgarr = array();
                        $prvlgarr['group_id'] = $groupId;
                        $prvlgarr['menu_id'] = $menuid;
                        $prvlgarr['crud_ids'] = implode(',', $post['crudid'][$key]);
                        $prvlgarr['added_at'] = date('Y-m-d');
                        $this->commonmodel->insertRecord('tbl_group_privilege', $prvlgarr);
                    }
                    //echo '<pre>';print_r($post);exit;	
                }
                if ($groupId) {
                    session()->setFlashdata(['message' => 'User Group Added Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong. Please Try After Sometimes...', 'type' => 'danger']);
                }
                return redirect()->to(base_url('admin/user-group'));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }
        $this->data['menulist'] = $this->commonmodel->getAllRecord('tbl_group_menu_list', ['status' => 1]);
        return view('Admin/usergroup/add_group', $this->data);
    }

    public function edit_group($id)
    {
        if ($this->request->getMethod() === 'POST') {
            $validation = \Config\Services::validation();

            $validation->setRule('group_name', 'Group Name', 'required', ['required' => 'Group name is required']);
            $validation->setRule('status', 'Status', 'required', ['required' => 'Status is required']);
            if ($validation->withRequest($this->request)->run()) {
                $post = $this->request->getPost();
                $id = $this->request->getPost('id');
                $data = array();
                $data['group_name'] = $this->request->getPost('group_name');
                $data['status'] = $this->request->getPost('status');
                $data['updated_at'] = date('Y-m-d');
                $updated = $this->commonmodel->updateRecord('tbl_group', $data, ['group_id' => $id]);
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
                    session()->setFlashdata(['message' => 'User Group Updated Successfully', 'type' => 'success']);
                } else if (isset($inserted) || $deleteAllPrivilege) {
                    session()->setFlashdata(['message' => 'Privilege Updated Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }
                return redirect()->to(base_url('admin/user-group'));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }
        $this->data['prev_details'] = $this->commonmodel->getOneRecord('tbl_group', array('group_id' => $id));
        $this->data['menulist'] = $this->commonmodel->getAllRecord('tbl_group_menu_list', ['status' => 1]);
        return view('Admin/usergroup/edit_group', $this->data);
    }

    public function delete_group($id = false)
    {
        if ($id == 1) {
            session()->setFlashdata(['message' => 'Admin Group can not delete!', 'type' => 'danger']);
            return redirect()->to('admin/user-group');
        }
        $deleteAllPrivilege = $this->commonmodel->deleteRecord('tbl_group_privilege', ['group_id' => $id]);
        $deleted = $this->commonmodel->deleteRecord('tbl_group', array('group_id' => $id));
        if ($deleted && $deleteAllPrivilege) {
            session()->setFlashdata(['message' => 'Group deleted successfully', 'type' => 'success']);
        } else {
            session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
        }
        return redirect()->to(base_url('admin/user-group'));
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