<?php

namespace App\Controllers\Service;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AuthModel;

class ServiceCategory extends BaseController
{
    public $data;
    public $authmodel;
    public $commonmodel;
    public function __construct()
    {
        $this->authmodel = model('App\Models\AuthModel', false);
        $this->commonmodel = model('App\Models\CommonModel', false);
    }
    public function add_category($service_id)
    {
        if ($this->request->getMethod() === 'POST') {

            $validation = \Config\Services::validation();

            $validation->setRule('category_name', 'Category Name', 'required');
            $validation->setRule('rent', 'Rent', 'required');
            $validation->setRule('type', 'Type', 'required');
            $validation->setRule('property_status', 'Property Status', 'required');
            $validation->setRule('status', 'Status', 'required');

            if ($validation->withRequest($this->request)->run()) {

                $data = [];
                $data['service_id'] = $service_id;
                $data['category_name'] = $this->request->getPost('category_name');
                $data['rent'] = $this->request->getPost('rent');
                $data['type'] = $this->request->getPost('type');
                $data['property_status'] = $this->request->getPost('property_status');
                $data['status'] = $this->request->getPost('status');
                $data['added_at'] = date('Y-m-d');
                $data['added_by'] = session('user_id');

                // $data['added_by'] = ['user_id' => session()->get('user_id'), 'date' => date('Y-m-d H:i:s')];


                if ($_FILES['image']['name'] != '') {
                    if ($img = $this->request->getFile('image')) {
                        $imgname = $img->getName();
                        if ($img->isValid() && !$img->hasMoved()) {
                            $ext = explode('.', $imgname);
                            $ext = end($ext);
                            $newName = 'AD_' . time() . '.' . $ext;
                            $img->move('./assets/upload/categories/', $newName);
                        }
                    }
                    $data['image'] = $newName;
                }
                $insert = $this->commonmodel->insertRecord('tbl_category', $data);

                if ($insert) {
                    session()->setFlashdata(['message' => 'Category Added Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }

                return redirect()->to(base_url('admin/view-service/' . $service_id));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }

        $this->data['service_id'] = $service_id;

        return view('Admin/services/add_category', $this->data);
    }

    public function edit_category($id)
    {
        if ($this->request->getMethod() === 'POST') {

            $validation = \Config\Services::validation();

            $validation->setRule('category_name', 'Category Name', 'required');
            $validation->setRule('rent', 'Rent', 'required');
            $validation->setRule('type', 'Type', 'required');
            $validation->setRule('status', 'Status', 'required');

            if ($validation->withRequest($this->request)->run()) {

                $service_id = $this->request->getPost('service_id');

                $data = [];
                $data['category_name'] = $this->request->getPost('category_name');
                $data['rent'] = $this->request->getPost('rent');
                $data['type'] = $this->request->getPost('type');
                $data['property_status'] = $this->request->getPost('property_status');
                $data['status'] = $this->request->getPost('status');
                $data['update_at'] = date('Y-m-d');
                $data['update_by'] = session('user_id');
                // $data['update_by'] = ['user_id' => session()->get('user_id'), 'date' => date('Y-m-d H:i:s')];

                // Old data
                // $oldCategory = $this->commonmodel->getOneRecord('tbl_category', ['id' => $id]);

                if ($_FILES['image']['name'] != '') {
                    if ($img = $this->request->getFile('image')) {
                        $imgname = $img->getName();
                        if ($img->isValid() && !$img->hasMoved()) {
                            $ext = explode('.', $imgname);
                            $ext = end($ext);
                            $newName = 'ED_' . time() . '.' . $ext;
                            $img->move('./assets/upload/categories/', $newName);
                        }
                    }
                    $data['image'] = $newName;
                } else {
                    // $data['image'] = $oldCategory->image;
                }
                // echo "<pre>";
                // print_r($data);
                // exit;

                // Update
                $update = $this->commonmodel->updateRecord('tbl_category', $data, ['category_id' => $id]);
                if ($update) {
                    session()->setFlashdata(['message' => 'Category Updated Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }

                return redirect()->to(base_url('admin/view-service/' . $service_id));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }

        // GET request
        $this->data['category'] = $this->commonmodel->getOneRecord('tbl_category', ['category_id' => $id]);
        return view('Admin/services/edit_category', $this->data);
    }
     public function delete_category($id = false)
    {
        $deleted = $this->commonmodel->deleteRecord('tbl_category', array('category_id' => $id));
        if ($deleted) {
            session()->setFlashdata(['message' => 'Category deleted successfully', 'type' => 'success']);
        } else {
            session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
        }
        return redirect()->to(base_url('admin/service'));
    }
}
