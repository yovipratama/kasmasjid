@if($filetype == 'print')
<script>print()</script>
@endif
<h2 style="text-align:center" width="100%">Penerimaan dan Pengeluaran <u>Harian</u> Dana/Bahan Pembangunan Masjid Darussalam Pakuan Baru</h2>
<table border='1' width='100%' cellpadding='3' cellspacing="0" style='border-collapse: collapse;font-size:12px'>
			<thead>
				<tr class="active">           
					<th width="auto" rowspan=2 style="text-align:center">Tanggal</th>   
					<th width="auto" rowspan=2 style="text-align:center">Uraian</th>   
					<th width="auto" colspan=2 style="text-align:center">Penerimaan</th>
					<th width="auto" colspan=2 style="text-align:center">Pengeluaran</th>
					<th width="auto" rowspan=2 style="text-align:center">Pendapatan</th>   
					<th width="auto" rowspan=2 style="text-align:center">Kumulatif</th>
				</tr>
				<tr class="active">           
					<th width="auto" style="text-align:center">Uang (Rp)</th>
					<th width="auto" style="text-align:center">Bahan</th>
					<th width="auto" style="text-align:center">Uang (Rp)</th>   
					<th width="auto" style="text-align:center">Bahan</th>
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
					@foreach($dm as $md)
						@if($md->waktu == $w->waktu)
							<?php $totaldm = $totaldm + $md->jumlah; ?>
						<tr class='all all{{$i}}'>
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td><?php echo ($md->kotak_harian==0 ? 'Infaq Hamba Allah' : 'Infaq Kotak Harian'); ?></td>
							<td style="text-align:right">{{ number_format($md->jumlah,null,null,".") }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endif
					@endforeach
					@foreach($dk as $kd)
						@if($kd->waktu == $w->waktu)
							<?php $totaldk = $totaldk + $kd->jumlah; ?>
						<tr class='all all{{$i}}'>
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td>Pengeluaran Dana</td>
							<td></td>
							<td></td>
							<td style="text-align:right">{{ number_format($kd->jumlah,null,null,".") }}</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endif
					@endforeach
					@foreach($bm as $mb)
						@if($mb->waktu == $w->waktu)
						<tr class='all all{{$i}}'>
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td>{{ $mb->bahan }}</td>
							<td></td>
							<td style="text-align:right">{{ $mb->jumlah }} {{ $mb->satuan }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						@endif
					@endforeach
					@foreach($bk as $kb)
						@if($kb->waktu == $w->waktu)
						<tr class='all all{{$i}}'>
							<td>{{ $wk }}</td>
							<?php $wk = ""; ?>
							<td>{{ $kb->bahan }}</td>
							<td></td>
							<td></td>
							<td></td>
							<td style="text-align:right">{{ $kb->jumlah }} {{ $kb->satuan }}</td>
							<td></td>
							<td></td>
						</tr>
						@endif
					@endforeach					
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
				<tr class="active all">           
					<td width="auto" colspan=7 style="text-align:right;font-size:large;font-weight:bold">Saldo Akhir</th>
					<td width="auto" style="text-align:right;font-size:large;font-weight:bold">{{ number_format($saldo,null,null,".") }}</th>
				</tr>
				<tr class="active all">           
					<td width="auto" colspan=7 style="text-align:right;font-size:medium;font-weight:bold">Bank</td>
					<td width="auto" style="text-align:right;font-size:medium;font-weight:bold">{{ number_format($saldobank[0]->bank,null,null,".") }}</td>
				</tr>
				<tr class="active all">           
					<td width="auto" colspan=7 style="text-align:right;font-size:medium;font-weight:bold">Cash</td>
					<td width="auto" style="text-align:right;font-size:medium;font-weight:bold">{{ number_format($saldo - ($saldobank[0]->bank),null,null,".") }}</td>
				</tr>
			</tbody>  
</table>
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
showHide('{{$urut}}');
</script>
<table width="100%">
<?php $bulan = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]; ?>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td width="60%">&nbsp;</td>
		<td width="auto" style="text-align:center">Jambi, <?php echo date("j")." ".$bulan[date("n")]." ".date("Y"); ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:center">Ketua Panitia Pembangunan Masjid Darussalam</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style="text-align:center">Ir. H. Syahrasaddin, M.Si</td>
	</tr>
</table>
