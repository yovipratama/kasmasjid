@extends('crudbooster::admin_template')

@section('content')
<div class="box box-default">
  <div class="box-body table-responsive no-padding">
	<table class="table table-bordered">
	  <tbody>
		<tr class="active">
		  <td colspan="2"><strong><i class="fa fa-bars"></i> Download Proposal</strong></td>
		</tr>
		<tr>
			<td width="25%"><strong>Bahasa. Indonesia</strong></td>
			<td><a class="btn btn-primary" href="{{$proposalid}}" target="_blank"><i class="fa fa-download"></i> Download</a></td>
		</tr>					
		<tr>
			<td width="25%"><strong>English</strong></td>
			<td><a class="btn btn-primary" href="{{$proposalen}}" target="_blank"><i class="fa fa-download"></i> Download</a><!--iframe src="{{$proposal}}" width="100%" height="600"></iframe!--></td>
		</tr>					
	  </tbody>
	</table>    
  </div>
</div>
<div class="box">
	<div class="box-header">  
		<div class="pull-left">
		B. Indonesia
        </div>
        <br style="clear:both">
	</div>
	<div class="box-body table-responsive no-padding">
		<iframe src="{{$proposalid}}" width="100%" height="600"></iframe>
	</div>
</div>
<div class="box">
	<div class="box-header">  
		<div class="pull-left">
		English
        </div>
        <br style="clear:both">
	</div>
	<div class="box-body table-responsive no-padding">
		<iframe src="{{$proposalen}}" width="100%" height="600"></iframe>
	</div>
</div>
@endsection
