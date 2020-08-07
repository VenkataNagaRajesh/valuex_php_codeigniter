<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rafeed extends Admin_Controller
{

	// table columns and file columns
	private $arrHeader = array(
		"Airline Code",
		"Document Type",
		"EMD nbr",
		"Coupon Number",
		"Carrier",
		"Flight Number",
		"Ticket Number",
		"Boarding Point",
		"Off Point",
		"CPN Value",
		"Class",
		"Flight Date",
		"Fare Basis",
		"Cabin",
		"Coupon routing",
		"Rate per unit",
		"Wt",
		"Currency",
		"RFIC",
		"RFISC",
		"SSR CODE",
		"Marketing Airline Code",
		"Operating Airline Code",
		"Booking Country",
		"Booking City",
		"Issuance Country",
		"Issuance City",
		"OfficeID",
		"Channel",
		"Pax Type",
	);

	private $arrHeaderTypes = [
		'arrHeader'
	];

	function __construct()
	{
		parent::__construct();
		$this->load->model("rafeed_m");
		$this->load->model("airline_cabin_m");
		$this->load->model('airports_m');
		$this->load->model("season_m");
		$this->load->model("airline_m");
		$this->load->model('airline_cabin_def_m');
		$this->load->model('airline_cabin_class_m');
		$this->load->model("user_m");
		$language = $this->session->userdata('lang');
		$this->lang->load('rafeed', $language);
		$this->data['icon'] = $this->menu_m->getMenu(array("link" => "rafeed"))->icon;
	}


	public function index()
	{

		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/dist/themes/default/style.min.css',
				'assets/datepicker/datepicker.css'
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/datepicker/datepicker.js'
			)
		);



		if (!empty($this->input->post('booking_country'))) {
			$this->data['booking_country'] = $this->input->post('booking_country');
		} else {
			$this->data['booking_country'] = 0;
		}
		if (!empty($this->input->post('booking_city'))) {
			$this->data['booking_city'] = $this->input->post('booking_city');
		} else {
			$this->data['booking_city'] = 0;
		}
		if (!empty($this->input->post('boarding_point'))) {
			$this->data['boarding_point'] = $this->input->post('boarding_point');
		} else {
			$this->data['boarding_point'] = 0;
		}
		if (!empty($this->input->post('off_point'))) {
			$this->data['off_point'] = $this->input->post('off_point');
		} else {
			$this->data['off_point'] = 0;
		}

		if (!empty($this->input->post('airline_code'))) {
			$this->data['airline_code'] = $this->input->post('airline_code');
		} else {
			if ($this->session->userdata('roleID') != 1) {
				$this->data['airline_code'] = $this->session->userdata('default_airline');
			} else {
				$this->data['airline_code'] = 0;
			}
		}
		if (!empty($this->input->post('class'))) {
			$this->data['cla'] = $this->input->post('class');
		} else {
			$this->data['cla'] = 0;
		}



		if (!empty($this->input->post('flight_range'))) {
			$this->data['flight_range'] = $this->input->post('flight_range');
		} else {
			$this->data['flight_range'] = '';
		}

		if (!empty($this->input->post('frequency'))) {
			$this->data['frequency'] = $this->input->post('frequency');
		} else {
			$this->data['frequency'] = '';
		}


		if (!empty($this->input->post('start_date'))) {
			$this->data['start_date'] = date('d-m-Y', $this->input->post('start_date'));
		} else {
			$this->data['start_date'] = '';
		}

		if (!empty($this->input->post('end_date'))) {
			$this->data['end_date'] = date('d-m-Y', $this->input->post('end_date'));
		} else {
			$this->data['end_date'] = 0;
		}

		//print_r( $this->data['stateID']); exit;
		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('3');
		//$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');

		$roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
		if ($roleID != 1) {
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);
		} else {
			$this->data['airlines'] = $this->airline_m->getAirlinesData();
		}


		$this->data["subview"] = "rafeed/index";
		$this->load->view('_layout_main', $this->data);
	}

	public function baggage()
	{

		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/dist/themes/default/style.min.css',
				'assets/datepicker/datepicker.css'
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/datepicker/datepicker.js'
			)
		);



		if (!empty($this->input->post('booking_country'))) {
			$this->data['booking_country'] = $this->input->post('booking_country');
		} else {
			$this->data['booking_country'] = 0;
		}
		if (!empty($this->input->post('booking_city'))) {
			$this->data['booking_city'] = $this->input->post('booking_city');
		} else {
			$this->data['booking_city'] = 0;
		}
		if (!empty($this->input->post('boarding_point'))) {
			$this->data['boarding_point'] = $this->input->post('boarding_point');
		} else {
			$this->data['boarding_point'] = 0;
		}
		if (!empty($this->input->post('off_point'))) {
			$this->data['off_point'] = $this->input->post('off_point');
		} else {
			$this->data['off_point'] = 0;
		}

		if (!empty($this->input->post('airline_code'))) {
			$this->data['airline_code'] = $this->input->post('airline_code');
		} else {
			if ($this->session->userdata('roleID') != 1) {
				$this->data['airline_code'] = $this->session->userdata('default_airline');
			} else {
				$this->data['airline_code'] = 0;
			}
		}
		if (!empty($this->input->post('class'))) {
			$this->data['cla'] = $this->input->post('class');
		} else {
			$this->data['cla'] = 0;
		}



		if (!empty($this->input->post('flight_range'))) {
			$this->data['flight_range'] = $this->input->post('flight_range');
		} else {
			$this->data['flight_range'] = '';
		}

		if (!empty($this->input->post('frequency'))) {
			$this->data['frequency'] = $this->input->post('frequency');
		} else {
			$this->data['frequency'] = '';
		}


		if (!empty($this->input->post('start_date'))) {
			$this->data['start_date'] = date('d-m-Y', $this->input->post('start_date'));
		} else {
			$this->data['start_date'] = '';
		}

		if (!empty($this->input->post('end_date'))) {
			$this->data['end_date'] = date('d-m-Y', $this->input->post('end_date'));
		} else {
			$this->data['end_date'] = 0;
		}

		//print_r( $this->data['stateID']); exit;
		$this->data['country'] = $this->rafeed_m->getCodesByType('2');
		$this->data['city'] = $this->rafeed_m->getCodesByType('3');
		//$this->data['airlines'] = $this->rafeed_m->getCodesByType('12');
		$this->data['airport'] = $this->rafeed_m->getCodesByType('1');
		$this->data['cabin'] = $this->rafeed_m->getCodesByType('13');

		$roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
		if ($roleID != 1) {
			$this->data['airlines'] = $this->user_m->getUserAirlines($userID);
		} else {
			$this->data['airlines'] = $this->airline_m->getAirlinesData();
		}


		$this->data["subview"] = "rafeed/baggage";
		$this->load->view('_layout_main', $this->data);
	}


	public function delete()
	{
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int) $id) {
			$this->data['rafeed'] = $this->rafeed_m->get_single_rafeed(array('rafeed_id' => $id));
			if ($this->data['rafeed']) {
				$this->rafeed_m->delete_rafeed($id);
				$this->session->set_flashdata('success', $this->lang->line('menu_success'));
				redirect(base_url("rafeed/index"));
			} else {
				redirect(base_url("rafeed/index"));
			}
		} else {
			redirect(base_url("rafeed/index"));
		}
	}
	public function view()
	{
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if ((int) $id) {
			$this->data["airline"] = $this->airline_m->getAirlineData($id);
			if ($this->data["airline"]) {
				$this->data["subview"] = "airline/view";
				$this->load->view('_layout_main', $this->data);
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function upload()
	{

		if ($_FILES) {
			if (empty($_FILES['file']['name'])) {
				$this->session->set_flashdata('error', "Please select File");
				$this->data["subview"] = "rafeed/upload";
				$this->load->view('_layout_main', $this->data);
			} else {

				require(APPPATH . 'libraries/spreadsheet/php-excel-reader/Spreadsheet_Excel_Reader.php');
				require(APPPATH . 'libraries/spreadsheet/SpreadsheetReader.php');

				$status = "success";
				$message = $this->lang->line('menu_success');

				// set execution time to unlimited
				ini_set('max_execution_time', '0');

				try {
					$file = $_FILES['file']['tmp_name'];
					if (move_uploaded_file($file, APPPATH . "/uploads/" . $_FILES['file']['name'])) {

						$file =  APPPATH . "/uploads/" . $_FILES['file']['name'];
						$this->mydebug->rafeed_log("Processing the excel file " . $_FILES['file']['name'], 0);
						$Reader = new SpreadsheetReader($file);

						$strRedirector = "index";

						$Sheets = $Reader->Sheets();
						foreach ($Sheets as $Index => $Name) {
							$Reader->ChangeSheet($Index);
							$this->mydebug->rafeed_log(" **** $Name -- Sheet processing ****", 0);

							$i = 0;
							$column = 1;
							$cDocumentType = NULL;

							foreach ($Reader as $Row) {

								$Row = array_map('trim', $Row);

								if ($i == 0) { // header checking						

									$flag = 0;

									//columns in file
									$import_header = array_map('strtolower', $Row);

									// get matched columns header
									$arrheaderTypeData = array_map(function ($arrColumnType) use ($import_header) {
										//var_dump($import_header);

										// convert all values to lower case
										$arrColumns = array_map('strtolower', $this->{$arrColumnType});

										// sort compare array
										sort($arrColumns);
										sort($import_header);



										// comaper and return matched header
										if ($arrColumns  === $import_header) {
											return $arrColumnType;
										}
									}, $this->arrHeaderTypes);


									// remove null, false and empty values
									$arrheaderTypeData = array_filter($arrheaderTypeData);

									//check matched headers
									if (count($arrheaderTypeData) != 1) {
										$status = "failed";
										$this->mydebug->rafeed_log("Received Columns = ". print_r(import_header,1), 0);

										$this->mydebug->rafeed_log("Columns mis match, expected columns = ". print_r($import_header,1), 0);
										break;
									} else {
										$this->mydebug->rafeed_log("Header matched for " . $_FILES['file']['name'], 0);
										$this->mydebug->rafeed_log("Processing records.. ", 0);
										$flag = 1;
									}

								} else {
									if ($flag == 1) {
										$cDocumentType = strtolower($Row[array_search('document type', $import_header)]);

										if (is_null($cDocumentType)) {
											$status = "failed";
											$this->mydebug->rafeed_log("Document type missed in file - ". $column, 0);
											break;
										}
										switch (strtolower($cDocumentType)) {
											case 'd': // baggage rafeed
												$strRedirector = "baggage";
												$this->baggageUpload($Row, $import_header, $column);
												break;

											case 't': // ticketing rafeed
												$this->ticketUpgradeUpload($Row, $import_header, $column);
												break;

											default:
												$status = "failed";
												$this->mydebug->rafeed_log("Document type ($cDocumentType) missed in file - " . $column, 0);
										}
									} else {
										$status = "failed";
										$this->mydebug->rafeed_log("Header mismatch", 1);
										//print_r("mismatch");
										break;
									}
								}
								$column++;
								$i++;
							}
						}
					}
				} catch (Exception $E) {
					echo $E->getMessage();
				}
				if (file_exists($file)) {
					unlink($file);
				}
				$this->session->set_flashdata($status, $message);

				if ($strRedirector == "index") {
					redirect(base_url("rafeed/index"));
				} else if ($strRedirector == "baggage") {
					redirect(base_url("rafeed/baggage"));
				}
			}
		} else {
			$this->data["subview"] = "rafeed/upload";
			$this->load->view('_layout_main', $this->data);
		}
	}

	// upload and insert for baggage
	public function baggageUpload($Row = array(), $import_header = array(), $column = 1)
	{
		// check columns count

		if (count($Row) != 30) {
			$this->mydebug->rafeed_log("Baggage: Columns Count Missmatch" . $column, 1);
			return;
		}

		$arrBaggageRaFeed = array();

		// Set Airline code
		$arrBaggageRaFeed['airline_code'] = $Row[array_search('airline code', $import_header)];
		if (!is_numeric($arrBaggageRaFeed['airline_code']) || strlen($arrBaggageRaFeed['airline_code']) != 3) {
			$this->mydebug->rafeed_log("Airline Code should be 3 digits  and integer in row " . $column, 1);
			return;
		}

		// Set EMD number
		$arrBaggageRaFeed['emd_nbr'] = $Row[array_search('emd nbr', $import_header)];
		if (!ctype_digit($arrBaggageRaFeed['emd_nbr']) || strlen($arrBaggageRaFeed['emd_nbr']) != 13) {
			$this->mydebug->rafeed_log("Emd Number should be integer and 13 digits in row" .  $column, 1);
			return;
		}

		//Coupon Number
		$arrBaggageRaFeed['coupon_number'] = $Row[array_search('coupon number', $import_header)];
		if (!ctype_digit($arrBaggageRaFeed['coupon_number']) || strlen($arrBaggageRaFeed['coupon_number'] != 1)) {
			$this->mydebug->rafeed_log("Coupon Number should be integer and 1 digits in row" .  $column, 1);
			return;
		}

		//Carrier
		$carrier = $Row[array_search('carrier', $import_header)];
		$arrBaggageRaFeed['carrier'] =
			$this->airports_m->getDefIdByTypeAndCode($carrier, '12');

		if (!ctype_alpha($carrier) || (strlen($carrier) != 2)) {
			$this->mydebug->rafeed_log("Carrier should be character and lenght 2 in row " . $column, 1);
		}

		// Flight Number
		$arrBaggageRaFeed['flight_number'] = substr($Row[array_search('flight number', $import_header)], 2);
		if (strlen($arrBaggageRaFeed['flight_number']) >= 7) {
			$this->mydebug->rafeed_log("Flight number should not be more than 6 AlphaNumeric code in row " . $column, 1);
			return;
		}

		// boarding point
		$boarding_point = $Row[array_search('boarding point', $import_header)];
		$arrBaggageRaFeed['boarding_point'] =
			$this->airports_m->getDefIdByTypeAndCode($boarding_point, '1');

		if (strlen($boarding_point) != 3 || !ctype_alpha($boarding_point)) {
			$this->mydebug->rafeed_log(" Boarding point should be 3 alpha code in row " . $column, 1);
			return;
		}

		if (!strlen($arrBaggageRaFeed['boarding_point'])) {
			$this->mydebug->rafeed_log("Boarding point record not found for " . $boarding_point, 1);
			return;
		}

		// off point
		$off_point = $Row[array_search('off point', $import_header)];

		$arrBaggageRaFeed['off_point'] =
			$this->airports_m->getDefIdByTypeAndCode($off_point, '1');
		if (strlen($off_point) != 3 || !ctype_alpha($off_point)) {
			$this->mydebug->rafeed_log("Off point should be 3 alpha code in row " . $column, 1);
			return;
		}

		if (!strlen($arrBaggageRaFeed['off_point'])) {
			$this->mydebug->rafeed_log("Off point record not found for " . $off_point, 1);
			return;
		}

		// cpn value
		$arrBaggageRaFeed['prorated_price'] = round($Row[array_search('cpn value', $import_header)], 2);
		if (!is_numeric($arrBaggageRaFeed['prorated_price'])) {
			$this->mydebug->rafeed_log("PRice should be numeric in row " . $column, 1);
			return;
		}

		// class
		$arrBaggageRaFeed['class'] = $Row[array_search('class', $import_header)];
		$class_arr = range('A', 'Z');
		if (!in_array($arrBaggageRaFeed['class'], $class_arr)) {
			$this->mydebug->rafeed_log("class should be in A-Z " . $column, 1);
			return;
		}

		//depature date
		$dt = explode("-",str_replace('/', '-', $Row[array_search('flight date', $import_header)]));
		$arrBaggageRaFeed['departure_date'] = date("Y-m-d", mktime(0, 0, 0, $dt[0], $dt[1], $dt[2]));

		if (!preg_match("/(([0-9]{4}-[0-9]{2})-([0-9]{2}))/", $arrBaggageRaFeed['departure_date'], $matches)) {
			$this->mydebug->rafeed_log("flight date formate missing - " . $arrBaggageRaFeed['departure_date'] . " - " . $column, 1);
			return;
		}
		$arrBaggageRaFeed['departure_date'] = strtotime($arrBaggageRaFeed['departure_date']);

		//$rafeed['departure_date'] = strtotime(str_replace('-', '/', $Row[array_search('flight date', $import_header)]));
		$day_of_week = date('w', $arrBaggageRaFeed['departure_date']);
		$day = ($day_of_week) ? $day_of_week : 7;
		$arrBaggageRaFeed['day_of_week'] = $this->airports_m->getDefIdByTypeAndCode($day, '14');


		$arrBaggageRaFeed['fare_basis'] = $Row[array_search('fare basis', $import_header)];

		// cabin
		$cabin = $Row[array_search('cabin', $import_header)];

		$arrBaggageRaFeed['cabin'] = $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($arrBaggageRaFeed['carrier'], $cabin);

		$cabin_arr = array_values($this->airline_cabin_def_m->getCabinsDataForCarrier($arrBaggageRaFeed['carrier']));
		if (!in_array($cabin, $cabin_arr)) {
			$this->mydebug->rafeed_log("cabin should in " . implode(',', $cabin_arr) . 'in row ' . $column, 1);
			return;
		}

		//marketing airline code
		$marketing_airline_code = $Row[array_search('marketing airline code', $import_header)];
		$arrBaggageRaFeed['marketing_airline_code'] =
			$this->airports_m->getDefIdByTypeAndCode($marketing_airline_code, '12');

		if (strlen($marketing_airline_code) != 2) {
			$this->mydebug->rafeed_log("MKT airine should be 2 alpha code in row " . $column, 1);
			return;
		}

		//operating airline code
		$operating_airline_code = $Row[array_search('operating airline code', $import_header)];
		$arrBaggageRaFeed['operating_airline_code'] =
			$this->airports_m->getDefIdByTypeAndCode($operating_airline_code, '12');

		if (strlen($operating_airline_code) != 2) {
			$this->mydebug->rafeed_log("Operating airline should be 2 alpha code in row " . $column, 1);
			return;
		}

		// officeid
		$arrBaggageRaFeed['office_id'] = $Row[array_search('officeid', $import_header)];

		//channel
		$arrBaggageRaFeed['channel'] = $Row[array_search('channel', $import_header)];

		//pax type
		$pax_type = $Row[array_search('pax type', $import_header)];
		$arrBaggageRaFeed['pax_type'] =  $this->airports_m->getDefIdByTypeAndCode($pax_type, '18');

		if (strlen($pax_type) >= 4 || !ctype_alpha($pax_type)) {
			$this->mydebug->rafeed_log("Pax type code should be 2 alpha code in row " . $column, 1);
			return;
		}

		//coupon routing
		$coupon_routing = $Row[array_search('coupon routing', $import_header)];
		$arrRouting = explode(" ", $coupon_routing);

		//checking locations
		$arrLocations = array_map(function ($strLocation) {

			$nLocationID = $this->airports_m->getDefIdByTypeAndCode($strLocation, '3');

			if (!ctype_digit($nLocationID))
				return false;

			return $nLocationID;
		}, $arrRouting);

		if ((count(array_filter($arrLocations)) != 2)) {
			$this->mydebug->rafeed_log("coupon routing not validate in row " . $column, 1);
			return;
		}

		$arrBaggageRaFeed['origin'] = $arrLocations[0];
		$arrBaggageRaFeed['destinition'] = $arrLocations[1];

		// rate per unit
		$arrBaggageRaFeed['rate_per_unit'] = $Row[array_search('rate per unit', $import_header)];

		if (!is_numeric($arrBaggageRaFeed['rate_per_unit']) || !($arrBaggageRaFeed['rate_per_unit'] > 0 && $arrBaggageRaFeed['rate_per_unit'] < 9999)) {
			$this->mydebug->rafeed_log("Rate Per Unit should be numeric or between 1 to 9999 in row " . $column, 1);
			return;
		}

		// if (!(in_array($arrBaggageRaFeed['rate_per_unit'], range(1, 9999)))) {
		// 	$this->mydebug->rafeed_log("Rate Per Unit should be numeric or between 1 to 9999 in row " . $column, 1);
		// 	return;
		// }

		//weight
		$arrBaggageRaFeed['weight'] = $Row[array_search('wt', $import_header)];
		//if()

		//currency
		$arrBaggageRaFeed['currency'] = $Row[array_search('currency', $import_header)];

		//RFIC
		$arrBaggageRaFeed['rfic'] = $Row[array_search('rfic',  $import_header)];
		if (!ctype_alpha($arrBaggageRaFeed['rfic']) || strlen($arrBaggageRaFeed['rfic']) > 1) {
			$this->mydebug->rafeed_log("RFIC unit should be a character and length only one in row" . $column, 1);
			return;
		}

		//RFISC
		$arrBaggageRaFeed['rfisc'] = $Row[array_search('rfisc',  $import_header)];
		if (strlen($arrBaggageRaFeed['rfisc']) != 3) {
			$this->mydebug->rafeed_log("RFISC unit should be a character and length only 3 in row" . $column, 1);
			return;
		}

		//SSR CODE
		$arrBaggageRaFeed['ssr_code'] = $Row[array_search('ssr code',  $import_header)];
		if (!(ctype_alnum($arrBaggageRaFeed['ssr_code'])) || strlen($arrBaggageRaFeed['ssr_code']) != 4) {
			$this->mydebug->rafeed_log("SSR CODE unit should be a alphanumeric and length only 4 in row" . $column, 1);
			return;
		}

		if ($this->rafeed_m->checkRaFeedBaggage($arrBaggageRaFeed)) {

			$arrBaggageRaFeed['create_date'] = time();
			$arrBaggageRaFeed['modify_date'] = time();
			$arrBaggageRaFeed['create_userID'] = $this->session->userdata('loginuserID');
			$arrBaggageRaFeed['modify_userID'] = $this->session->userdata('loginuserID');

			$season_list = $this->season_m->getSeasonForDateANDAirlineIDForRAFeed($arrBaggageRaFeed['departure_date'], $arrBaggageRaFeed['carrier'], $arrBaggageRaFeed['boarding_point'], $arrBaggageRaFeed['off_point']);

			//print_r($arrBaggageRaFeed);
			if (count($season_list) > 0) {
				$first_flag = 0;
				foreach ($season_list as $season_id) {
					$arrBaggageRaFeed['season_id'] = $season_id;

					if ($first_flag == 0) {
						$insert_id = $this->rafeed_m->insert_ra_baggage($arrBaggageRaFeed);
						$main_season_record_id = $insert_id;
					} else {
						$arrBaggageRaFeed['sub_season_record'] = $main_season_record_id;
						$insert_id = $this->rafeed_m->insert_ra_baggage($arrBaggageRaFeed);
					}
					$first_flag++;
				}
			} else {
				$arrBaggageRaFeed['season_id'] = 0;
				$insert_id = $this->rafeed_m->insert_ra_baggage($arrBaggageRaFeed);
			}
			if ($insert_id) {
				$this->mydebug->rafeed_log("uploaded row " . $column, 0);
			} else {

				$this->mydebug->rafeed_log("Record not inserted for row " . $column, 1);
			}
		} else {
			$this->mydebug->rafeed_log("Duplicate Entry", 1);
			return;
		}
	}

	// upload and insert for ticket upload
	public function ticketUpgradeUpload($Row = array(), $import_header = array(), $column = 1)
	{

		// check columns count
			if (count($Row) != 30) {
			$this->mydebug->rafeed_log("Ticket Upgrade: Columns Count Missmatch = " . $column, 1);
			return;
		}

		$rafeed = array();
		$num =  explode('E', $Row[array_search('ticket number', $import_header)]);
		$num1 = explode('.', $num[0]);

		$rafeed['ticket_number'] =  $num1[0];
		if (!ctype_digit($rafeed['ticket_number']) || strlen($rafeed['ticket_number']) != '13') {
			$this->mydebug->rafeed_log("Ticket Number should be integer and 13 digits in row " . $column, 1);
			return;
		}

		$rafeed['coupon_number'] = $Row[array_search('coupon number', $import_header)];
		if (!is_numeric($rafeed['coupon_number']) || strlen($rafeed['coupon_number']) >= '2') {
			$this->mydebug->rafeed_log("Coupon should be integer and single digit in row " . $column, 1);
			return;
		}

		$rafeed['prorated_price'] = round($Row[array_search('cpn value', $import_header)], 2);
		if (!is_numeric($rafeed['prorated_price'])) {
			$this->mydebug->rafeed_log("PRice should be numeric in row " . $column, 1);
			return;
		}

		$rafeed['airline_code'] = $Row[array_search('airline code', $import_header)];
		if (!is_numeric($rafeed['airline_code']) || strlen($rafeed['airline_code']) != 3) {
			$this->mydebug->rafeed_log("Airline Code should be 3 digits  and integer in row " . $column, 1);
			return;
		}
		$rafeed['fare_basis'] = $Row[array_search('fare basis', $import_header)];
		$carrier = $Row[array_search('carrier', $import_header)];
		$rafeed['carrier'] =
			$this->airports_m->getDefIdByTypeAndCode($carrier, '12');

		if (strlen($carrier) != 2) {
			$this->mydebug->rafeed_log("Carrier should  be 2 alpha code in row " . $column, 1);
			return;
		}

		$booking_country = $Row[array_search('booking country', $import_header)];
		$rafeed['booking_country'] =
			$this->airports_m->getDefIdByTypeAndCode($booking_country, '2');

		if (strlen($booking_country) != 2 || !ctype_alpha($booking_country)) {
			$this->mydebug->rafeed_log("Boking country should be 2 alpha code in row " . $column, 1);
			return;
		}

		$booking_city = $Row[array_search('booking city', $import_header)];
		$rafeed['booking_city'] =
			$this->airports_m->getDefIdByTypeAndCode($booking_city, '3');

		if (strlen($booking_city) != 3 || !ctype_alpha($booking_city)) {
			$this->mydebug->rafeed_log("Boking city should be 3 alpha code in row " . $column, 1);
			return;
		}

		$issuance_country = $Row[array_search('issuance country', $import_header)];
		$rafeed['issuance_country'] =
			$this->airports_m->getDefIdByTypeAndCode($issuance_country, '2');

		if (strlen($issuance_country) != 2 || !ctype_alpha($issuance_country)) {
			$this->mydebug->rafeed_log("Issueance country should be 2 alpha code in row " . $column, 1);
			return;
		}

		$issuance_city = $Row[array_search('issuance city', $import_header)];
		$rafeed['issuance_city'] =
			$this->airports_m->getDefIdByTypeAndCode($issuance_city, '3');

		if (strlen($issuance_city) != 3 || !ctype_alpha($issuance_city)) {
			$this->mydebug->rafeed_log("Issueance city should be 3 alpha code in row " . $column, 1);
			return;
		}

		$boarding_point = $Row[array_search('boarding point', $import_header)];

		$rafeed['boarding_point'] =
			$this->airports_m->getDefIdByTypeAndCode($boarding_point, '1');

		if (strlen($boarding_point) != 3 || !ctype_alpha($boarding_point)) {
			$this->mydebug->rafeed_log(" Boarding point should be 3 alpha code in row " . $column, 1);
			return;
		}

		if (!strlen($rafeed['boarding_point'])) {
			$this->mydebug->rafeed_log("Boarding point record not found for " . $boarding_point, 1);
			return;
		}

		$off_point = $Row[array_search('off point', $import_header)];

		$rafeed['off_point'] =
			$this->airports_m->getDefIdByTypeAndCode($off_point, '1');
		if (strlen($off_point) != 3 || !ctype_alpha($off_point)) {
			$this->mydebug->rafeed_log("Off point should be 3 alpha code in row " . $column, 1);
			return;
		}

		if (!strlen($rafeed['off_point'])) {
			$this->mydebug->rafeed_log("Off point record not found for " . $off_point, 1);
			return;
		}

		$cabin = $Row[array_search('cabin', $import_header)];
		$rafeed['cabin'] = $this->airline_cabin_def_m->getCabinIDForCarrierANDCabin($rafeed['carrier'], $cabin);

		$cabin_arr = array_values($this->airline_cabin_def_m->getCabinsDataForCarrier($rafeed['carrier']));

		if (!in_array($cabin, $cabin_arr)) {
			$this->mydebug->rafeed_log("cabin should in " . implode(',', $cabin_arr) . 'in row ' . $column, 1);
			return;
		}

		$rafeed['class'] = $Row[array_search('class', $import_header)];
		$class_arr = range('A', 'Z');
		if (!in_array($rafeed['class'], $class_arr)) {
			$this->mydebug->rafeed_log("class should be in A-Z " . $column, 1);
			return;
		}

		$cabin_class_data = $this->airline_cabin_class_m->getCabinFromClassForCarrier($rafeed['carrier'], $rafeed['class']);
		if ($cabin_class_data->cabin_id != $rafeed['cabin']) {
			$this->mydebug->rafeed_log("Class - " .  $rafeed['class'] . " ,Carrier - " . $rafeed['carrier']. " - cabin Mapping not matched for row ",1);
			return;
		}

		$dt = explode("-",str_replace('/', '-', $Row[array_search('flight date', $import_header)]));
		$rafeed['departure_date'] = date("Y-m-d", mktime(0, 0, 0, $dt[0], $dt[1], $dt[2]));

		if (!preg_match("/(([0-9]{4}-[0-9]{2})-([0-9]{2}))/", $rafeed['departure_date'], $matches)) {
			$this->mydebug->rafeed_log("flight date formate missing - " . $rafeed['departure_date'] . " - " . $column, 1);
			return;
		}

		$rafeed['departure_date'] = strtotime($rafeed['departure_date']);

		//$rafeed['departure_date'] = strtotime(str_replace('-', '/', $Row[array_search('flight date', $import_header)]));
		$day_of_week = date('w', $rafeed['departure_date']);
		$day = ($day_of_week) ? $day_of_week : 7;
		$rafeed['day_of_week'] = $this->airports_m->getDefIdByTypeAndCode($day, '14');

		$marketing_airline_code = $Row[array_search('marketing airline code', $import_header)];
		$rafeed['marketing_airline_code'] =
			$this->airports_m->getDefIdByTypeAndCode($marketing_airline_code, '12');

		if (strlen($marketing_airline_code) != 2) {
			$this->mydebug->rafeed_log("MKT airine should be 2 alpha code in row " . $column, 1);
			return;
		}

		$operating_airline_code = $Row[array_search('operating airline code', $import_header)];
		$rafeed['operating_airline_code'] =
			$this->airports_m->getDefIdByTypeAndCode($operating_airline_code, '12');

		if (strlen($operating_airline_code) != 2) {
			$this->mydebug->rafeed_log("Operating airline should be 2 alpha code in row " . $column, 1);
			return;
		}
		$season_list = $this->season_m->getSeasonForDateANDAirlineIDForRAFeed($rafeed['departure_date'], $rafeed['carrier'], $rafeed['boarding_point'], $rafeed['off_point']);
		//$rafeed['season_id'] = $season_id; 
		$rafeed['flight_number'] = substr($Row[array_search('flight number', $import_header)], 2);

		if (strlen($rafeed['flight_number']) >= 7) {
			$this->mydebug->rafeed_log("Flight number should not be more than 6 AlphaNumeric code in row " . $column, 1);
			return;
		}

		$rafeed['office_id'] = $Row[array_search('officeid', $import_header)];
		$rafeed['channel'] = $Row[array_search('channel', $import_header)];
		$pax_type = $Row[array_search('pax type', $import_header)];
		$rafeed['pax_type'] =  $this->airports_m->getDefIdByTypeAndCode($pax_type, '18');

		if (strlen($pax_type) >= 4 || !ctype_alpha($pax_type)) {
			$this->mydebug->rafeed_log("Pax type code should be 2 alpha code in row " . $column, 1);
			return;
		}

		$is_null_flag = 0;
		foreach ($rafeed as $k => $v) {
			if ($k != 'day_of_week' && $k != 'season_id') {
				if ($v == '') {
					$this->mydebug->rafeed_log("There is null value column " . $k . " in row " . $column, 1);
					$is_null_flag = 1;
				}
			}
		}
		if ($is_null_flag == 1) {
			$this->mydebug->rafeed_log("Improper data for row " . $column . " skipping ..", 1);
			return;
		}

// 		var_dump($rafeed);
// 		exit;
		if ($this->rafeed_m->checkRaFeed($rafeed)) {
			$rafeed['create_date'] = time();
			$rafeed['modify_date'] = time();
			$rafeed['create_userID'] = $this->session->userdata('loginuserID');
			$rafeed['modify_userID'] = $this->session->userdata('loginuserID');
			//print_r($rafeed);
			if (count($season_list) > 0) {
				$first_flag = 0;
				foreach ($season_list as $season_id) {
					$rafeed['season_id'] = $season_id;

					if ($first_flag == 0) {
						$insert_id = $this->rafeed_m->insert_rafeed($rafeed);
						$main_season_record_id = $insert_id;
					} else {
						$rafeed['sub_season_record'] = $main_season_record_id;
						$insert_id = $this->rafeed_m->insert_rafeed($rafeed);
					}
					$first_flag++;
				}
			} else {
				$rafeed['season_id'] = 0;
				$insert_id = $this->rafeed_m->insert_rafeed($rafeed);
			}
			if ($insert_id) {
				$this->mydebug->rafeed_log("uploaded row " . $column, 0);
				return;
			} else {

				$this->mydebug->rafeed_log("Record not inserted for row " . $column, 1);
				return;
			}
		} else {
			$this->mydebug->rafeed_log("Duplicate Entry", 1);
			return;
		}
	}

	function server_processing()
	{
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');



		$aColumns = array(
			'rafeed_id', 'airline_code', 'ticket_number', 'coupon_number', 'dc.code', 'dci.code', 'dico.code', 'dici.code', 'dbp.code', 'dop.code', 'prorated_price', 'dcla.code', 'class', 'fare_basis', 'rf.departure_date', 'day_of_week', 'dai.code', 'dam.code', 'dcar.code', 'rf.flight_number', 'office_id', 'channel', 'dpax.code', 'rf.active', 'dfre.aln_data_value', 'dc.aln_data_value', 'dci.aln_data_value', 'dico.aln_data_value',
			'dici.aln_data_value', 'dai.aln_data_value', 'dam.aln_data_value', 'dcar.aln_data_value', 'dbp.aln_data_value',
			'dop.aln_data_value', 'def.desc'
		);


		$sLimit = "";

		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = "LIMIT " . $_GET['iDisplayStart'] . "," . $_GET['iDisplayLength'];
		}
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					//if($_GET['iSortCol_0'] == 8){
					//	$sOrder .= " (s.order_no*-1) DESC ,";
					//} else {
					$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
							" . $_GET['sSortDir_' . $i] . ", ";
					//}
				}
			}
			$sOrder = substr_replace($sOrder, "", -2);

			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}
		$sWhere = "";
		if ($_GET['sSearch'] != "") {
			$sWhere = "WHERE (";
			for ($i = 0; $i < count($aColumns); $i++) {
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
				if ($sWhere == "") {
					$sWhere = "WHERE ";
				} else {
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch_' . $i] . "%' ";
			}
		}



		if (!empty($this->input->get('bookingCountry'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.booking_country = ' . $this->input->get('bookingCountry');
		}
		if (!empty($this->input->get('bookingCity'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.booking_city = ' . $this->input->get('bookingCity');
		}


		if (!empty($this->input->get('boardPoint'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.boarding_point = ' . $this->input->get('boardPoint');
		}
		if (!empty($this->input->get('offPoint'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.off_point = ' . $this->input->get('offPoint');
		}


		if (!empty($this->input->get('airLine'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.carrier= ' . $this->input->get('airLine');
		}
		if (!empty($this->input->get('Class'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.cabin = ' . $this->input->get('Class');
		}

		if (!empty($this->input->get('flight_range'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$num_arr = explode('-', $this->input->get('flight_range'));

			if ($num_arr[0] > 0 and $num_arr[1] > 0 and $num_arr[1] > $num_arr[0]) {
				$sWhere .= 'rf.flight_number >= ' . $num_arr[0] . ' AND rf.flight_number <= ' . $num_arr[1];
			} else if ($num_arr[0] > 0) {
				$sWhere .= 'rf.flight_number =' . $num_arr[0];
			}
		}


		if (!empty($this->input->get('start_date'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.departure_date >= ' . strtotime($this->input->get('start_date'));
		}
		if (!empty($this->input->get('end_date'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.departure_date <= ' .  strtotime($this->input->get('end_date'));
		}



		if (!empty($this->input->get('frequency'))) {
			$frstr = $this->input->get('frequency');
			$freq = $this->airports_m->getDefnsCodesListByType('14');
			if ($frstr === '*') {
				$frstr = '1234567';
			}

			if ($frstr != '0') {
				$arr = str_split($frstr);
				$freq_str = implode(',', array_map(function ($x) use ($freq) {
					return array_search($x, $freq);
				}, $arr));
				$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
				$sWhere .= 'rf.day_of_week IN (' . $freq_str . ') ';
			}
		}

		$roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
		if ($roleID != 1) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.carrier IN (' . implode(',', $this->session->userdata('login_user_airlineID')) . ')';
		}


		$sWhere .=  ($sWhere == '') ? ' WHERE ' : ' AND ';
		$sWhere .=  " rf.sub_season_record = 0 ";
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS rafeed_id,ticket_number, coupon_number, dc.code as booking_country , 
				dfre.code as day_of_week,  dfre.aln_data_value , dc.aln_data_value, dci.aln_data_value, dico.aln_data_value,
				dici.aln_data_value, dai.aln_data_value, dam.aln_data_value, dcar.aln_data_value, dbp.aln_data_value,
				dop.aln_data_value,def.desc,
			   dci.code as  booking_city, dico.code as issuance_country, dici.code as issuance_city,dcar.code as carrier_code,
			    dai.code as operating_airline_code, dam.code as marketing_airline_code, flight_number, dbp.code as boarding_point, 
                           dop.code as off_point,  def.cabin as cabin ,  departure_date, prorated_price, class,
                           office_id, channel, dpax.code as pax_type ,rf.active  ,rf.airline_code, rf.fare_basis
                           FROM UP_ra_feed rf  
                          LEFT JOIN VX_data_defns dc on (dc.vx_aln_data_defnsID = rf.booking_country) 
                          LEFT JOIN VX_data_defns dci on  (dci.vx_aln_data_defnsID = rf.booking_city) 
			  LEFT JOIN VX_data_defns dico on (dico.vx_aln_data_defnsID = rf.issuance_country) 
                          LEFT JOIN VX_data_defns dici on  (dici.vx_aln_data_defnsID = rf.issuance_city)
                          LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
			  LEFT JOIN VX_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code)
			  LEFT JOIN VX_data_defns dcar on (dcar.vx_aln_data_defnsID = rf.carrier)
                          LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point)  
                          LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) 
			 INNER JOIN VX_airline_cabin_def def on (def.carrier = rf.carrier)
                           INNER JOIN VX_data_defns dcla on (dcla.alias = def.level and dcla.aln_data_typeID = 13 and rf.cabin = dcla.vx_aln_data_defnsID) 
			   LEFT JOIN VX_data_defns dpax on (dpax.vx_aln_data_defnsID = rf.pax_type) 
			  LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = rf.day_of_week) 
		$sWhere			
		$sOrder
		$sLimit	";

		$rResult = $this->install_m->run_query($sQuery);
		$sQuery = "SELECT FOUND_ROWS() as total";
		$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $rResultFilterTotal,
			"iTotalDisplayRecords" => $rResultFilterTotal,
			"aaData" => array()
		);

		$i = 1;

		$rownum = 1 + $_GET['iDisplayStart'];

		foreach ($rResult as $feed) {
			$feed->cbox = "<input type='checkbox'  class='deleteRow' value='" . $feed->rafeed_id . "'  /> " . $rownum;
			$rownum++;

			$feed->departure_date = date('d/m/Y', $feed->departure_date);

			if (permissionChecker('rafeed_delete')) {
				$feed->action .= btn_delete('rafeed/delete/' . $feed->rafeed_id, $this->lang->line('delete'));
			}
			$status = $feed->active;
			$feed->active = "<div class='onoffswitch-small' id='" . $feed->rafeed_id . "'>";
			$feed->active .= "<input type='checkbox' id='myonoffswitch" . $feed->rafeed_id . "' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if ($status) {
				$feed->active .= " checked >";
			} else {
				$feed->active .= ">";
			}

			$feed->active .= "<label for='myonoffswitch" . $feed->rafeed_id . "' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			$feed->temp_id = $i;
			$i++;
			$output['aaData'][] = $feed;
		}
		if (isset($_REQUEST['export'])) {
			$columns = array("#", "Airline Code", "Ticket Number", "Coupon number", "Booking Country", "Booking City", "Issuance Country", "Issuance City", "Board Point", "Off Point", "Prorated Price", "Cabin", "Class", "Fare Basis", "Departure Date", "Day Of Week", "Operating Airline", "Marketing Airline", "Carrier Code", "Flight Number", "Office", "Channel", "Pax Type");
			$rows = array("temp_id", "airline_code", "ticket_number", "coupon_number", "booking_country", "booking_city", "issuance_country", "issuance_city", "boarding_point", "off_point", "prorated_price", "cabin", "class", "fare_basis", "departure_date", "day_of_week", "operating_airline_code", "marketing_airline_code", "carrier_code", "flight_number", "office_id", "channel", "pax_type");
			$this->exportall($output['aaData'], $columns, $rows);
		} else {
			echo json_encode($output);
		}
	}

	function server_processing_baggage()
	{
		$userID = $this->session->userdata('loginuserID');
		$roleID = $this->session->userdata('roleID');



		$aColumns = array(
			'id', 'airline_code', 'ticket_number', 'coupon_number', 'dc.code', 'dci.code', 'dico.code', 'dici.code', 'dbp.code', 'dop.code', 'prorated_price', 'dcla.code', 'class', 'fare_basis', 'rf.departure_date', 'day_of_week', 'dai.code', 'dam.code', 'dcar.code', 'rf.flight_number', 'office_id', 'channel', 'dpax.code', 'rf.active', 'dfre.aln_data_value', 'dc.aln_data_value', 'dci.aln_data_value', 'dico.aln_data_value',
			'dici.aln_data_value', 'dai.aln_data_value', 'dam.aln_data_value', 'dcar.aln_data_value', 'dbp.aln_data_value',
			'dop.aln_data_value', 'def.desc'
		);


		$sLimit = "";

		if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
			$sLimit = "LIMIT " . $_GET['iDisplayStart'] . "," . $_GET['iDisplayLength'];
		}
		if (isset($_GET['iSortCol_0'])) {
			$sOrder = "ORDER BY  ";
			for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
				if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
					//if($_GET['iSortCol_0'] == 8){
					//	$sOrder .= " (s.order_no*-1) DESC ,";
					//} else {
					$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
							" . $_GET['sSortDir_' . $i] . ", ";
					//}
				}
			}
			$sOrder = substr_replace($sOrder, "", -2);

			if ($sOrder == "ORDER BY") {
				$sOrder = "";
			}
		}
		$sWhere = "";
		if ($_GET['sSearch'] != "") {
			$sWhere = "WHERE (";
			for ($i = 0; $i < count($aColumns); $i++) {
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
			}
			$sWhere = substr_replace($sWhere, "", -3);
			$sWhere .= ')';
		}

		/* Individual column filtering */
		for ($i = 0; $i < count($aColumns); $i++) {
			if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
				if ($sWhere == "") {
					$sWhere = "WHERE ";
				} else {
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch_' . $i] . "%' ";
			}
		}

		if (!empty($this->input->get('boardPoint'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.boarding_point = ' . $this->input->get('boardPoint');
		}
		if (!empty($this->input->get('offPoint'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.off_point = ' . $this->input->get('offPoint');
		}

		if (!empty($this->input->get('weight'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.weight = "' . $this->input->get('weight') . '"';
		}

		if (!empty($this->input->get('ssr_code'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.ssr_code = "' . $this->input->get('ssr_code') . '"';
		}

		if (!empty($this->input->get('rfic'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.rfic = "' . $this->input->get('rfic') . '"';
		}

		if (!empty($this->input->get('rfisc'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.rfisc = "' . $this->input->get('rfisc') . '"';
		}


		if (!empty($this->input->get('airLine'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.carrier= ' . $this->input->get('airLine');
		}
		if (!empty($this->input->get('Class'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.cabin = ' . $this->input->get('Class');
		}

		if (!empty($this->input->get('flight_range'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$num_arr = explode('-', $this->input->get('flight_range'));

			if ($num_arr[0] > 0 and $num_arr[1] > 0 and $num_arr[1] > $num_arr[0]) {
				$sWhere .= 'rf.flight_number >= ' . $num_arr[0] . ' AND rf.flight_number <= ' . $num_arr[1];
			} else if ($num_arr[0] > 0) {
				$sWhere .= 'rf.flight_number =' . $num_arr[0];
			}
		}


		if (!empty($this->input->get('start_date'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.departure_date >= ' . strtotime($this->input->get('start_date'));
		}
		if (!empty($this->input->get('end_date'))) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.departure_date <= ' .  strtotime($this->input->get('end_date'));
		}

		if (!empty($this->input->get('frequency'))) {
			$frstr = $this->input->get('frequency');
			$freq = $this->airports_m->getDefnsCodesListByType('14');
			if ($frstr === '*') {
				$frstr = '1234567';
			}

			if ($frstr != '0') {
				$arr = str_split($frstr);
				$freq_str = implode(',', array_map(function ($x) use ($freq) {
					return array_search($x, $freq);
				}, $arr));
				$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
				$sWhere .= 'rf.day_of_week IN (' . $freq_str . ') ';
			}
		}

		$roleID = $this->session->userdata('roleID');
		$userID = $this->session->userdata('loginuserID');
		if ($roleID != 1) {
			$sWhere .= ($sWhere == '') ? ' WHERE ' : ' AND ';
			$sWhere .= 'rf.carrier IN (' . implode(',', $this->session->userdata('login_user_airlineID')) . ')';
		}

		$sWhere .=  ($sWhere == '') ? ' WHERE ' : ' AND ';
		$sWhere .=  " rf.sub_season_record = 0 ";
		$sQuery = " SELECT SQL_CALC_FOUND_ROWS rf.id as rafeed_id, rf.coupon_number,rf.weight,rf.rfic,rf.rfisc,rf.ssr_code, 
				dfre.code as day_of_week,  dfre.aln_data_value , dai.aln_data_value, dam.aln_data_value, 
				dcar.aln_data_value, dbp.aln_data_value,dop.aln_data_value,def.desc,dcar.code as carrier_code,
			    dai.code as operating_airline_code, dam.code as marketing_airline_code, flight_number, dbp.code as boarding_point, 
                           dop.code as off_point,  def.cabin as cabin ,  departure_date, prorated_price, class,
                           office_id, channel, dpax.code as pax_type ,rf.active ,rf.airline_code, rf.fare_basis
                           FROM BG_ra_feed rf                          
                          LEFT JOIN VX_data_defns dai on (dai.vx_aln_data_defnsID = rf.operating_airline_code)  
			  LEFT JOIN VX_data_defns dam on (dam.vx_aln_data_defnsID = rf.marketing_airline_code)
			  LEFT JOIN VX_data_defns dcar on (dcar.vx_aln_data_defnsID = rf.carrier)
                          LEFT JOIN  VX_data_defns dbp on (dbp.vx_aln_data_defnsID = rf.boarding_point)  
                          LEFT JOIN VX_data_defns dop on (dop.vx_aln_data_defnsID = rf.off_point) 
			 INNER JOIN VX_airline_cabin_def def on (def.carrier = rf.carrier)
                           INNER JOIN VX_data_defns dcla on (dcla.alias = def.level and dcla.aln_data_typeID = 13 and rf.cabin = dcla.vx_aln_data_defnsID) 
			   LEFT JOIN VX_data_defns dpax on (dpax.vx_aln_data_defnsID = rf.pax_type) 
			  LEFT JOIN VX_data_defns dfre on (dfre.vx_aln_data_defnsID = rf.day_of_week) 
		$sWhere			
		$sOrder
		$sLimit	";

		$rResult = $this->install_m->run_query($sQuery);
		$sQuery = "SELECT FOUND_ROWS() as total";
		$rResultFilterTotal = $this->install_m->run_query($sQuery)[0]->total;

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $rResultFilterTotal,
			"iTotalDisplayRecords" => $rResultFilterTotal,
			"aaData" => array()
		);

		$i = 1;

		$rownum = 1 + $_GET['iDisplayStart'];

		foreach ($rResult as $feed) {
			$feed->cbox = "<input type='checkbox'  class='deleteRow' value='" . $feed->rafeed_id . "'  /> " . $rownum;
			$rownum++;

			$feed->departure_date = date('d/m/Y', $feed->departure_date);

			if (permissionChecker('rafeed_delete')) {
				$feed->action .= btn_delete('rafeed/delete/' . $feed->rafeed_id, $this->lang->line('delete'));
			}
			$status = $feed->active;
			$feed->active = "<div class='onoffswitch-small' id='" . $feed->rafeed_id . "'>";
			$feed->active .= "<input type='checkbox' id='myonoffswitch" . $feed->rafeed_id . "' class='onoffswitch-small-checkbox' name='paypal_demo'";
			if ($status) {
				$feed->active .= " checked >";
			} else {
				$feed->active .= ">";
			}

			$feed->active .= "<label for='myonoffswitch" . $feed->rafeed_id . "' class='onoffswitch-small-label'><span class='onoffswitch-small-inner'></span> <span class='onoffswitch-small-switch'></span> </label></div>";
			$feed->temp_id = $i;
			$i++;
			$output['aaData'][] = $feed;
		}
		if (isset($_REQUEST['export'])) {
			$columns = array("#", "Airline Code", "Ticket Number", "Coupon number", "Booking Country", "Booking City", "Issuance Country", "Issuance City", "Board Point", "Off Point", "Prorated Price", "Cabin", "Class", "Fare Basis", "Departure Date", "Day Of Week", "Operating Airline", "Marketing Airline", "Carrier Code", "Flight Number", "Office", "Channel", "Pax Type");
			$rows = array("temp_id", "airline_code", "ticket_number", "coupon_number", "booking_country", "booking_city", "issuance_country", "issuance_city", "boarding_point", "off_point", "prorated_price", "cabin", "class", "fare_basis", "departure_date", "day_of_week", "operating_airline_code", "marketing_airline_code", "carrier_code", "flight_number", "office_id", "channel", "pax_type");
			$this->exportall($output['aaData'], $columns, $rows);
		} else {
			echo json_encode($output);
		}
	}



	function downloadFormat($p_nType = 'rafeed')
	{
		$this->load->helper('download');

		switch ($p_nType) {

			case 'rafeed-baggage':
				$filename = APPPATH . 'downloads/rafeed-baggage.xlsx';
				break;
			default:
				$filename = APPPATH . 'downloads/rafeed.xlsx';
		}


		force_download($filename, null);
	}

	function active()
	{

		if (permissionChecker('rafeed_edit')) {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			if ($id != '' && $status != '') {
				$data['modify_userID'] = $this->session->userdata('loginuserID');
				$data['modify_date'] = time();
				if ($status == 'chacked') {
					$data['active'] = 1;
					$this->rafeed_m->update_rafeed($data, $id);
					echo 'Success';
				} elseif ($status == 'unchacked') {
					$data['active'] = 0;
					$this->rafeed_m->update_rafeed($data, $id);
					echo 'Success';
				} else {
					echo "Error";
				}
			} else {
				echo "Error";
			}
		} else {
			echo "Error";
		}
	}


	function convertTimeToSeconds($time_str)
	{
		$str = explode(':', $time_str);
		$time_in_seconds = (3600 * $str[0]) + (60 * $str[1]) + (1 * $str[2]);
		return $time_in_seconds;
	}


	public function delete_rafeed_bulk_records()
	{
		$data_ids = $_REQUEST['data_ids'];
		$data_id_array = explode(",", $data_ids);
		if (!empty($data_id_array)) {
			foreach ($data_id_array as $id) {
				$this->data['rafeed'] = $this->rafeed_m->get_single_rafeed(array('rafeed_id' => $id));
				if ($this->data['rafeed']) {
					$this->rafeed_m->delete_rafeed($id);
				}
			}
		}
	}
}
