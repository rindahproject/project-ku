<!doctype html>
<html class="no-js" lang="en">

<?php 
    include '../dbconnect.php';
    include 'conect.php';
    include 'header.php';

    if(isset($_POST['update'])){
        $idx = $_POST['kode'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $pic = $_POST['pic'];
        $telepon = $_POST['telepon'];
        $email = $_POST['email'];
		$jml = $_POST['jml'];
		$tgl_marketing = $_POST['tgl_marketing'];
		$hasil_marketing = $_POST['hasil_marketing'];
		$jml_potensial = $_POST['jml_potensial'];
		$keterangan = $_POST['keterangan'];
		$tele_ullang = $_POST['tele_ullang'];
		


        $lihatdata = mysqli_query($conn,"select * from sdata-real where idx='$kode'"); //lihat stock barang itu saat ini
        $datanya = mysqli_fetch_array($lihatdata); //ambil datanya
        $stockskrg = $datanya['data'];//jumlah stocknya skrg

        $lihatdataskrg = mysqli_query($conn,"select * from data-real where id='$id'"); //lihat qty saat ini
        $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
        $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

        if($jumlah >= $qtyskrg){
            //ternyata inputan baru lebih besar jumlah masuknya, maka tambahi lagi stock barang
            $hitungselisih = $jumlah-$qtyskrg;
            $tambahistock = $stockskrg+$hitungselisih;

            $queryx = mysqli_query($conn,"update sstock_brg set stock='$tambahidata' where idx='$idx'");
            $updatedata1 = mysqli_query($conn,"update sbrg_masuk set tgl='$tanggal',jumlah='$jumlah',keterangan='$keterangan',disetujui='$disetujui' where id='$id'");
            
            //cek apakah berhasil
            if ($updatedata1 && $queryx){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= masuk.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= masuk.php'/> ";
                };

        } else {
            //ternyata inputan baru lebih kecil jumlah masuknya, maka kurangi lagi stock barang
            $hitungselisih = $qtyskrg-$jumlah;
            $kurangistock = $stockskrg-$hitungselisih;

            $query1 = mysqli_query($conn,"update sstock_brg set stock='$kurangistock' where idx='$idx'");

            $updatedata = mysqli_query($conn,"update sbrg_masuk set tgl='$tanggal', jumlah='$jumlah', keterangan='$keterangan', disetujui='$disetujui' where id='$id'");
            
            //cek apakah berhasil
            if ($query1 && $updatedata){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= masuk.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= masuk.php'/> ";
                };

        };


        
    };

    if(isset($_POST['hapus'])){
        $id = $_POST['id'];
        $idx = $_POST['idx'];

        $lihatstock = mysqli_query($conn,"select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
        $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
        $stockskrg = $stocknya['stock'];//jumlah stocknya skrg

        $lihatdataskrg = mysqli_query($conn,"select * from sbrg_masuk where id='$id'"); //lihat qty saat ini
        $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
        $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

        $adjuststock = $stockskrg-$qtyskrg;

        $queryx = mysqli_query($conn,"update sstock_brg set stock='$adjuststock' where idx='$idx'");
        $del = mysqli_query($conn,"delete from sbrg_masuk where id='$id'");

        
        //cek apakah berhasil
        if ($queryx && $del){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
              </div>
            <meta http-equiv='refresh' content='1; url= dara.php'/>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
              </div>
             <meta http-equiv='refresh' content='1; url= masuk.php'/> ";
            }
    };
	?>

<body>
<style>
#dataTable3 {
  table-layout: fixed;
  width: 100% !important;
}
#dataTable3 td,
#dataTable3 th{
  width: auto !important;
  white-space: normal;
  text-overflow: ellipsis;
  overflow: hidden;
}
</style>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <?php include 'sidebar.php'; ?>
        <!-- main content area start -->
        <div class="main-content">
            <?php include 'navbar.php'; ?>
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.php">Home</a></li>
                                <li><span>Barang Pesanan</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right" style="color:black; padding:0px;">
                            <img src="logobpjs.jpg" width="220px" class="user-name dropdown-toggle" data-toggle="dropdown"\>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
               
                <!-- market value area start -->
                <div class="row mt-5 mb-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-sm-flex justify-content-between align-items-center">
									<h2>Data Dara
									<button style="margin-bottom:30px" data-toggle="modal" data-target="#myModal" class="btn btn-info col-md-2"><span class="glyphicon glyphicon-plus"></span>Tambah</button>
                                </div>
                                <div class="market-status-table mt-4">
                                    <div class="table-responsive">
										 <table id="dataTable3" class="col-sm-12 table table-hover"><thead class="thead-dark" width="100%">
											<tr>
												<th width="1%">No</th>
												<th width="5%">Kode Bu</th>
												<th width="5%">Nama Bu</th>
												<th width="5%">Alamat</th>
												<th width="5%">Nama PIC</th>
												<th width="5%">Telepon</th>
												<th width="5%">Email</th>
												<th width="5%">Jumlah Peserta</th>
												<th width="5%">Tgl marketing</th>
												<th width="5%">Hasil Marketing</th>
												<th width="5%">Jumlah potensial</th>
												<th width="5%">keterangan</th>
												<th width="5%">Tele Ulang</th>
												<th width="5%">Opsi</th>
											</tr></thead><tbody>
											<?php 
											$brg=mysqli_query($conn,"SELECT * from sbrg_masuk sb, sstock_brg st where st.idx=sb.idx order by sb.id DESC");
											$no=1;
											while($b=mysqli_fetch_array($brg)){
                                                $idb = $b['idx'];
                                                $id = $b['id'];

												?>
												
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php $tanggals=$b['tgl']; echo date("d-M-Y", strtotime($tanggals)) ?></td>
													<td><?php echo $b['kode'] ?></td>
													<td><?php echo $b['nama'] ?></td>
													<td><?php echo $b['alamat'] ?></td>
													<td><?php echo $b['pic'] ?></td>
													<td><?php echo $b['telepon'] ?></td>
													<td><?php echo $b['email'] ?></td>
													<td><?php echo $b['jml'] ?></td>
													<td><?php echo $b['tgl_markrting'] ?></td>
													<td><?php echo $b['hsl_markrting'] ?></td>
													<td><?php echo $b['jml_potensial'] ?></td>
													<td><?php echo $b['keterangan'] ?></td>
													<td><?php echo $b['tele_ullang'] ?></td>
													<td><?php echo $b['opsi '] ?></td>
													
													
													
                                                    <td><button data-toggle="modal" data-target="#edit<?=$id;?>" class="btn btn-warning">E</button> <button data-toggle="modal" data-target="#del<?=$id;?>" class="btn btn-danger">D</button></td>
												</tr>

                                                <!-- The Modal -->
                                                <div class="modal fade" id="edit<?=$id;?>">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Edit Data</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">

                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo $b['tgl'] ?>">
                                                            
                                                            <label for="nama">Kode Bu</label>
                                                            <input type="text" id="kode" name="kode" class="form-control" value="<?php echo $b['kode'] ?> <?php echo $b['nama'] ?> <?php echo $b['pic'] ?>" disabled>

                                                            <label for="ukuran">Nama Bu</label>
                                                            <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $b['nama'] ?>" disabled>

                                                            <label for="jumlah">Alamat</label>
                                                            <input type="text" id="alamat" name="alamat" class="form-control" value="<?php echo $b['alamat'] ?>">
															
															<label for="penerima">Nama PIC</label>
                                                            <input type="text" id="pic" name="pic" class="form-control" value="<?php echo $b['pic'] ?>">

                                                            <label for="keterangan">Telepon</label>
                                                            <input type="text" id="telepon" name="telepon" class="form-control" value="<?php echo $b['telepon'] ?>"> 
															
															<label for="disetujui">Email</label>
                                                            <input type="text" id="email" name="email" class="form-control" value="<?php echo $b['email'] ?>">
															
															<label for="disetujui">Jumlah Peserta</label>
                                                            <input type="text" id="jml" name="jml" class="form-control" value="<?php echo $b['jml'] ?>">
															
															<label for="disetujui">Tgl Marketing</label>
                                                            <input type="text" id="tgl_marketing" name="tgl_marketing" class="form-control" value="<?php echo $b['tgl_marketing'] ?>">
															
															<label for="disetujui">Hasil Marketing</label>
                                                            <input type="text" id="hsl_marketing" name="hsl_marketing" class="form-control" value="<?php echo $b['hsl_marketing'] ?>">
															
															<label for="disetujui">Jumlah Potensial</label>
                                                            <input type="text" id="jml_pontensial" name="jml_potensial" class="form-control" value="<?php echo $b['jml_potensial'] ?>">
															
															<label for="disetujui">Keterangan</label>
                                                            <input type="text" id="keterangan" name="keterangan" class="form-control" value="<?php echo $b['keterangan'] ?>">
															
															<label for="disetujui">Tele Ulang</label>
                                                            <input type="text" id="tele_ullang" name="tele_ullang" class="form-control" value="<?php echo $b['tele_ullang'] ?>">

                                                            <input type="hidden" name="id" value="<?=$id;?>">
                                                            <input type="hidden" name="idx" value="<?=$idb;?>">
                                                            
                                                            </div>
                                                            
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success" name="update">Save</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>



                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="del<?=$id;?>">
                                                        <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <form method="post">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang <?php echo $b['nama']?> - <?php echo $b['jenis']?> - <?php echo $b['ukuran']?></h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                            Apakah Anda yakin ingin menghapus barang ini dari daftar stock  masuk?
                                                            <br>
                                                            *Stock barang akan berkurang
                                                            <input type="hidden" name="id" value="<?=$id;?>">
                                                            <input type="hidden" name="idx" value="<?=$idb;?>">
                                                            </div>
                                                            
                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                                            </div>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>


												<?php 
											}
											?>
										</tbody>
										</table>
                                    </div>
									<a href="exportbrgmsk.php" target="_blank" class="btn btn-info">Export Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              
                
                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>RIKI ADITIANTORO</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
	
	<!-- modal input -->
			<div id="myModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Input Pesanan</h4>
						</div>
						<div class="modal-body">
							<form action="barang_masuk_act.php" method="post">
								<div class="form-group">
									<label>Tanggal</label>
									<input name="tanggal" type="date" class="form-control">
								</div>
								<div class="form-group">
									<label>Nama Barang</label>
									<select name="barang" class="custom-select form-control">
									<option selected>Pilih barang</option>
									<?php
									$det=mysqli_query($conn,"select * from sstock_brg order by nama ASC");
									while($d=mysqli_fetch_array($det)){
									?>
										<option value="<?php echo $d['idx'] ?>"><?php echo $d['nama'] ?> <?php echo $d['jenis'] ?> <?php echo $d['merk'] ?>, Uk. <?php echo $d['ukuran'] ?></option>
										<?php
								}
								?>
									</select>
								</div>
								<div class="form-group">
									<label>Jumlah</label>
									<input name="qty" type="number" min="1" class="form-control" placeholder="Qty">
								</div>
								<div class="form-group">
									<label>Pemesan</label>
									<input name="pemesan" type="text" class="form-control" placeholder="Pemesan barang">
								</div>
								<div class="form-group">
									<label>Keterangan</label>
									<input name="ket" type="text" class="form-control" placeholder="Keterangan">
								</div>
								
								<div class="form-group">
									<label>Disetujui</label>
									<input name="disetujui" type="text" class="form-control" placeholder="disetujui">
								</div>
							
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
								<input type="submit" class="btn btn-primary" value="Simpan">
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>

	<script>
		$(document).ready(function() {
		$('input').on('keydown', function(event) {
			if (this.selectionStart == 0 && event.keyCode >= 65 && event.keyCode <= 90 && !(event.shiftKey) && !(event.ctrlKey) && !(event.metaKey) && !(event.altKey)) {
			   var $t = $(this);
			   event.preventDefault();
			   var char = String.fromCharCode(event.keyCode);
			   $t.val(char + $t.val().slice(this.selectionEnd));
			   this.setSelectionRange(1,1);
			}
		});
	});
	
	$(document).ready(function() {
    $('#dataTable3').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ],
		"autoWidth": false,
		"aoColumnDefs": [
			{ "width": "1%", "targets": [0] },
			{ "width": "8%", "targets": [1, 3, 4, 5] }
			],
    } );
	} );
	</script>

    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
	<!-- Start datatable js -->
	 <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
	
</body>

</html>
