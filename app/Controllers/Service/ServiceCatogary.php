<?php

namespace App\Controllers\Service;

use App\Controllers\BaseController;
use App\Libraries\Hash;
use CodeIgniter\HTTP\RedirectResponse;
use App\Models\AuthModel;

class ServiceCatogary extends BaseController
{
    public $data;
    public $authmodel;
    public $commonmodel;
    public function __construct()
    {
        $this->authmodel = model('App\Models\AuthModel', false);
        $this->commonmodel = model('App\Models\CommonModel', false);
    }
    public function add_room($service_id)
    {
        if ($this->request->getMethod() === 'POST') {

            $validation = \Config\Services::validation();

            $validation->setRule('room_name', 'Room Name', 'required');
            $validation->setRule('price', 'Price', 'required');
            $validation->setRule('type', 'Type', 'required');
            $validation->setRule('status', 'Status', 'required');

            if ($validation->withRequest($this->request)->run()) {

                $data = [];
                $data['service_id'] = $service_id;
                $data['room_name'] = $this->request->getPost('room_name');
                $data['price'] = $this->request->getPost('price');
                $data['type'] = $this->request->getPost('type');
                $data['status'] = $this->request->getPost('status');
                $data['added_at'] = date('Y-m-d');

                if ($_FILES['image']['name'] != '') {
                    if ($img = $this->request->getFile('image')) {
                        $imgname = $img->getName();
                        if ($img->isValid() && !$img->hasMoved()) {
                            $ext = explode('.', $imgname);
                            $ext = end($ext);
                            $newName = 'r_' . time() . '.' . $ext;
                            $img->move('./assets/upload/rooms/', $newName);
                        }
                    }
                    $data['image'] = $newName;
                }
                $insert = $this->commonmodel->insertRecord('tbl_room', $data);

                if ($insert) {
                    session()->setFlashdata(['message' => 'Room Added Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }

                return redirect()->to(base_url('admin/view-service/' . $service_id));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }

        $this->data['service_id'] = $service_id;

        return view('Admin/services/add_room', $this->data);
    }
    public function edit_room($id)
    {
        if ($this->request->getMethod() === 'POST') {

            $validation = \Config\Services::validation();

            $validation->setRule('room_name', 'Room Name', 'required');
            $validation->setRule('price', 'Price', 'required');
            $validation->setRule('type', 'Type', 'required');
            $validation->setRule('status', 'Status', 'required');

            if ($validation->withRequest($this->request)->run()) {

                $service_id = $this->request->getPost('service_id');

                $data = [];
                $data['room_name'] = $this->request->getPost('room_name');
                $data['price'] = $this->request->getPost('price');
                $data['type'] = $this->request->getPost('type');
                $data['status'] = $this->request->getPost('status');

                // Old data
                $oldRoom = $this->commonmodel->getOneRecord('tbl_room', ['id' => $id]);

                if ($_FILES['image']['name'] != '') {
                    if ($img = $this->request->getFile('image')) {
                        $imgname = $img->getName();
                        if ($img->isValid() && !$img->hasMoved()) {
                            $ext = explode('.', $imgname);
                            $ext = end($ext);
                            $newName = 'e_' . time() . '.' . $ext;
                            $img->move('./assets/upload/rooms/', $newName);
                        }
                    }
                    $data['image'] = $newName;
                } else {
                    $data['image'] = $oldRoom->image;
                }

                // Update
                $update = $this->commonmodel->updateRecord('tbl_room', $data, ['id' => $id]);

                if ($update) {
                    session()->setFlashdata(['message' => 'Room Updated Successfully', 'type' => 'success']);
                } else {
                    session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
                }

                return redirect()->to(base_url('admin/view-service/' . $service_id));
            } else {
                $this->data['validation'] = $validation->getErrors();
            }
        }

        // GET request
        $this->data['room'] = $this->commonmodel->getOneRecord('tbl_room', ['id' => $id]);

        return view('Admin/services/edit_room', $this->data);
    }
    public function delete_service($id = false)
    {
        $deleted = $this->commonmodel->deleteRecord('tbl_room', array('id' => $id));
        if ($deleted) {
            session()->setFlashdata(['message' => 'Room deleted successfully', 'type' => 'success']);
        } else {
            session()->setFlashdata(['message' => 'Something went wrong.', 'type' => 'danger']);
        }
        return redirect()->to(base_url('admin/service'));
    }
}
