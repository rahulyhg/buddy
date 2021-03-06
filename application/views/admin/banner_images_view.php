<!-- Bread crumb -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-primary">Banners</h3> </div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>admin/clients">Home</a></li>
				<li class="breadcrumb-item active">Banners</li>
			</ol>
		</div>
	</div>
	<!-- End Bread crumb -->
	<!-- Container fluid  -->
	<div class="container-fluid">
		<!-- Start Page Content -->
		<div class="row">
			<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title" style="display: inline-block;">Banner images</h4>
					<!--<h6 class="card-subtitle">Data table example</h6>-->
					<button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#addBannerModal" data-backdrop="static" keyboard="false" onClick="addBanner()">Add New</button>
					<div class="table-responsive">
						<table id="myTable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="display: none;">tab22_id</th>
									<th>SL No.</th>
									<th>Image</th>
									<th>Description</th>
									<th>Added</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$i = 0;
                                    foreach($client_list as $key => $list) {
                                        $request_date = date('m-d-Y', strtotime($list['created']));
										
										$bnrImg = base_url()."images/no-image.png";
										if ($list['banner_image'] != '') {
											$bnrImg = base_url()."uploadImage/banner_image/".$list['banner_image'];
										}
										$i ++;
                                ?>
                                <tr class="" id="request_tr_<?=$list['id']?>">
									<td style="display: none;"><?=$list['id']?></td>
									<td><?=$i?></td>
                                    <td class="center">
										<div class="avatar">
                                            <a class="example-image-link" href="<?=$bnrImg?>" data-fancybox="banner-image-<?=$list['id']?>">
												<img src="<?=$bnrImg?>" style="height: 85px; width: 85px;">
											</a>
                                        </div>
									</td>
                                    <td class="center"> <?=$list['description']?> </td>
                                    <td class="center"> <?=$request_date?> </td>
                                    <td class="center" style="width:150px !important;">
										<div class="button-list1" style="overflow: hidden;white-space: nowrap;">
											<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addBannerModal" data-backdrop="static" keyboard="false" onClick="editBanner(<?=$list['id']?>)">
												<i class="fa fa-pencil" aria-hidden="true" title="View details"></i>Edit
											</button>
											
											<button type="button" class="btn btn-danger" onClick="deleteBanner(<?=$list['id']?>)">
												<i class="fa fa-trash" aria-hidden="true"></i>Delete
											</button>
										</div>
									</td>
                                </tr>
                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End PAge Content -->
</div>
<!-- End Container fluid  -->

<div class="modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="addBannerModal">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
			<form action="<?=base_url()?>admin/banners/addUpdateBanner" method="post" encType="multipart/form-data">
				<div class="modal-header">
				<h4 class="modal-title addorUpd">Add Banner</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:0; padding:0; font-size:25px;">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group col-md-12 float-left">
							<input type="hidden" class="form-control" name="cid" id="cid"/>
							<label for="fname">
								Image
							</label>
							<input type="file" class="form-control" name="banner_image" id="fname" required/>
							<img src="<?=base_url().'images/no-image.png'?>" id="fileImg" style="height: 85px; width: 85px; float:right;">
						</div>
						
						<div class="form-group col-md-12 float-left">
							<label for="lname">
								Description
							</label>
							<input type="text" class="form-control" name="description" id="desc" required/>
						</div>
						
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
	  </div>
	</div>
</div>

<script>
	var baseUrl = "<?=base_url()?>";
	function deleteBanner(id){
		if(confirm('Are you sure, you want to delete?')){
			$(".preloader").show();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: baseUrl + "api/v1/user/deleteBanner",
				data: {'id': id},
				success: function(resp) {
					if(resp.status){
						$("#myTable").dataTable().fnDestroy()
						$('#myTable').DataTable();
						$('#request_tr_'+id).remove();
					}
					$(".preloader").hide();
				},
				error : function(xhr, textStatus, errorThrown){
					console.log(xhr);
					$("#preloader").hide();
				}
			});
		}
	}
	
	function addBanner(){
		$('#fname').css({'width':'100%'});
		$('#fileImg').hide();
		$('.addorUpd').html('Add Banner');
	}
	
	function editBanner(id){
		$('#fname').css({'width':'50%'});
		$('.addorUpd').html('Edit Banner');
		$(".preloader").show();
		$.ajax({
			type: "POST",
			dataType: "json",
			url: baseUrl + "api/v1/user/fetchBannerDtls",
			data: {'id': id},
			success: function(resp) {
				if(resp.status){
					$('#cid').val(resp.response.id);
					var bnrImg = baseUrl+"images/no-image.png";
					if (resp.response.banner_image != '') {
						bnrImg = baseUrl+resp.response.banner_image;
					}
					$('#fileImg').prop('src', bnrImg).show();
					$('#desc').val(resp.response.description);
				}
				$(".preloader").hide();
			},
			error : function(xhr, textStatus, errorThrown){
				console.log(xhr);
				$("#preloader").hide();
			}
		});
	}
</script>