<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Admin\AuthModel;
class AuthCheckFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $msg = '';        
        if(!session()->has('userlogin')){
            if(url_is('admin/*')){
                $msg = '<div class="alert alert-danger">You must be logged in!</div>';
            }
            //return redirect()->to('/404')->with('message', $msg);
            return redirect()->to('/admin?access=out')->with('message', $msg);
        }else{
            $menuId = $this->check_privilege();
            if(! $menuId){
                return redirect()->to('/authentication-failed');
            }
        }

    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
    public function check_privilege(){
        //$request = \Config\Services::request(); 
        helper('custom');
        /**************Users****************** */
        if(url_is('/admin/users')){
            return is_privilege(1);
        }else if(url_is('/admin/add_user')){
            return is_privilege(1,2);
        }else if(url_is('/admin/edit_user/*')){
            return is_privilege(1,3);
        }else if(url_is('/admin/user_profile/*')){
            return is_privilege(1,4);
        }else if(url_is('/admin/user_delete/*')){
            return is_privilege(1,5);
        /**************Users group****************** */
        }else if(url_is('/admin/user_groups')){
            return is_privilege(2);
        }else if(url_is('/admin/addgroup')){
            return is_privilege(2,2);
        }else if(url_is('/admin/editgroup/*')){
            return is_privilege(2,3);
        }else if(url_is('/admin/deletegroup/*')){
            return is_privilege(2,4);
        /********************setting****************** */
        }else if(url_is('/admin/setting')){
            return is_privilege(6);
        /*********************CMS*********************** */
        }else if(url_is('/admin/cms')){
            return is_privilege(7);
        }else if(url_is('/admin/add_edit_cms')){
            return is_privilege(7,2);
        }else if(url_is('/admin/add_edit_cms/*')){
            return is_privilege(7,3);
        }else if(url_is('/admin/delete_cms/*')){
            return is_privilege(7,4);
        /*********************Blogs*********************** */
        }else if(url_is('/admin/blogs')){
            return is_privilege(8);
        }else if(url_is('/admin/add_edit_blog')){
            return is_privilege(8,2);
        }else if(url_is('/admin/add_edit_blog/*')){
            return is_privilege(8,3);
        }else if(url_is('/admin/delete_blog/*')){
            return is_privilege(8,4);
        /*********************Faq*********************** */
        }else if(url_is('/admin/faq')){
            return is_privilege(9);
        }else if(url_is('/admin/add_edit_faq')){
            return is_privilege(9,2);
        }else if(url_is('/admin/add_edit_faq/*')){
            return is_privilege(9,3);
        }else if(url_is('/admin/delete_faq/*')){
            return is_privilege(9,4);
        /*********************testimonial*********************** */
        }else if(url_is('/admin/testimonial')){
            return is_privilege(10);
        }else if(url_is('/admin/add_edit_testimonial')){
            return is_privilege(10,2);
        }else if(url_is('/admin/add_edit_testimonial/*')){
            return is_privilege(10,3);
        }else if(url_is('/admin/delete_testimonial/*')){
            return is_privilege(10,4);
        /*********************Manage Banner*********************** */
        }else if(url_is('/admin/banner')){
            return is_privilege(11);
        }else if(url_is('/admin/add_edit_banner')){
            return is_privilege(11,2);
        }else if(url_is('/admin/add_edit_banner/*')){
            return is_privilege(11,3);
        }else if(url_is('/admin/delete_banner/*')){
            return is_privilege(11,4);
        /*********************Course Management*********************** */
        }else if(url_is('/admin/courses')){
            return is_privilege(12);
        }else if(url_is('/admin/add_edit_course')){
            return is_privilege(12,2);
        }else if(url_is('/admin/add_edit_course/*')){
            return is_privilege(12,3);
        }else if(url_is('/admin/delete_course/*')){
            return is_privilege(12,4);
        /*********************Institution Management*********************** */
        }else if(url_is('/admin/experts')){
            return is_privilege(13);
        }else if(url_is('/admin/experts_cu')){
            return is_privilege(13,2);
        }else if(url_is('/admin/experts_cu/*')){
            return is_privilege(13,3);
        }else if(url_is('/admin/delete_expert/*')){
            return is_privilege(13,4);
        }else if(url_is('/admin/contact-us')){
            return is_privilege(14);
        }else if(url_is('/admin/change-status')){
            return is_privilege(14,2);
        }else if(url_is('/admin/set_whatsapp_number/*')){
            return is_privilege(14,3);
        }else if(url_is('/admin/export_to_excel/*')){
            return is_privilege(14,4);
        }else if(url_is('/admin/delete-contact/*')){
            return is_privilege(14,5);
        }else if(url_is('/admin/subscriber')){
            return is_privilege(15);

        }else if(url_is('/admin/enquiry_list')){
            return is_privilege(16);
        }else if(url_is('/admin/enquiry_cu')){
            return is_privilege(16,2);
        }else if(url_is('/admin/enquiry_cu/*')){
            return is_privilege(16,3);
        }else if(url_is('/admin/enquiry_view/*')){
            return is_privilege(16,4);
        }else if(url_is('/admin/delete_enquiry/*')){
            return is_privilege(16,5);
        }else if(url_is('/admin/enquiry_export_to_excel/*')){
            return is_privilege(16,6);
        }else if(url_is('/admin/set_enq_whatsapp_number/*')){
            return is_privilege(16,7);
        }else if(url_is('/admin/set_non_whatsapp_number/*')){
            return is_privilege(16,8);

        }else if(url_is('/admin/whatsapp_replied')){
            return is_privilege(17);
        }else if(url_is('/admin/readWhatsAppMessage/*')){
            return is_privilege(17,2);
        /*****************referral************************ */
        }else if(url_is('/admin/referral')){
            return is_privilege(18);
        }else if(url_is('/admin/referral_view/*')){
            return is_privilege(18,2);
        }else if(url_is('/admin/delete_referral/*')){
            return is_privilege(18,3);
        }else if(url_is('/admin/update_bank_details_status')){
            return is_privilege(18,4);
        }else if(url_is('/admin/amount_paid_to_referral')){
            return is_privilege(18,5);
        /*****************franchise************************ */
        }else if(url_is('/admin/franchise')){
            return is_privilege(23);
        }else if(url_is('/admin/wallet_history')){ //also check this same module
            return is_privilege(23);
        }else if(url_is('/admin/franchise_CU/*')){
            return is_privilege(23,3);
        }else if(url_is('/admin/franchise_view/*')){
            return is_privilege(23,4);
        }else if(url_is('/admin/delete_franchise/*')){
            return is_privilege(23,5);
        }else if(url_is('/admin/reset_password')){
            return is_privilege(23,6);
        }else if(url_is('/admin/grade_update')){
            return is_privilege(24);
        }else if(url_is('/admin/course_modules')){
            return is_privilege(25);
        }else if(url_is('/admin/course_cu')){
            return is_privilege(25,2);
        }else if(url_is('/admin/course_cu/*')){
            return is_privilege(25,3);
        }else if(url_is('/admin/modules/*')){
            return is_privilege(25,5);
        }else if(url_is('/admin/modules/*/*')){
            return is_privilege(25,5);
        /**************examination******** */
        }else if(url_is('/admin/question_bank')){
            return is_privilege(26);
        }else if(url_is('/admin/add_edit_question')){
            return is_privilege(26,2);
        }else if(url_is('/admin/add_edit_question/*')){
            return is_privilege(26,3);
        }else if(url_is('/admin/del_question/*')){
            return is_privilege(26,5);
        }else if(url_is('/admin/exam_schedule')){
            return is_privilege(26);
        }else if(url_is('/admin/scheduleCU')){
            return is_privilege(26,2);
        }else if(url_is('/admin/scheduleCU/*')){
            return is_privilege(26,3);
        }else if(url_is('/admin/view_schedule/*')){
            return is_privilege(26,4);
        }else if(url_is('/admin/del_schedule/*')){
            return is_privilege(26,5);
        /**************Ins Management******** */
        }else if(url_is('/institute/batch')){
            return is_privilege(28);
        }else if(url_is('/institute/batch_cu')){
            return is_privilege(28,2);
        }else if(url_is('/institute/batch_cu/*')){
            return is_privilege(28,3);
        }else if(url_is('/institute/delete-batch/*')){
            return is_privilege(28,5);
        }else if(url_is('/institute/students') || url_is('/institute/student_listing')){
            return is_privilege(29);
        }else if(url_is('/institute/student_cu')){
            return is_privilege(29,2);
        }else if(url_is('/institute/student_cu/*')){
            return is_privilege(29,3);
        }else if(url_is('/admin/update_fr_register_page')){
            return is_privilege(34);
        }else if(url_is('/institute/students_attendence')){
            return is_privilege(35);
        }else if(url_is('/institute/students_attendence_list')){
            return is_privilege(35);
        }else if(url_is('/institute/students_attendence_reset')){
            return is_privilege(35);
        }else if(url_is('/institute/make_attendence/*')){
            return is_privilege(35,2);
        }else if(url_is('/institute/view_stu_attendence')){
            return is_privilege(36);
        }else if(url_is('/institute/view_stu_attendence_')){
            return is_privilege(36);
        }else if(url_is('/institute/view_stu_atn_reset')){
            return is_privilege(36);
        }
        
        return true; //for common url
    }
}