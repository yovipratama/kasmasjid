<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminMsTanggalController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "ms_tanggal";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Tanggal","name"=>"tanggal"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Tanggal','name'=>'tanggal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];

			$masuk_dana[] = ['label'=>'Kategori Dana','name'=>'id_ms_kategori_dana','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'ms_kategori_dana,nama'];
			$masuk_dana[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$masuk_dana[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$masuk_dana[] = ['label'=>'Via','name'=>'via','type'=>'radio','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'cash;bank'];
			$masuk_dana[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$masuk_dana,'label'=>'Pemasukan Dana Masjid','name'=>'ms_masuk_dana','type'=>'child','width'=>'col-sm-10','table'=>'ms_masuk_dana','foreign_key'=>'id_ms_tanggal'];

			$keluar_dana[] = ['label'=>'Kategori Dana','name'=>'id_ms_kategori_dana','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'ms_kategori_dana,nama'];
			$keluar_dana[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$keluar_dana[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$keluar_dana[] = ['label'=>'Via','name'=>'via','type'=>'radio','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'cash;bank'];
			$keluar_dana[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$keluar_dana,'label'=>'Pengeluaran Dana Masjid','name'=>'ms_keluar_dana','type'=>'child','width'=>'col-sm-10','table'=>'ms_keluar_dana','foreign_key'=>'id_ms_tanggal'];
			
			$masuk_yatim[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$masuk_yatim[] = ['label'=>'Kotak Yatim','name'=>'kotak','type'=>'radio','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'Y;T'];
			$masuk_yatim[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$masuk_yatim[] = ['label'=>'Via','name'=>'via','type'=>'radio','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'cash;bank'];
			$masuk_yatim[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$masuk_yatim,'label'=>'Pemasukkan Dana Yatim','name'=>'ms_masuk_yatim','type'=>'child','width'=>'col-sm-10','table'=>'ms_masuk_yatim','foreign_key'=>'id_ms_tanggal'];
			
			$keluar_yatim[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$keluar_yatim[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$keluar_yatim[] = ['label'=>'Via','name'=>'via','type'=>'radio','validation'=>'required|min:1|max:255','width'=>'col-sm-10','dataenum'=>'cash;bank'];
			$keluar_yatim[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$keluar_yatim,'label'=>'Pengeluaran Dana Yatim','name'=>'ms_keluar_yatim','type'=>'child','width'=>'col-sm-10','table'=>'ms_keluar_yatim','foreign_key'=>'id_ms_tanggal'];
			
			$masuk_bahan[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$masuk_bahan[] = ['label'=>'Penanggung Jawab','name'=>'pj','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$masuk_bahan[] = ['label'=>'Bahan','name'=>'id_bahan','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bahan,nama','datatable_format'=>'nama,\' - \',(select satuan.nama from satuan where satuan.id = id_satuan)'];
			$masuk_bahan[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$masuk_bahan[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$masuk_bahan,'label'=>'Wakaf Material','name'=>'ms_masuk_bahan','type'=>'child','width'=>'col-sm-10','table'=>'ms_masuk_bahan','foreign_key'=>'id_ms_tanggal'];

			$keluar_bahan[] = ['label'=>'Uraian','name'=>'uraian','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$keluar_bahan[] = ['label'=>'Penanggung Jawab','name'=>'pj','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$keluar_bahan[] = ['label'=>'Bahan','name'=>'id_bahan','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'bahan,nama','datatable_format'=>'nama,\' - \',(select satuan.nama from satuan where satuan.id = id_satuan)'];
			$keluar_bahan[] = ['label'=>'Jumlah','name'=>'jumlah','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$keluar_bahan[] = ['label'=>'Bukti','name'=>'bukti','type'=>'upload','validation'=>'image'];
			$this->form[] = ['columns'=>$keluar_bahan,'label'=>'Pengeluaran Material','name'=>'ms_keluar_bahan','type'=>'child','width'=>'col-sm-10','table'=>'ms_keluar_bahan','foreign_key'=>'id_ms_tanggal'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Tanggal','name'=>'tanggal','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Pemasukan Dana','name'=>'ms_masuk_dana','type'=>'child','width'=>'col-sm-10','table'=>'ms_masuk_dana','foreign_key'=>'id_ms_tanggal'];
			//$this->form[] = ['label'=>'Pengeluaran Dana','name'=>'ms_keluar_dana','type'=>'child','width'=>'col-sm-10','table'=>'ms_keluar_dana','foreign_key'=>'id_ms_tanggal'];
			//$this->form[] = ['label'=>'Wakaf Material','name'=>'ms_masuk_bahan','type'=>'child','width'=>'col-sm-10','table'=>'ms_masuk_bahan','foreign_key'=>'id_ms_tanggal'];
			//$this->form[] = ['label'=>'Pengeluaran Material','name'=>'ms_keluar_bahan','type'=>'child','width'=>'col-sm-10','table'=>'ms_keluar_bahan','foreign_key'=>'id_ms_tanggal'];
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
			$hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
			if($column_index == 1){
				$column_value = $hari[date_format(date_create($column_value),"w")].", ".date_format(date_create($column_value),"j M Y");
			}
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