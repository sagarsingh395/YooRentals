<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use App\Libraries\Hash;
use CodeIgniter\HTTP\RedirectResponse;

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
        $data['usersgrouplist'] = $this->commonmodel->getAllRecord('tbl_group', ['status !=' => 2], ['group_id', 'ASC']);
        return view('Admin/usergroup/usergroupindex', $data);
    }
    public function user_groups()
    {
        $this->data['usersgrouplist'] = $this->commonmodel->getAllRecord('tbl_group');
        return view("admin/usergroup/usergroupindex", $this->data);
    }
    public function add_group()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $validation->setRule('group_name', 'Group Name', 'required', ['required' => 'Group name is required']);
            $validation->setRule('status', 'Status', 'required', ['required' => 'Status is required']);
            if ($validation->withRequest($this->request)->run()) {
                $post = $this->request->getPost();
                $data = array();
                $data['group_name'] = $this->request->getPost('group_name');
                $data['status'] = $this->request->getPost('status');
                $data['created_at'] = date('Y-m-d');
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
                    echo '<pre>';
                    print_r($post);
                    exit;
                }
                if ($groupId) {
                    session()->setFlashdata(['message' => 'User Group Added Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong. Please Try After Sometimes...', 'type' => 'danger']);
                }
                return redirect()->to(base_url('admin/user-group'));
                // return redirect()->to('admin/user-group');
            } else {
                $this->data['validation'] = $validation->getErrors();
                // $this->data['validation'] = $validation;
            }
        }
        $this->data['menulist'] = $this->commonmodel->getAllRecord('tbl_group_menu_list', ['status' => 1]);
        // return view('admin/users/add_group', $this->data);
        return view('Admin/usergroup/add_group', $this->data);
    }
    public function view_user($id)
    {
        echo $id;
    }
    public function edit_user($id)
    {
        if ($this->request->getMethod() == 'POST') {
            // echo "<pre>"; print_r($_FILES); exit;
            $validation = $this->validate([
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Your Full name is required'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'You must enter a valid email',
                        //   'is_unique'=>'Email already taken'
                    ]
                ],
                'phone' => [
                    'rules' => 'required|numeric|min_length[10]|max_length[10]',
                    'errors' => [
                        'required' => 'Phone is required',
                        'numeric' => 'You must enter numeric value',
                        'min_length' => 'Phone Number must be 10 digit in length',
                        'max_length' => 'Phone Number must not have more than 10 digit in length'
                    ]
                ],



            ]);
            if (!$validation) {
                $data['validation'] = $this->validator;
                //return view('admin/users/add_user',$this->data);
            } else {
                // print_r($_POST); exit;
                if ($_FILES['image']['name'] != '') {
                    if ($img = $this->request->getFile('image')) {
                        $imgname = $img->getName();
                        if ($img->isValid() && !$img->hasMoved()) {
                            $ext = explode('.', $imgname);
                            $ext = end($ext);
                            $newName = 'u_' . time() . '.' . $ext;
                            $img->move('./public/assets/upload/users/', $newName);
                        }
                    }
                    $post['image'] = $newName;
                }
                $post['name'] = $this->request->getPost('name');
                $post['email'] = $this->request->getPost('email');
                $post['phone'] = $this->request->getPost('phone');
                $post['status'] = $this->request->getPost('status');
                $post['ip_address'] = $this->request->getIPAddress();
                $post['update_by'] = session('user_id');
                $post['updated'] = date('Y-m-d H:i:s');

                $updated = $this->commonmodel->updateRecord('tbl_admin', $post, ['user_id' => $id]);
                if ($updated) {
                    session()->setFlashdata(['message' => 'User Updated Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong. Please Try After Sometimes...', 'type' => 'danger']);
                }
                return redirect()->to('admin/users');
            }
        }
        $data['group'] = $this->commonmodel->getOneRecord('tbl_group', ['group_id' => $id]);
        return view('Admin/usergroup/edit_group', $data);
    }
    public function delete_user($id)
    {
        if ($id) {
            $updated = $this->commonmodel->updateRecord('tbl_admin', ['status' => 2], ['user_id' => $id]);
            if ($updated) {
                session()->setFlashdata(['message' => 'User deleted Successfully', 'type' => 'success']);
            } else {
                session()->setFlashdata(['message' => 'Something went wrong. Please Try After Sometimes...', 'type' => 'danger']);
            }
        }
        return redirect()->to(base_url('admin/users'));
    }
}