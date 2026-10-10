<?php  if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
	echo "
<div class='list-frame'>
	<div>
	    <div class='top-frame'>
		    <h2 class='artikel-judul text-title mt0 mb0'><strong>Arsip Kabar Desa ".$desa["nama_desa"]."</strong></h2>
		</div>
		<div class='table-responsive'>";
		if(count($farsip)>0){
			echo "
		<table class='table table-bordered table-striped'>
				<thead>
					<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Judul Artikel</th>
					<th>Kategori</th>
					<th>dibaca</th>
					</tr>
				</thead>
				<tbody>";
				foreach($farsip AS $data){
	            	$url = site_url('artikel/'.buat_slug($data));
					echo "
					<tr>
					<td>".$data["no"]."</td>
					<td>".tgl_indo($data['tgl_upload'])."</td>
					<td><a href='$url'>".$data["judul"]."</a></td>
					<td>".$data["kategori"]."</td>
					<td>".$data["hit"]."</td>
					</tr>
					";
				}
				echo "
				</tbody>
			</table>
			";

		}else{
			echo "Belum ada arsip konten web.";
		}

			echo "
		</div>";
		if(count($farsip)>0){
			echo "
	       <div class='box-footer' align='center'>
		        <ul class='pagination post-pagination text-center'>";
				if($paging->start_link){
					echo "<li><a href=\"".site_url("arsip/$paging->start_link")."\" title=\"Halaman Pertama\" title=\"Halaman Pertama\" class=\"waves-effect waves-light\"><i class=\"fa fa-angle-double-left\"></i>&nbsp;</a></li>";
				}

                $paging_range = 2;
		        $start_paging = max($paging->start_link, $p - $paging_range);
		        $end_paging = min($paging->end_link, $p + $paging_range);
		        $pages = range($start_paging, $end_paging);
		        foreach($pages as $i) {
			    $strC = ($p == $i)? "class=\"active\"":"";
				echo "<li ".$strC."><a href=\"".site_url("arsip/$i" . $paging->suffix)."\" title=\"Halaman ".$i."\" class=\"waves-effect waves-light\">".$i."</a></li>";
		        }

				if($paging->end_link){
					echo "<li><a href=\"".site_url("arsip/$paging->end_link")."\" title=\"Halaman Terakhir\" class=\"waves-effect waves-light\"><i class=\"fa fa-angle-double-right\"></i>&nbsp;</a></li";
				}
					echo "";
				echo "
				</ul>
			</div>
			";
		}
		echo "
	</div>
	</div>
	";
?>

