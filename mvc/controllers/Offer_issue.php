<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offer_issue extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model("airline_cabin_class_m");
		$this->load->model("offer_issue_m");
	        $this->load->model("offer_eligibility_m");
		$this->load->model("eligibility_exclusion_m");
		$this->load->model("season_m");
		$this->load->model("marketzone_m");
		$this->load->model("fclr_m");
		$language = $this->session->userdata('lang');
		$this->load->library('encrypt');
		$this->lang->load('offer_eligibility', $language);
	}	
	
	
	public function index() {
/*

$config = Array(
'protocol' => 'smtp',
'smtp_host' => 'ssl://smtp.googlemail.com',
'smtp_port' => 465,
'smtp_user' => 'testsweken321@gmail.com',
'smtp_pass' => 'testsweken',
'mailtype'  => 'html', 
'charset' => 'utf-8',
'wordwrap' => TRUE
 );

       $this->load->library('email', $config);*/


 // send email
                                                      

		$sQuery = " select group_concat(distinct pfe.dtpfext_id) as pf_list , group_concat(first_name,' ', last_name SEPARATOR ';') as pax_names , booking_status, pnr_ref , flight_number, carrier_code, from_city,to_city,dep_date, dep_time, arrival_time, fci.aln_data_value as from_city_name , tci.aln_data_value as to_city_name, group_concat(distinct pfe.fclr_id)  as fclr_list ,group_concat(pax_contact_email) as email_list , cab.aln_data_value as cabin from VX_aln_dtpf_ext pfe LEFT JOIN vx_aln_data_defns dd on (dd.vx_aln_data_defnsID = pfe.booking_status AND dd.aln_data_typeID = 20) LEFT JOIN  VX_aln_daily_tkt_pax_feed tpf on (tpf.dtpf_id = pfe.dtpf_id )  LEFT JOIN vx_aln_data_defns fci on (fci.vx_aln_data_defnsID = tpf.from_city AND fci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  tci on (tci.vx_aln_data_defnsID = tpf.to_city AND tci.aln_data_typeID = 1)  LEFT JOIN vx_aln_data_defns  cab on (cab.vx_aln_data_defnsID = tpf.cabin AND cab.aln_data_typeID = 13) where  dd.alias = 'new'  group by tpf.pnr_ref, flight_number, carrier_code, from_city, to_city ,dep_date,booking_status, from_city_name, to_city_name, dep_time, arrival_time, cabin";
		$rResult = $this->install_m->run_query($sQuery);

	 	foreach($rResult as $offer) {
			$p_list = explode(',',$offer->pf_list);
			$namelist = explode(';',$offer->pax_names);
		     //update dtpf tracker
			$coupon_code = $this->generateRandomString(6);
			$array = array();
			$arrray['coupon_code'] = $coupon_code;
			$array['booking_status'] = $this->rafeed_m->getDefIdByTypeAndAlias('sent_offer_mail','20');
			$array["modify_date"] = time();
                        $array["modify_userID"] = $this->session->userdata('loginuserID');

			
			// update extension table with new status

			$this->offer_eligibility_m->update_dtpfext($array,$p_list);
	

			// update tracker about change in status
			$tracker = array();
				$tracker['booking_status_from'] = $offer->booking_status;
				$tracker['booking_status_to'] = $array['booking_status'];
				$tracker['comment'] = 'Sent Offer Email';
			        $tracker["create_date"] = time();
                                $tracker["modify_date"] = time();
                                $tracker["create_userID"] = $this->session->userdata('loginuserID');
                                $tracker["modify_userID"] = $this->session->userdata('loginuserID');
			//	var_dump($p_list);exit;

				foreach($p_list as $id) {
					$tracker['dtpfext_id'] = $id;
                                	$this->offer_issue_m->insert_dtpf_tracker($tracker);
				}
				

				 // send email
				 $message = '
	<html>
	<body>
	<div style="max-width: 800px; margin: 0; padding: 30px 0;">
	<table width="80%" border="0" cellpadding="0" cellspacing="0">
	<tr>
<td width="5%"></td>
	<td align="left" width="95%" style="font: 13px/18px Arial, Helvetica, sans-serif;">
<h2 style="font: normal 20px/23px Arial, Helvetica, sans-serif; margin: 0; padding: 0 0 18px; color: orange;">Hello '.$namelist[0].'!</h2>
Thankyou for booking with us. We are pleased to inform you that you are eligible to bid for higer cabin upgrade and
experience our luxury products and services.<br />
<br />
<big style="font: 16px/18px Arial, Helvetica, sans-serif;"><b style="color: orange;">Details:</b></big><br />
<br />
Booking Reference :<b style="color: blue;">'.$this->encrypt->decode($coupon_code).'</b><br />
<br />
<br />
<br />
</td>
</tr>
</table>
<table align="left" >
		<thead>
			<tr>
			<th>Flight Number</th>
			<th>Departure Date</th>
			<th>Origin</th>
			<th>Destination</th>
			<th>Departure Time</th>
			<th>Arrival Time</th>
			<th>Booked Cabin</th>
			</tr>
			</thead>
			<tbody>
                               <tr>
                                                <td>'.$offer->flight_number.'</td>
                                                <td>'.date("d-m-Y",$offer->dep_date).'</td>
                                                <td>'.$offer->from_city_name.'</td>
                                                <td>'.$offer->to_city_name.'</td>
                                                <td>'.gmdate('H:i:s', $offer->dep_time).'</td>
                                                <td>'.gmdate('H:i:s', $offer->arrival_time).'</td>
                                                <td>'.$offer->cabin.'</td>
                                        </tr>
                        </tbody>
                </table>

</div>
</body>
</html>
';
			 $this->load->library('email');
				 $this->email->set_newline("\r\n");
			 $this->email->from('testsweken321@gmail.com', "Valuex Admin");
			 $this->email->to('testsweken321@gmail.com');
			 $this->email->subject("Upgrade Cabin Offer");
			$this->email->message($message);
			$this->email->send();

		}	
		
		$this->data["subview"] = "offer_eligibility/index";
		$this->load->view('_layout_main', $this->data);
	}
	


 public  function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($this->offer_eligibility_m->checkForUniqueCouponCode($randomString)){
                return $this->encrypt->encode($randomString);  // to decode  $this->encrypt->decode($encrypt_key);
        } else {
                $this->generateRandomString(6);
        }
    }


}

