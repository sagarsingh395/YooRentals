<?php

namespace App\Models;

use CodeIgniter\Model;

class Adminmodel extends Model
{
    private $adminTbl;
    private $roleTbl;
    private $menuTbl;
    private $privilegeTbl;
    public $settingTbl;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->adminTbl = 'tbl_admin';
        $this->roleTbl = 'tbl_group';
        $this->menuTbl = 'tbl_group_menu_list';
        $this->privilegeTbl = 'tbl_group_privilege';
        $this->settingTbl = 'tbl_setting';
        // $this->privilegePathTbl = 'tbl_privilege_path';
    }
    public function getAllUsers($id = null)
    {
        $builder = $this->db->table($this->adminTbl . ' u');
        $builder->select('u.*,rp.group_name');
        $builder->join($this->rolePrivilegeTbl . ' rp', 'u.group_id=rp.group_id', 'left');
        if ($id != null) {
            $builder->where('u.user_id', $id);
        }
        $query = $builder->get();
        if ($id != null) {
            $result = $query->getRow();
        } else {
            $result = $query->getResult();
        }
        return $result;
    }
    public function get_contact_us_list($status = null, $order = null)
    {
        $status = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : $status;
        $order = ($order != null) ? $order : 'DESC';
        $builder = $this->db->table($this->contactusTbl . ' c');
        $builder->select('c.*,cs.course_full_name');
        $builder->join($this->coursesTbl . ' cs', 'c.course_id=cs.course_id', 'left');

        if ($status != null) {
            $builder->where('c.status', $status);
        } else {
            $builder->where('c.status <=', 1);
        }
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $s = $_GET['search'];
            $builder->groupStart();
            $builder->like('c.reg_no', $s);
            $builder->orLike('c.roll_no', $s);
            $builder->orLike('c.phone', $s);
            $builder->orLike('c.name', $s);
            $builder->groupEnd();
        }
        if ($status == 6) {
            $builder->orderBy('c.result_percentage', 'DESC');
        } else {
            $builder->orderBy('c.id', $order);
        }
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_count_contact_us_list($status = null)
    {
        $builder = $this->db->table($this->contactusTbl);
        if ($status != null) {
            $builder->where('status', $status);
        } else {
            $builder->where('status <=', 1);
        }
        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function get_totcount_contact_us_list()
    {
        $builder = $this->db->table($this->contactusTbl);

        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getAllEnquiry($id = null, $status = null, $page = null)
    {
        $commonmodel = model('App\Models\Common_model', false);
        $limit = $commonmodel->get_setting(1)->enqlist_limit;

        $status = (isset($_GET['status'])) ? $_GET['status'] : $status;
        $search = (isset($_GET['search'])) ? $_GET['search'] : '';
        $course_for = (isset($_GET['course_for'])) ? $_GET['course_for'] : '';
        $page = (isset($_GET['page'])) ? $_GET['page'] : $page;
        $lsfromDate = (isset($_GET['lsfromDate']) && $_GET['lsfromDate'] != '') ? date('Y-m-d', strtotime($_GET['lsfromDate'])) : '';
        $lstoDate = (isset($_GET['lstoDate']) && $_GET['lstoDate'] != '') ? date('Y-m-d', strtotime($_GET['lstoDate'])) : '';
        $cafromDate = (isset($_GET['cafromDate']) && $_GET['cafromDate'] != '') ? date('Y-m-d 00:00:00', strtotime($_GET['cafromDate'])) : '';
        $catoDate = (isset($_GET['catoDate']) && $_GET['catoDate'] != '') ? date('Y-m-d 23:59:59', strtotime($_GET['catoDate'])) : '';
        $attribute = (isset($_GET['attribute'])) ? $_GET['attribute'] : '';
        $amsign = (isset($_GET['amsign'])) ? $_GET['amsign'] : '';
        $attrvalArr = (isset($_GET['attrvalArr'])) ? $_GET['attrvalArr'] : '';
        $condition = (isset($_GET['condition'])) ? $_GET['condition'] : '';
        // print_r($attribute); exit;

        $builder = $this->db->table($this->insenquiry . ' e');
        $builder->select('e.*,c.course_full_name,wl.read_date');
        $builder->join($this->coursesTbl . ' c', 'e.course_for=c.course_id', 'left');
        $builder->join($this->whatsappreplylogTbl . ' wl', 'e.phone1=wl.phone1', 'left');
        if ($status != null && $status != 'a' && !is_array($status)) {
            if ($status == 6) {
                $builder->where('e.followup_date <=', date('Y-m-d'));
            }
            $builder->where('FIND_IN_SET("' . $status . '", e.status)');
        }
        if ($attribute != '' && !empty($attribute)) {
            $builder->groupStart();
            foreach ($attribute as $key => $attrvalue) {
                if ($key < 1) {
                    $builder->groupStart();
                } else {
                    if ($condition[$key - 1] == 'and') {
                        $builder->groupStart();
                    } else {
                        $builder->orGroupStart();
                    }
                }
                if ($attrvalue == 1) {
                    if ($amsign[$key] == 'ne') {
                        $builder->where('NOT FIND_IN_SET("' . $attrvalArr[$key] . '", e.status)');
                    } else {
                        $builder->where('FIND_IN_SET("' . $attrvalArr[$key] . '", e.status)');
                    }
                } elseif ($attrvalue == 2) {
                    if ($amsign[$key] == 'ne') {
                        $builder->notLike('e.c_name', $attrvalArr[$key]);
                        $builder->orNotLike('e.phone1', $attrvalArr[$key]);
                    } else {
                        $builder->like('e.c_name', $attrvalArr[$key]);
                        $builder->orLike('e.phone1', $attrvalArr[$key]);
                    }
                } else {
                    if ($amsign[$key] == 'ne') {
                        $builder->where('e.course_for !=', $attrvalArr[$key]);
                    } else {
                        $builder->where('e.course_for', $attrvalArr[$key]);
                    }
                }
                $builder->groupEnd();
            }
            $builder->groupEnd();
        }
        if ($lsfromDate != '' || $lstoDate != '') {
            $builder->groupStart();
            if ($lsfromDate != '') {
                $builder->where('wl.read_date >=', $lsfromDate);
            }
            if ($lstoDate != '') {
                $builder->where('wl.read_date <=', $lstoDate);
            }
            // $builder->where('FIND_IN_SET("'.$status.'", e.status)');
            $builder->groupEnd();
        }
        if ($cafromDate != '' || $catoDate != '') {
            $builder->groupStart();
            $builder->where('wl.status', 5);
            if ($cafromDate != '') {
                $builder->where('wl.added_at >=', $cafromDate);
            }
            if ($catoDate != '') {
                $builder->where('wl.added_at <=', $catoDate);
            }
            // $builder->where('FIND_IN_SET("'.$status.'", e.status)');
            $builder->groupEnd();
        }
        if ($course_for != null && $course_for != '') {
            $builder->groupStart();
            $builder->where('e.course_for', $course_for);
            $builder->groupEnd();
        }
        if ($search != null && $search != '') {
            $builder->groupStart();
            $builder->like('e.c_name', $search);
            $builder->orLike('e.phone1', $search);
            $builder->groupEnd();
        }
        if ($id) {
            $builder->where('e.enq_id', $id);
        }
        if ($page != '') {
            $offset = ($page * $limit) - $limit;
            $builder->limit($limit, $offset);
        }
        $builder->orderBy('e.enq_id', 'desc');
        $builder->groupBy('e.enq_id');
        $query = $builder->get();
        // echo $this->db->getLastQuery(); exit;

        if ($id) {
            $result = $query->getRow();
        } else {
            $result = $query->getResult();
        }
        return $result;
    }
    /* public function getAllEnquiryByFilter(){
        $commonmodel = model('App\Models\Common_model', false);
        $limit = $commonmodel->get_setting(1)->enqlist_limit;

        // $status = (isset($_GET['status']))?$_GET['status']:$status;
        // $search = (isset($_GET['search']))?$_GET['search']:'';
        // $course_for = (isset($_GET['course_for']))?$_GET['course_for']:'';
        // $page = (isset($_GET['page']))?$_GET['page']:$page;
        $lsfromDate = (isset($_POST['lsfromDate']) && $_POST['lsfromDate'] != '')?date('Y-m-d',strtotime($_POST['lsfromDate'])):'';
        $lstoDate = (isset($_POST['lstoDate']) && $_POST['lstoDate'] != '')?date('Y-m-d',strtotime($_POST['lstoDate'])):'';
        
        $builder = $this->db->table($this->insenquiry.' e');
        $builder->select('e.*,c.course_full_name,wl.read_date');
        $builder->join($this->coursesTbl.' c','e.course_for=c.course_id','left');
        $builder->join($this->whatsappreplylogTbl.' wl','e.phone1=wl.phone1','left');
        if($lsfromDate != '' || $lstoDate != ''){
            $builder->groupStart();
            if($lsfromDate != ''){
                $builder->where('wl.read_date >=', $lsfromDate);
            }
            if($lstoDate != ''){
                $builder->where('wl.read_date <=', $lstoDate);
            }
            // $builder->where('FIND_IN_SET("'.$status.'", e.status)');
            $builder->groupEnd();
        }
        /*if($course_for != null && $course_for != ''){
            $builder->groupStart();
                $builder->where('e.course_for', $course_for);
            $builder->groupEnd();
        }
        if($search != null && $search != ''){
            $builder->groupStart();
            $builder->like('e.c_name', $search);
            $builder->orLike('e.phone1', $search);
            $builder->groupEnd();
        }
        if($id){
            $builder->where('e.enq_id', $id);
        }
        if($page != ''){
            $offset = ($page * $limit) - $limit;
            $builder->limit($limit, $offset);
        }*
        $builder->orderBy('e.enq_id','desc');
        $builder->groupBy('e.enq_id');
        $query = $builder->get();
        //echo $this->db->getLastQuery(); exit;
        
        // if($id){
        //     $result = $query->getRow();
        // }else{
        //     $result = $query->getResult();
        // }
        $result = $query->getResult();
        //echo '<pre>'; print_r($result); exit;
        return $result;
    }*/
    public function getCountEnquiry($status = null)
    {
        $builder = $this->db->table($this->insenquiry . ' e');
        $builder->select('e.*');
        if ($status != null && $status != 'a') {
            if ($status == 6) {
                $builder->where('e.followup_date <=', date('Y-m-d'));
            }
            $builder->where('FIND_IN_SET("' . $status . '", e.status)');
        }
        $query = $builder->get();

        $result = $query->getNumRows();
        return $result;
    }
    public function getLastWhatsAppStatus($phone)
    {
        $builder = $this->db->table($this->whatsappreplylogTbl);
        $builder->where('phone1', $phone);
        $builder->orderBy('log_id', 'DESC');
        $query = $builder->get();
        $result = $query->getRow();
        return $result;
    }
    public function getWhatsappRepliedMessageList($phone = null)
    {
        $readStatus = (isset($_GET['status']) && $_GET['status'] != '') ? $_GET['status'] : '';

        $builder = $this->db->table($this->whatsappreplylogTbl . ' wh');
        $builder->select('wh.*,ie.c_name,ie.enq_id');
        $builder->join($this->insenquiry . ' ie', 'wh.phone1=ie.phone1', 'left');
        $builder->groupStart();
        $builder->where('wh.status', 2);
        $builder->orWhere('wh.status', 5);
        $builder->groupEnd();
        if ($readStatus == 'unread') {
            $builder->where('wh.read_status <', 1);
        } else if ($readStatus == 'read') {
            $builder->where('wh.read_status', 1);
        }
        if ($phone != null) {
            $builder->where('wh.phone1', $phone);
        } else {
            $builder->groupBy('wh.phone1');
        }
        $builder->orderBy('wh.log_id', 'DESC');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function getCountReadUnreadMessage($phone, $readStatus = null)
    {
        $builder = $this->db->table($this->whatsappreplylogTbl);
        $builder->where('phone1', $phone);
        if ($readStatus != null) {
            $builder->where('read_status', $readStatus);
        } else {
            $builder->where('read_status <', 1);
        }
        $builder->where('status', 2);
        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getCountAllUnreadMessage()
    {
        $builder = $this->db->table($this->whatsappreplylogTbl);
        $builder->where('read_status <', 1);
        $builder->where('status', 2);
        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getMemberWithBankDtls($m_id)
    {
        $builder = $this->db->table($this->membersTbl . ' m');
        $builder->select('m.*,b.acc_holder_name,b.bank_name,b.acc_no,b.ifsc_code,b.bank_address,b.comment,b.status bnkdtlsstatus');
        $builder->join($this->bankdetailsTbl . ' b', 'm.m_id=b.m_id', 'left');
        $builder->groupStart();
        $builder->where('m.m_id', $m_id);
        $builder->groupEnd();

        $query = $builder->get();
        $result = $query->getRow();
        return $result;
    }
    public function getReferralStudentListByRefId($m_id)
    {
        $builder = $this->db->table($this->studentsreferalTbl . ' sr');
        $builder->select('sr.*,c.course_full_name');
        $builder->join($this->coursesTbl . ' c', 'sr.course_id=c.course_id', 'left');
        $builder->where('sr.member_id', $m_id);

        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function getCountReferralStudentByRefId($m_id, $whereArr = null)
    {
        $builder = $this->db->table($this->studentsreferalTbl);
        $builder->select('*');
        $builder->where('member_id', $m_id);
        if ($whereArr != null) {
            $builder->where($whereArr);
        }

        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getCountFranchiseStudentByRefId($m_id, $whereArr = null)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl);
        $builder->select('*');
        $builder->where('franchise_id', $m_id);
        if ($whereArr != null) {
            $builder->where($whereArr);
        }

        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getTotalNewReferralStudent()
    { // for sidebar only
        $builder = $this->db->table($this->studentsreferalTbl);
        $builder->select('*');
        $builder->where('status', 1);
        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function get_total_blog_faq($blg_id)
    {
        $builder = $this->db->table($this->blogfaqTbl);
        $builder->select('*');
        $builder->where('blg_id', $blg_id);
        $query = $builder->get();
        $result = $query->getNumRows();
        return $result;
    }
    public function getAllFrachise()
    {
        $builder = $this->db->table($this->membersTbl);
        $builder->select('*');
        $builder->groupStart();
        $builder->where('member_type', 1);
        // $builder->where('dh_id',session('dh_id'));
        $builder->groupEnd();
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $builder->groupStart();
            $builder->like('m_full_name', $_GET['search']);
            $builder->orLike('phone', $_GET['search']);
            $builder->orLike('center_name', $_GET['search']);
            $builder->groupEnd();
        }
        if (isset($_GET['status']) && $_GET['status'] != '') {
            $builder->groupStart();
            $builder->where('status', $_GET['status']);
            $builder->groupEnd();
        }
        $builder->orderBy('m_id', 'DESC');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    public function getFranchiseStudentListByFrId($franchise_id, $whereArr = null, $search = null, $limit = null, $offset = null)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl . ' sf');
        $builder->select('sf.*,cf.c_f_name,cf.course_duration,cf.course_cat');
        $builder->join($this->courseFranchiseTbl . ' cf', 'sf.frcourse_id=cf.cid', 'left');
        $builder->groupStart();
        $builder->where('sf.franchise_id', $franchise_id);
        if ($whereArr != null) {
            $builder->where($whereArr);
        }
        $builder->groupEnd();
        if ($search != null) {
            $builder->groupStart();
            $builder->where('sf.reg_no', $search);
            $builder->orGroupStart();
            $builder->where('sf.cert_no', $search);
            $builder->orGroupStart();
            $builder->like('sf.frstu_name', $search);
            $builder->groupEnd();
            $builder->groupEnd();
            $builder->groupEnd();
        }
        $builder->orderBy('sf.frst_id', 'DESC');
        $builder->limit($limit, $offset);
        $query = $builder->get();
        // echo $this->db->getLastQuery(); exit;
        $result = $query->getResult();
        return $result;
    }
    public function get_fr_stu_list_by_frId_by_type($franchise_id, $type, $count = null, $limit = null, $offset = null)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl . ' sf');
        $builder->select('sf.*,cf.c_f_name,cf.course_duration,cf.course_cat');
        $builder->join($this->courseFranchiseTbl . ' cf', 'sf.frcourse_id=cf.cid', 'left');
        $builder->groupStart();
        $builder->where('sf.franchise_id', $franchise_id);
        // if($whereArr != null){
        //     $builder->where($whereArr);
        // }
        $builder->groupEnd();
        if ($type == 'R') {
            $builder->groupStart();
            $builder->where('sf.is_cert', 'no');
            $builder->where('sf.status !=', 3);
            $builder->groupEnd();
        } else if ($type == 'NR') {
            $builder->groupStart();
            $builder->where('sf.is_cert', 'yes');
            $builder->where('sf.status !=', 3);
            $builder->groupEnd();
        }
        $builder->orderBy('sf.frst_id', 'DESC');
        $builder->limit($limit, $offset);
        $query = $builder->get();
        // echo $this->db->getLastQuery(); exit;
        if ($count != null) {
            $result = $query->getNumRows();
        } else {
            $result = $query->getResult();
        }
        return $result;
    }
    public function getStudentRecordOfFranchise($frst_id = null)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl . ' st');
        $builder->select('st.*, co.c_f_name,co.course_duration,co.course_cat,co.course_fee, s.name statename, c.city cityname,m.member_code,m.m_full_name fr_name,m.email fr_email,m.phone fr_phone, m.address fr_address,m.center_name,m.center_address,');
        $builder->join($this->courseFranchiseTbl . ' co', 'st.frcourse_id = co.cid', 'left');
        $builder->join($this->statesTbl . ' s', 'st.state = s.id', 'left');
        $builder->join($this->citiesTbl . ' c', 'st.district = c.id', 'left');
        $builder->join($this->membersTbl . ' m', 'st.franchise_id = m.m_id', 'left');
        if ($frst_id != null) {
            $builder->where('st.frst_id', $frst_id);
        }
        $query = $builder->get();
        if ($frst_id != null) {
            $result = $query->getRow();
        } else {
            $result = $query->getResult();
        }
        return $result;
    }
    public function getLastGrade()
    {
        $builder = $this->db->table('tbl_grade');
        $builder->select('*');
        $builder->where('marks_to', 100);
        $query = $builder->get();
        $result = $query->getRow();
        return $result->grade ?? 'N/A';
    }
    public function get_fee_dues_student($m_id)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl);
        $builder->select('*');
        $builder->groupStart();
        $builder->where('franchise_id', $m_id);
        $builder->where('reg_fee_status', 'D');
        $builder->groupEnd();
        $builder->groupStart();
        $builder->where('status', 1); //1-inprogress
        $builder->orWhere('status', 3); //3-generated
        $builder->orWhere('status', 6); //6-approved
        $builder->groupEnd();
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_total_dues($m_id)
    {
        $builder = $this->db->table($this->studentsFranchiseTbl);
        $builder->selectSum('reg_fee');
        $builder->groupStart();
        $builder->where('franchise_id', $m_id);
        $builder->where('reg_fee_status', 'D');
        $builder->groupEnd();
        $builder->groupStart();
        $builder->where('status', 1); //1-inprogress
        $builder->orWhere('status', 3); //3-generated
        $builder->orWhere('status', 6); //6-approved
        $builder->groupEnd();
        $query = $builder->get();
        $result = $query->getRow()->reg_fee;
        // echo $result; exit;
        return $result;
    }
    public function get_question_list($search = [])
    {
        $builder = $this->db->table($this->questionbankTbl);
        $builder->select('*');
        // $builder->groupStart();
        //     // $builder->where('dh_id', session('dh_id'));
        //     // $builder->where('status', 1);
        // $builder->groupEnd();
        if (!empty($search)) {
            $builder->groupStart();
            foreach ($search['c_ids'] as $id) {
                $builder->where('FIND_IN_SET("' . $id . '", course_ids)');
            }
            $builder->groupEnd();
        }

        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_courses_name($course_id = null)
    {
        $result = '';
        if ($course_id != null) {
            $courseIdsArr = explode(',', $course_id);
            if (!empty($courseIdsArr)) {
                $builder = $this->db->table($this->courseFranchiseTbl);
                $builder->select('*');
                $builder->groupStart();
                foreach ($courseIdsArr as $k => $id) {
                    if ($k < 1) {
                        $builder->where('cid', $id);
                    } else {
                        $builder->orWhere('cid', $id);
                    }
                }
                // $builder->where('status', 1);
                $builder->groupEnd();
                $query = $builder->get();
                $result = $query->getResult();
                $result = implode(', ', array_column($result, 'c_name'));
            }
        }
        return $result;
    }
    public function get_examination_list()
    {
        $builder = $this->db->table($this->examscheduleTbl);
        $builder->select('*');
        // $builder->groupStart();
        //     $builder->where('dh_id', session('dh_id'));
        //     // $builder->where('status', 1);
        // $builder->groupEnd();
        $builder->orderBy('id', 'DESC');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_franchise_students_for_examination()
    {
        $builder = $this->db->table($this->studentsFranchiseTbl);
        $builder->select('*');
        $builder->groupStart();
        $builder->where('status', 1);
        $builder->orWhere('status', 6);
        $builder->groupEnd();
        $builder->groupStart();
        $builder->where('is_examinee <', 1);
        $builder->groupEnd();
        $builder->groupBy('frst_id', 'DESC');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_selected_franchise_students_for_examination($frst_ids = null)
    {
        $result = [];
        if ($frst_ids != null) {
            $builder = $this->db->table($this->studentsFranchiseTbl);
            $builder->select('*');
            $builder->groupStart();
            foreach (explode(',', $frst_ids) as $k => $frst_id) {
                if ($k < 1) {
                    $builder->where('frst_id', $frst_id);
                } else {
                    $builder->orWhere('frst_id', $frst_id);
                }
            }
            $builder->groupEnd();
            $builder->groupBy('frst_id', 'DESC');
            $query = $builder->get();
            $result = $query->getResult();
            return $result;
        }
    }
    public function get_examinee_list($id)
    {
        $builder = $this->db->table($this->examineeTbl . ' e');
        $builder->select('st.*,e.id,e.status ex_status, co.c_f_name');
        $builder->join($this->studentsFranchiseTbl . ' st', 'e.frst_id = st.frst_id', 'left');
        $builder->join($this->courseFranchiseTbl . ' co', 'st.frcourse_id = co.cid', 'left');
        $builder->groupStart();
        $builder->where('e.exsch_id', $id);
        // $builder->where('e.dh_id', session('dh_id'));
        $builder->groupEnd();
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }
    public function get_examinee_details($id)
    {
        $builder = $this->db->table($this->examineeTbl . ' e');
        $builder->select('e.*,st.frstu_name,st.photo,co.c_f_name,es.exam_name,es.date,es.time_from,es.time_to,es.tot_ques');
        $builder->join($this->studentsFranchiseTbl . ' st', 'e.frst_id = st.frst_id', 'left');
        $builder->join($this->courseFranchiseTbl . ' co', 'st.frcourse_id = co.cid', 'left');
        $builder->join($this->examscheduleTbl . ' es', 'e.exsch_id = es.id', 'left');
        $builder->groupStart();
        $builder->where('e.id', $id);
        $builder->groupEnd();
        $query = $builder->get();
        $result = $query->getRow();
        return $result;
    }
    public function get_faqs()
    {
        $builder = $this->db->table($this->faqsTbl . ' f');
        $builder->select('f.*,p.page_name');
        $builder->join($this->pageTbl . ' p', 'f.faq_for = p.id', 'left');
        // $builder->groupStart();
        //     $builder->where('e.id', $id);
        // $builder->groupEnd();
        $builder->orderBy('f.faq_id', 'DESC');
        $query = $builder->get();
        $result = $query->getResult();
        return $result;
    }

    //for databse
    public function create_tbl_student_franchise($db_suffix)
    {
        $table = 'tbl_students_franchise_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `frst_id` int(11) NOT NULL,
            `franchise_id` int(11) NOT NULL,
            `stu_type` enum('NR','R') COLLATE utf8_unicode_ci NOT NULL COMMENT 'NR-Non-Regular, R-Regular',
            `is_cert` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
            `frcourse_id` int(11) NOT NULL,
            `aadhar_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'In Months',
            `frstu_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `photo` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
            `so_wo_do` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'son of/ wife of/ daughter of',
            `mother_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `gender` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `marital_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `dob` date NOT NULL,
            `parents_occupation` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
            `candidates_exp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `phone` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `alt_phone` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `full_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `state` int(11) NOT NULL,
            `district` int(11) NOT NULL,
            `pincode` int(11) NOT NULL,
            `cert_issue_date` date NOT NULL,
            `module_marks` text COLLATE utf8_unicode_ci NOT NULL,
            `grade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `percentage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `count_edit_request` int(11) NOT NULL,
            `status` int(11) NOT NULL COMMENT '0-new, 1-inprogress, 2-Edit, 3-generated, 4-reject, 5-on approval, 6-approved,7-denied, 10-edit request)',
            `tot_fm` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `tot_mo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `reg_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `cert_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `reg_fee` int(11) NOT NULL,
            `reg_fee_status` enum('D','P') COLLATE utf8_unicode_ci NOT NULL COMMENT 'D-Dues, P-Paid',
            `added_at` datetime NOT NULL,
            `update_at` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $query2 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`frst_id`);";
        $query3 = "ALTER TABLE " . $table . " MODIFY `frst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14; ";
        $query4 = "COMMIT;";
        //   $query1 = "DROP TABLE `tbl_students_franchise_abc`;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4)) {
            // if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function create_tbl_random_code($db_suffix)
    {
        $table = 'tbl_random_code_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `id` int(11) NOT NULL,
            `code` varchar(150) COLLATE utf8_unicode_ci NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $query2 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`id`);";
        $query3 = "ALTER TABLE " . $table . " MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;";
        $query4 = "COMMIT;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function create_tbl_module($db_suffix)
    {
        $table = 'tbl_module_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `id` int(11) NOT NULL,
            `cid` int(11) NOT NULL,
            `module_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `full_marks` int(11) NOT NULL,
            `status` int(11) NOT NULL,
            `added_at` datetime NOT NULL,
            `updated_at` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $query2 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`id`);";
        $query3 = "ALTER TABLE " . $table . " MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;";
        $query4 = "COMMIT;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function create_tbl_grade($db_suffix)
    {
        $table = 'tbl_grade_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `id` int(11) NOT NULL,
            `marks_from` int(11) NOT NULL,
            `marks_to` int(11) NOT NULL,
            `grade` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
            `details` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
            `remarks` varchar(150) COLLATE utf8_unicode_ci NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $query2 = "INSERT INTO " . $table . " (`id`, `marks_from`, `marks_to`, `grade`, `details`, `remarks`) VALUES
            (1, 0, 39, 'F', 'Below 40%', 'FAIL'),
            (2, 40, 54, 'B', 'Over 40%', 'Satisfactory'),
            (3, 55, 69, 'A', 'Over 55%', 'Good'),
            (4, 70, 84, 'A+', 'Over 70%', 'Very Good'),
            (5, 85, 100, 'S', 'Over 85%', 'Superior'),
            (6, 0, 0, '', '', ''),
            (7, 0, 0, '', '', ''),
            (8, 0, 0, '', '', ''),
            (9, 0, 0, '', '', ''),
            (10, 0, 0, '', '', '');";
        $query3 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`id`);";
        $query4 = "ALTER TABLE " . $table . " MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;";
        $query5 = "COMMIT;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4) && $this->db->query($query5)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function create_tbl_cert_log($db_suffix)
    {
        $table = 'tbl_cert_log_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `log_id` int(11) NOT NULL,
            `frst_id` int(11) NOT NULL,
            `reg_no` varchar(255) NOT NULL,
            `cert_no` varchar(255) NOT NULL,
            `cert_dtls` text NOT NULL,
            `down_time` int(11) NOT NULL,
            `added_at` datetime NOT NULL,
            `update_at` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $query2 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`log_id`);";
        $query3 = "ALTER TABLE " . $table . " MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;";
        $query4 = "COMMIT;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function create_tbl_course_franchise($db_suffix)
    {
        $table = 'tbl_course_franchise_' . $db_suffix;
        $query1 = "CREATE TABLE " . $table . " (
            `cid` int(2) NOT NULL,
            `c_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT 'course name',
            `course_duration` int(11) NOT NULL COMMENT 'in month',
            `course_cat` enum('C','T') COLLATE utf8_unicode_ci NOT NULL COMMENT 'C-Computer, T-Typing',
            `c_f_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'course full name',
            `status` int(2) NOT NULL,
            `added_at` datetime NOT NULL,
            `update_at` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

        $query2 = "INSERT INTO " . $table . " (`cid`, `c_name`, `course_duration`, `course_cat`, `c_f_name`, `status`, `added_at`, `update_at`) VALUES
        (1, 'CCA ', 3, 'C', ' Certificate in Computer Applications', 1, '2024-04-24 16:00:00', '2024-07-02 01:00:16'),
        (2, 'DCA ', 6, 'C', ' Diploma in Computer Applications', 1, '2024-04-24 16:00:01', '0000-00-00 00:00:00'),
        (3, 'CFA ', 6, 'C', ' Certificate in Financial Accounting', 1, '2024-04-24 16:00:02', '0000-00-00 00:00:00'),
        (4, 'DDTP ', 6, 'C', ' Diploma in Desktop Publishing', 1, '2024-04-24 16:00:03', '0000-00-00 00:00:00'),
        (5, 'ADHN ', 6, 'C', ' Advance Diploma in Hardware Networking', 1, '2024-04-24 16:00:04', '0000-00-00 00:00:00'),
        (6, 'ADFA ', 6, 'C', ' Advance Diploma In Financial Accounting', 1, '2024-04-24 16:00:05', '0000-00-00 00:00:00'),
        (7, 'DCP ', 6, 'C', ' Diploma In Computer Programming', 1, '2024-04-24 16:00:06', '0000-00-00 00:00:00'),
        (8, 'DOA ', 6, 'C', ' Diploma In Office Automation', 1, '2024-04-24 16:00:07', '0000-00-00 00:00:00'),
        (9, 'DHT ', 6, 'C', ' Diploma In Hardware Technology', 1, '2024-04-24 16:00:08', '0000-00-00 00:00:00'),
        (10, 'DHN ', 6, 'C', ' Diploma In Hardware Networking', 1, '2024-04-24 16:00:09', '0000-00-00 00:00:00'),
        (11, 'ADIT ', 6, 'C', ' Advance Diploma In Information Technology', 1, '2024-04-24 16:00:10', '0000-00-00 00:00:00'),
        (12, 'ADCA ', 12, 'C', ' Advance Diploma In Computer Application', 1, '2024-04-24 16:00:11', '2024-07-02 00:59:43'),
        (13, 'ADCA Pro ', 12, 'C', ' Advance Diploma In Computer Application Professional', 1, '2024-04-24 16:00:12', '2024-07-02 00:59:55'),
        (14, '(COMPUTER TYPING) ', 6, 'T', 'DIPLOMA IN COMPUTER TYPING', 1, '2024-04-24 16:00:13', '2024-07-29 09:52:29'),
        (15, 'STENO ', 6, 'T', ' STENO HINDI & ENGLISH TYPING', 1, '2024-04-24 16:00:14', '2024-07-29 09:52:39'),
        (16, 'AutoCAD ', 6, 'C', ' DIPLOMA IN AutoCAD', 1, '2024-04-24 16:00:15', '0000-00-00 00:00:00'),
        (17, 'DCTT ', 6, 'C', ' Diploma In Computer Teacher Training', 1, '2024-04-24 16:00:16', '0000-00-00 00:00:00'),
        (18, 'SEF ', 6, 'C', ' Speak English Fast', 1, '2024-04-24 16:00:17', '0000-00-00 00:00:00'),
        (19, 'DFA ', 6, 'C', ' Diploma In Financial Accounting', 1, '2024-04-24 16:00:18', '0000-00-00 00:00:00'),
        (20, 'CTTC ', 6, 'C', ' Certificate On Teacher Training Course', 1, '2024-04-24 16:00:19', '0000-00-00 00:00:00'),
        (21, 'C++', 6, 'C', ' Programming in C++', 1, '2024-04-24 16:00:20', '0000-00-00 00:00:00'),
        (22, 'Photoshop ', 6, 'C', ' Photoshop', 1, '2024-04-24 16:00:21', '0000-00-00 00:00:00'),
        (23, 'DCA-T', 6, 'C', 'Diploma In Computer Application With Tally', 1, '2024-04-24 16:00:22', '0000-00-00 00:00:00'),
        (24, 'ADCAP ', 6, 'C', ' Advance Diploma In Computer Application & Publication', 1, '2024-04-24 16:00:23', '0000-00-00 00:00:00'),
        (25, '3ds MAX ', 6, 'C', ' 3ds MAX', 1, '2024-04-24 16:00:24', '0000-00-00 00:00:00'),
        (26, 'ATE 9 ', 6, 'C', ' Advanced Tally ERP 9', 1, '2024-04-24 16:00:25', '0000-00-00 00:00:00'),
        (27, 'PGDCA ', 6, 'C', ' POST GRADUATE DIPLOAMA IN COMPUTER APPLICATION ONE YEAR', 1, '2024-04-24 16:00:26', '0000-00-00 00:00:00'),
        (28, 'PGDCA ', 6, 'C', ' POST GRADUATE DIPLOMA IN COMPUTER APPLICATION', 1, '2024-04-24 16:00:27', '0000-00-00 00:00:00'),
        (29, 'DEO ', 6, 'C', ' Data Entry Operator', 1, '2024-04-24 16:00:28', '0000-00-00 00:00:00'),
        (30, 'DDEO ', 6, 'C', ' Domestic Data Entry Operator', 1, '2024-04-24 16:00:29', '0000-00-00 00:00:00'),
        (31, 'DMM ', 6, 'C', ' Diploma in Multimedia', 1, '2024-04-24 16:00:30', '0000-00-00 00:00:00'),
        (32, 'BP ', 6, 'C', ' BASIC PHP', 1, '2024-04-24 16:00:31', '0000-00-00 00:00:00'),
        (33, 'ADVE ', 6, 'C', ' Advance Diploma In Video Editing', 1, '2024-04-24 16:00:32', '0000-00-00 00:00:00'),
        (34, 'C', 6, 'C', ' Programming In C', 1, '2024-04-24 16:00:33', '0000-00-00 00:00:00'),
        (35, 'DHT ', 6, 'C', ' DIPLOMA IN HARDWARE TECHNOLOGY', 1, '2024-04-24 16:00:34', '0000-00-00 00:00:00'),
        (36, 'DEC ', 6, 'C', ' Diploma In English Communication', 1, '2024-04-24 16:00:35', '0000-00-00 00:00:00'),
        (37, 'ADEC ', 6, 'C', ' Advance Diploma In English Communication', 1, '2024-04-24 16:00:36', '0000-00-00 00:00:00'),
        (38, 'DC ', 6, 'C', ' Diploma In Communication', 1, '2024-04-24 16:00:37', '0000-00-00 00:00:00'),
        (39, 'Oracle ', 6, 'C', ' Oracle', 1, '2024-04-24 16:00:38', '0000-00-00 00:00:00'),
        (40, 'PL/SQL ', 6, 'C', ' Database Programming with PL/SQL', 1, '2024-04-24 16:00:39', '0000-00-00 00:00:00'),
        (41, 'Core Python ', 6, 'C', ' Python', 1, '2024-04-24 16:00:40', '0000-00-00 00:00:00'),
        (42, 'DCADTP ', 6, 'C', ' Diploma In Computer Application & Desktop Publishing', 1, '2024-04-24 16:00:41', '0000-00-00 00:00:00'),
        (43, 'DDM ', 6, 'C', ' DIPLOMA IN DIGITAL MARKETING', 1, '2024-04-24 16:00:42', '0000-00-00 00:00:00'),
        (44, 'Office ', 6, 'C', ' MS Office', 1, '2024-04-24 16:00:43', '0000-00-00 00:00:00'),
        (45, 'ST', 6, 'C', ' SHORTHAND TYPING', 1, '2024-04-24 16:00:44', '0000-00-00 00:00:00'),
        (46, 'DCHN ', 6, 'C', ' Diploma In Computer Hardware And Networking', 1, '2024-04-24 16:00:45', '0000-00-00 00:00:00');";

        $query3 = "ALTER TABLE " . $table . " ADD PRIMARY KEY (`cid`);";
        $query4 = "ALTER TABLE " . $table . " MODIFY `cid` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;";
        $query5 = "COMMIT;";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4) && $this->db->query($query5)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_setting($dh_id)
    {
        $query1 = "INSERT INTO `tbl_setting` (`id`, `dh_id`, `address`, `phone`, `phone2`, `email`, `wh_template`, `enqlist_limit`, `getintuch_email`, `bookfreeconsultation_email`, `careeraplynow_email`, `news_subscribtion_email`, `blog_subscribtion_email`, `name`, `website`, `facebook_link`, `twitter_link`, `google_link`, `linkedin_link`, `youtube_link`, `instagram_link`, `pinterest_link`, `logo`, `center_name`, `back_title`) VALUES (NULL, " . $dh_id . ", '1st Floor, Rajendra Nagar, Behind Walia Complex, Near Moti Cinema, Ara Bihar, 802301', '+91-950-774-0259', '+91-6182-353339', 'cb-ini@cb.com', 'cb_introduction', 50, '', '', '', '', '', 'admin', 'https://careerbossinstitute.com/', 'https://www.facebook.com/careerbossinstitute', 'https://twitter.com/careerbossinsti', '', 'https://www.linkedin.com/company/97924014/admin/feed/posts/', 'https://www.youtube.com/@careerbossinstitute', 'https://www.instagram.com/careerbossinstitute/', '', 'logo1724321266.png', 'Career-Boss Institute', 'Career-Boss Institute');";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_home_section($dh_id)
    {
        $query1 = "INSERT INTO `tbl_home_section` (`id`, `dh_id`, `is_show_sec1`, `sec1_title`, `col1_title`, `col1_desc`, `col2_title`, `col2_desc`, `col3_title`, `col3_desc`, `is_show_sec2`, `sec2_banner`, `is_show_sec3`, `sec3_content`, `update_at`) VALUES (NULL, " . $dh_id . ", 1, 'A whole new way of learning like never before!', 'Interactive Online Platform', 'Explore an innovative online platform that redefines the learning experience. Our intuitive interface grants you access to captivating lessons, interactive quizzes, and educational videos anytime and from any location. Get Prepared to start an exciting learning journey from the comfort of your own home.', 'Expert-Led Masterclasses', 'Gain firsthand wisdom from industry experts and esteemed scholars driven by their passion to impart knowledge. Engage in interactive masterclasses that offer unique insights and practical wisdom beyond the confines of textbooks. Connect with professionals in your field actively inquire and garner invaluable perspectives from those leading the way in their respective domains.', 'Personalized Learning Approach', 'Express farewell to one-size-fits-all instruction. Our institute values your unique learning style and preferences. With personalized learning plans, you will receive tailored guidance and support. ensuring you grasp concepts with ease and achieve your academic goals.', 1, 's2ban_1723026485.png', 0, 'hi', '2024-08-08 01:51:42');";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_about_us($dh_id)
    {
        $query1 = "INSERT INTO `tbl_about_us` (`id`, `dh_id`, `is_show_sec1`, `vision_title`, `col1_t1`, `col1_t2`, `col2_t1`, `col2_t2`, `col3_t1`, `col3_t2`, `is_show_sec2`, `sec2_content`, `update_at`) VALUES (NULL, " . $dh_id . ", 1, 'The vision of Career Boss Institute is to equip individuals with state-of-the-art skills through a wide array of courses, encompassing digital marketing, web development, UX/UI design and beyond. This empowers them to thrive in the ever-changing landscape of today\'s professional world.', '1000+', 'Empowering career growth.', '500+', 'Connect with industry experts.', '250+', 'Career impact across industries.', 1, 'content', '2024-08-08 05:30:59');";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_frregister_page($dh_id)
    {
        $query1 = "INSERT INTO `tbl_frregister_page` (`id`, `dh_id`, `title_1`, `title_2`, `banner_content`, `banner_image`, `is_show_sec2`, `sec2_image`, `why_choose_us`, `comp_training`, `ongo_support`, `is_show_sec3`, `center_image`, `title1`, `text1`, `title2`, `text2`, `title3`, `text3`, `title4`, `text4`, `title5`, `text5`, `title6`, `text6`, `franchise`, `yearsrd`, `seminars`, `audience`, `is_show_sec4`, `f1dtl`, `f1photo`, `f1name`, `f1ocp`, `f2dtl`, `f2photo`, `f2name`, `f2ocp`, `f3dtl`, `f3photo`, `f3name`, `f3ocp`, `update_at`) VALUES (NULL, " . $dh_id . ", 'Join Our Esteemed Institute and <br>Become a Leader in the IT Industry', 'Unlock the Potential of a Profitable Institute Franchise', 'Welcome to Career Institute, where we empower entrepreneurs to build successful cleaning businesses. With a proven business model, comprehensive training, and ongoing support, our franchise offers a lucrative opportunity to thrive in the booming cleaning industry.', 'ban_1723219013.png', 1, 's2img_1723219347.png', '<strong>Proven Business Model : </strong>Our franchise is built on a successful business model that has been refined over years of experience in the cleaning industry.', 'We provide extensive training to ensure you have all the skills and knowledge needed to run a successful cleaning business.', 'From marketing to operations, our team is here to support you every step of the way.', 1, 'cimg_1723219763.png', 'Established Brand', 'Leverage the reputation and trust of an established brand.', 'Training support', 'Provides complete 15 days in depth training about the services it offers and on its Brain Science concept.', '24 X 7 CRM support', 'A Dedicated Franchise Relationship Manager is allocated to each franchise for instant support.', 'Business Management Model', 'A unique, flexible model is created for each franchise to open multiple sources of income.', 'Regular Development Session', 'Every franchise gets RDS, PDS, Start-up Plan and a dedicated mentor to expand the franchise business.', 'Innovative Technologies', 'Utilize cutting-edge technologies to enhance efficiency and service quality.', '3000+', '14', '2000', '10', 1, '“At this School, our mission is to balance a rigorous comprehensive college preparatory curriculum with healthy social and emotional development.”', 'f1img_1723220387.png', 'Balbir kumar', 'Franchise', '“At this School, our mission is to balance a rigorous comprehensive college preparatory curriculum with healthy social and emotional development.”', 'f2img_1723220626.png', 'Rajat Kumar', 'Franchise', '“At this School, our mission is to balance a rigorous comprehensive college preparatory curriculum with healthy social and emotional development.”', 'f3img_1723220638.png', 'Manjeet Kumar', 'Franchise', '2024-08-10 00:00:11');";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_experts($dh_id)
    {
        $query1 = "INSERT INTO `tbl_experts` (`exp_id`, `dh_id`, `name`, `image`, `short_desc`, `added_at`, `update_at`, `status`) VALUES (NULL, " . $dh_id . ", 'Ranjeet Kumar', 'img_1690023993.png', 'HTML Development', '2023-07-18 05:04:01', '2023-08-12 13:34:25', 1), (NULL, " . $dh_id . ", 'Vikash Kumar', 'img_1690199780.png', 'Mobile App Development', '2023-07-24 06:56:10', '2023-08-12 13:33:53', 1), (NULL, " . $dh_id . ", 'Mantu Kumar', 'img_1691147563.png', 'Image & Video Editing Expert', '2023-07-24 07:00:15', '2023-08-12 13:33:26', 1), (NULL, " . $dh_id . ", 'Amit Kumar Chauhan', 'img_1698663176.png', 'Digital Marketing Development.', '2023-07-24 07:20:54', '2023-10-30 05:52:56', 1);";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function insert_into_tbl_banner($dh_id)
    {
        $query1 = "INSERT INTO `tbl_banner` (`id`, `dh_id`, `main_title`, `sub_title`, `page`, `url`, `button_title`, `brochure`, `img_alt`, `img_title`, `status`, `created_at`, `update_at`) VALUES (NULL, " . $dh_id . ", 'about us', 'Career Boss an IT Professional Institute: Empowering Tomorrow\'s IT Experts with Web Panel Solutions.', 4, '', '', 'ban_1689923178.jpg', 'Career Boss an IT Professional Institute: Empowering Tomorrow\'s IT Experts with Web Panel Solutions.', 'Career Boss an IT Professional Institute: Empowering Tomorrow\'s IT Experts with Web Panel Solutions.', 1, '2023-07-20 20:36:18', '2024-02-13 01:30:34'), (NULL, " . $dh_id . ", 'Master the Digital World and Transform Your Career with our IT Courses', 'At Career Boss Institute, we understand the importance of quality education in shaping the future of BCA students.<br><br><strong>• Small batch size<br>• Personal attention<br>• Qualified teachers</strong>', 1, '', '', 'ban_1715075816.jpg', 'Admission open for BCA students', 'Admission open for BCA students', 1, '2023-11-20 01:39:38', '2024-07-05 04:01:26');";
        if ($this->db->query($query1)) {
            return 1;
        } else {
            return 0;
        }
    }
    public function delete_domain_tables($db_suffix)
    {
        $table1 = 'tbl_cert_log_' . $db_suffix;
        $table2 = 'tbl_grade_' . $db_suffix;
        $table3 = 'tbl_module_' . $db_suffix;
        $table4 = 'tbl_random_code_' . $db_suffix;
        $table5 = 'tbl_students_franchise_' . $db_suffix;
        $table6 = 'tbl_course_franchise_' . $db_suffix;

        $query1 = "DROP TABLE " . $table1 . ";";
        $query2 = "DROP TABLE " . $table2 . ";";
        $query3 = "DROP TABLE " . $table3 . ";";
        $query4 = "DROP TABLE " . $table4 . ";";
        $query5 = "DROP TABLE " . $table5 . ";";
        $query6 = "DROP TABLE " . $table6 . ";";
        if ($this->db->query($query1) && $this->db->query($query2) && $this->db->query($query3) && $this->db->query($query4) && $this->db->query($query5) && $this->db->query($query6)) {
            return 1;
        } else {
            return 0;
        }
    }
}