<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App;
	use Excel;

	class AdminLaporanRinciController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = false;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = false;
			$this->button_show = false;
			$this->button_filter = false;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "masuk_dana";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Uraian","name"=>"uraian"];
			$this->col[] = ["label"=>"Jumlah","name"=>"jumlah"];
			$this->col[] = ["label"=>"Waktu","name"=>"waktu"];
			$this->col[] = ["label"=>"Via","name"=>"via"];
			$this->col[] = ["label"=>"Kotak Harian","name"=>"kotak_harian"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'money','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Waktu','name'=>'waktu','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Via','name'=>'via','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Kotak Harian','name'=>'kotak_harian','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Uraian","name"=>"uraian","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Jumlah","name"=>"jumlah","type"=>"money","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Waktu","name"=>"waktu","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Via","name"=>"via","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Kotak Harian","name"=>"kotak_harian","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			if(CRUDBooster::myPrivilegeId()!=3){
				$this->index_button[] = ['label'=>' Print ','url'=>crudbooster::mainpath('export/print'),'icon'=>'fa fa-print'];
			}

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }

		public function getIndex() {
			//First, Add an auth
			if(!CRUDBooster::isView()) CRUDBooster::denyAccess();
			
			//Create your own query 
			$data = [];
			$data['page_title'] = 'Laporan Rinci';
			$dm = DB::table('masuk_dana')->orderby('waktu','asc')->get();
			foreach($dm as $md){
				$data['dm'][$md->waktu][] = $md;
			}
			$dk = DB::table('keluar_dana')->orderby('waktu','asc')->get();
			foreach($dk as $kd){
				$data['dk'][$kd->waktu][] = $kd;
			}
			$bm = DB::select("select *,b.nama bahan,s.nama satuan from masuk_bahan mb join bahan b on mb.id_bahan = b.id join satuan s on b.id_satuan = s.id order by mb.waktu asc");
			foreach($bm as $mb){
				$data['bm'][$mb->waktu][] = $mb;
			}
			$bk = DB::select("select *,b.nama bahan,s.nama satuan from keluar_bahan kb join bahan b on kb.id_bahan = b.id join satuan s on b.id_satuan = s.id order by kb.waktu asc");
			foreach($bk as $kb){
				$data['bk'][$kb->waktu][] = $kb;
			}
			$data['waktu'] = DB::select("select waktu from masuk_dana UNION select waktu from masuk_bahan UNION select waktu from keluar_dana UNION select waktu from keluar_bahan
ORDER BY waktu asc");
			$data['saldobank'] = DB::select("select IFNULL((select sum(jumlah) from masuk_dana where via = 'bank'),0) - ifnull((SELECT sum(jumlah) from keluar_dana where via = 'bank'),0) bank");
			//Create a view. Please use `cbView` method instead of view method from laravel.
			// dd($data);
			$this->cbView('laporanrinci',$data);
		}
		
		public function getExport($filetype,$urut=""){
			ini_set('memory_limit', '1024M');
			set_time_limit(180);
			
			$filename 			= "Laporan-Rinci-".date("YmdHis");
			$papersize			= "A4";
			$paperorientation	= "landscape";

			$data = [];
			$dm = DB::table('masuk_dana')->orderby('waktu','asc')->get();
			foreach($dm as $md){
				$data['dm'][$md->waktu][] = $md;
			}
			$dk = DB::table('keluar_dana')->orderby('waktu','asc')->get();
			foreach($dk as $kd){
				$data['dk'][$kd->waktu][] = $kd;
			}
			$bm = DB::select("select *,b.nama bahan,s.nama satuan from masuk_bahan mb join bahan b on mb.id_bahan = b.id join satuan s on b.id_satuan = s.id order by mb.waktu asc");
			foreach($bm as $mb){
				$data['bm'][$mb->waktu][] = $mb;
			}
			$bk = DB::select("select *,b.nama bahan,s.nama satuan from keluar_bahan kb join bahan b on kb.id_bahan = b.id join satuan s on b.id_satuan = s.id order by kb.waktu asc");
			foreach($bk as $kb){
				$data['bk'][$kb->waktu][] = $kb;
			}
			$data['waktu'] = DB::select("select waktu from masuk_dana UNION select waktu from masuk_bahan UNION select waktu from keluar_dana UNION select waktu from keluar_bahan
ORDER BY waktu asc");
			$data['saldobank'] = DB::select("select IFNULL((select sum(jumlah) from masuk_dana where via = 'bank'),0) - ifnull((SELECT sum(jumlah) from keluar_dana where via = 'bank'),0) bank");
			$data['filetype'] = $filetype;
			$data['urut'] = urldecode($urut);
			
			$response           = $data;

			switch($filetype) {
				case "print":
					echo $view = view('xlaporanrinci',$response)->render();
				break;
				case "pdf":
					$view = view('xlaporanrinci',$response)->render();
					$pdf = App::make('dompdf.wrapper');
					$pdf->loadHTML($view);
					$pdf->setPaper($papersize,$paperorientation);
					return $pdf->stream($filename.'.pdf');
				break;
			}
		}
			
	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}