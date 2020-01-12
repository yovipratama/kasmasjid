<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminPdfController extends \crocodicstudio\crudbooster\controllers\CBController {
		
		public function cbInit(){
			
		}
		
		public function getPdf(){
			//Create your own query 
			$data = [];
			$data['page_title'] = 'Proposal';
			$data['proposalid'] = asset('uploads/2018-03/proposal-id.pdf');
			$data['proposalen'] = asset('uploads/2018-03/proposal-en.pdf');
			$this->cbView('proposal',$data);
		}
	}
	