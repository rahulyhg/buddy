<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Admin_model extends CI_Model{
	function getClients(){
        $res = $this->db->select('*')->where('user_type','CLIENT')/*->where('status','1')*/->get('traffic_users')->result_array();
        return $res;
    }
	function getClientDetails($userid){
		$rows = array();
		$rows= $this->db->select('id,first_name, last_name, email, phone, IF(LOCATE("http", profile_image) > 0, profile_image, IF(profile_image = "", "", IF(user_type = "CLIENT", CONCAT("uploadImage/client_profile_image/",profile_image), CONCAT("uploadImage/lawyer_profile_image/",profile_image)))) as profile_image, IF(license_image = "", "", CONCAT("uploadImage/client_license_image/",license_image)) as license_image, is_phone_verified, is_email_verified,is_active,admin_message, status,country, state, city, status')->where("id",$userid)->get('traffic_users')->row_array();
		return $rows;
	}
	function getCaseList($user_id, $status='ALL'){
		$rows = array();
		$query = $this->db->select('id, user_id, case_number, case_details, IF(case_front_img = "", "", CONCAT("uploadImage/case_image/",case_front_img)) as case_front_img, IF(case_rear_img = "", "", CONCAT("uploadImage/case_image/",case_rear_img)) as case_rear_img, IF(driving_license = "", "", CONCAT("uploadImage/client_license_image/",driving_license)) as driving_license, status, state, city, created_at, 0 as bid_count')->where("user_id",$user_id);
		if($status != 'ALL'){
			$query->where("status",$status);
		}
		$rows = $query->get('traffic_cases')->result_array();
		return $rows;
	}
	function getLawyers(){
        $res = $this->db->select('*')->where('user_type','LAWYER')/*->where('status','1')*/->get('traffic_users')->result_array();
		foreach($res as $ky=>$rslt){
			$res[$ky]['degree'] = $this->db->select('*')->where('user_id',$rslt['id'])->get('traffic_degree')->result_array();
		}
        return $res;
    }
	function getCaseListOfLawyer($user_id, $status='ALL'){
		$rows = array();
		$query = $this->db->select('TC.id, TC.user_id, TC.case_number, TC.case_details, IF(TC.case_front_img = "", "", CONCAT("uploadImage/case_image/",TC.case_front_img)) as case_front_img, IF(TC.case_rear_img = "", "", CONCAT("uploadImage/case_image/",TC.case_rear_img)) as case_rear_img, IF(TC.driving_license = "", "", CONCAT("uploadImage/client_license_image/",TC.driving_license)) as driving_license, TC.status, TC.state, TC.city, TC.created_at, 0 as bid_count')
			->where("TCN.lawyer_id",$user_id);
		if($status != 'ALL'){
			$query->where("TC.status",$status);
		}
		$query->join('traffic_case_notifications TCN', 'TCN.case_id = TC.id');
		$rows = $query->get('traffic_cases TC')->result_array();
		return $rows;
	}
	function addNewBanner($data){
        $res = $this->db->insert('traffic_banners', $data);
        return $res;
    }
	function updateLawyerMsg($data, $user_id){
        $res = $this->db->where('id', $user_id)->update('traffic_users', $data);
        return $res;
    }
	function updateBanner($data, $id){
        $res = $this->db->where('id', $id)->update('traffic_banners', $data);
        return $res;
    }
	function getBanners(){
        $res = $this->db->select('*')->get('traffic_banners')->result_array();
        return $res;
    }
}