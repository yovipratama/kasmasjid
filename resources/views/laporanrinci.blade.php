@extends('crudbooster::admin_template')

@section('content')
<div class="box">
	<div class="box-header">  
		<div class="pull-left">     
			<div style="display:inline-grid">Pilih Tanggal Tertentu : </div>
			<div class="input-group" style="display:inline-grid">
                <select onchange="showHide(this.value);" name="limit" class="form-control input-sm" id="tgl">
                    <option value="0">Semua</option> 
					<?php
					$hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
					$i=0;
					?>
					@foreach($waktu as $w)
					<?php
						$wk = $hari[date_format(date_create($w->waktu),"w")].", ".date_format(date_create($w->waktu),"j M Y");
						$i++;
					?>
                    <option value="{{$i}}">{{$wk}}</option>
					@endforeach
                </select>                              
			</div>		
        </div><!--end-pull-left-->
		<div class="box-tools pull-right" style="position: relative;margin-top: -5px;margin-right: -10px">
        </div> 
        <br style="clear:both">
	</div>
	<div class="box-body table-responsive no-padding">
		<table id="table_dashboard" class="table table-hover table-striped table-bordered">
			<thead>
				<tr class="active">           
					<th width="auto" rowspan=2 style="border:1px solid #ddd;text-align:center">Tanggal</th>   
					<th width="auto" rowspan=2 style="border:1px solid #ddd;text-align:center">Uraian</th>   
					<th width="auto" colspan=2 style="border:1px solid #ddd;text-align:center">Penerimaan</th>
					<th width="auto" colspan=2 style="border:1px solid #ddd;text-align:center">Pengeluaran</th>
					<th width="auto" rowspan=2 style="border:1px solid #ddd;text-align:center">Pendapatan</th>   
					<th width="auto" rowspan=2 style="border:1px solid #ddd;text-align:center">Kumulatif</th>
				</tr>
				<tr class="active">           
					<th width="auto" style="border:1px solid #ddd;text-align:center">Uang (Rp)</th>
					<th width="auto" style="border:1px solid #ddd;text-align:center">Bahan</th>
					<th width="auto" style="border:1px solid #ddd;text-align:center">Uang (Rp)</th>   
					<th width="auto" style="border:1px solid #ddd;text-align:center">Bahan</th>
				</tr>
			</thead>
			<tbody>
				<?php $saldo = 0; 
				$hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
				$i=0;
				?>
				@foreach($waktu as $w)
					<?php $totaldm = 0; $totaldk = 0;
						$wk = $hari[date_format(date_create($w->waktu),"w")].", ".date_format(date_create($w->waktu),"j M Y");
						$i++;
					?>
					@if($i>1)
					<tr class="all all{{$i}} sebelum danger">
						<td colspan=7 style="font-weight:bold">Saldo Hari Sebelumnya</td>
						<td style="text-align:right;font-weight:bold">{{ number_format($saldo,null,null,".")}}</td>
					</tr>
					@endif
					@if(count($dm[$w->waktu])>0)
					@foreach($dm[$w->waktu] as $md)
							<?php
								$totaldm = $totaldm + $md->jumlah;
								if($md->via == 'bank'){
									$class = 'success';
								}
							?>
							
						<tr class='all all{{$i}} {{$class}}' >
							<td>{{ $wk }}</td>
							<?php $wk = ""; $class = "";?>
							<td>{{ $md->uraian }}</td>
							<td style="text-align:right">{{ number_format($md->jumlah,null,null,".") }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@endif
					@if(count($dk[$w->waktu])>0)
					@foreach($dk[$w->waktu] as $kd)
							<?php 
								$totaldk = $totaldk + $kd->jumlah; 								
								if($kd->via == 'bank'){
									$class = 'success';
								}
							?>
							
						<tr class='all all{{$i}} {{$class}}'>
							<td>{{ $wk }}</td>
							<?php $wk = "";$class = ""; ?>
							<td>{{ $kd->uraian }}</td>
							<td></td>
							<td></td>
							<td style="text-align:right">{{ number_format($kd->jumlah,null,null,".") }}</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@endif
					@if(count($bm[$w->waktu])>0)
					@foreach($bm[$w->waktu] as $mb)
						<tr class="all all{{$i}} ">
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td>{{ $mb->uraian }}</td>
							<td></td>
							<td style="text-align:right">{{ $mb->jumlah }} {{ $mb->satuan }} {{ $mb->bahan }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@endif
					@if(count($bk[$w->waktu])>0)
					@foreach($bk[$w->waktu] as $kb)
						<tr class="all all{{$i}} ">
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td>{{ $kb->uraian }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td style="text-align:right">{{ $kb->jumlah }} {{ $kb->satuan }} {{ $kb->bahan }}</td>
							<td></td>
							<td></td>
						</tr>
					@endforeach
					@endif
						<tr class="all all{{$i}} danger">
							<td colspan=2 style="font-weight:bold">Saldo Hari ini</td>
							<td style="text-align:right;font-weight:bold">{{ number_format($totaldm,null,null,".") }}</td>
							<td></td>
							<td style="text-align:right;font-weight:bold">{{ number_format($totaldk,null,null,".") }}</td>
							<td></td>
							<td style="text-align:right;font-weight:bold">{{ number_format($pdpt = $totaldm-$totaldk,null,null,".")}}</td>
							<td style="text-align:right;font-weight:bold">{{ number_format($saldo = $saldo+$pdpt,null,null,".")}}</td>
						</tr>
						<tr class="all all{{$i}} ">
							<td colspan=8>&nbsp;</td>
						</tr>
				@endforeach
				<tr class="active all all{{$i}}">           
					<td width="auto" colspan=7 style="text-align:right;font-size:large;font-weight:bold">Saldo Akhir</td>
					<td width="auto" style="text-align:right;font-size:large;font-weight:bold">{{ number_format($saldo,null,null,".") }}</td>
				</tr>
				<tr class="active all all{{$i}}">           
					<td width="auto" colspan=7 style="text-align:right;font-size:medium;font-weight:bold">Bank</td>
					<td width="auto" style="text-align:right;font-size:medium;font-weight:bold">{{ number_format($saldobank[0]->bank,null,null,".") }}</td>
				</tr>
				<tr class="active all all{{$i}}">           
					<td width="auto" colspan=7 style="text-align:right;font-size:medium;font-weight:bold">Cash</td>
					<td width="auto" style="text-align:right;font-size:medium;font-weight:bold">{{ number_format($saldo - ($saldobank[0]->bank),null,null,".") }}</td>
				</tr>
			</tbody>  
		</table>                                   
		<p></p>
	</div>
</div>
<script src="{{asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script>
function showHide(x){
	if(x==0){
		$('.all').show();
		$('.sebelum').hide();
		$('#print').attr('href',"{{crudbooster::mainpath('export/print')}}");
		$('#export').attr('href',"{{crudbooster::mainpath('export/pdf')}}");
	}
	else{
		$('.all').hide();
		$('.all'+x).show();
		$('#print').attr('href',"{{crudbooster::mainpath('export/print/')}}"+x);
		$('#export').attr('href',"{{crudbooster::mainpath('export/pdf/')}}"+x);
	}
}
showHide('{{count($waktu)}}');
$('#tgl').val('{{count($waktu)}}');
</script>
@endsection
