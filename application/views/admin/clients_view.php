<!-- Bread crumb -->
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-primary">Clients</h3> </div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>admin/clients">Home</a></li>
				<li class="breadcrumb-item active">Clients</li>
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
					<h4 class="card-title">Clients List</h4>
					<!--<h6 class="card-subtitle">Data table example</h6>-->
					<div class="table-responsive m-t-40">
						<table id="myTable" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="display: none;">tab22_id</th>
									<th>Name</th>
									<th>Phone</th>
									<th>Address</th>
									<th>Verification Status</th>
									<!--<th>Platform</th>-->
									<th>License</th>
									<th>Joined</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                    foreach($client_list as $key => $list) {
                                        //$request_date = date('l jS F Y', strtotime($list['created']));
                                        $request_date = date('m-d-Y', strtotime($list['created']));
										
										$prfImg = base_url()."images/no-image.png";
										if( $list['profile_image'] != '' && (strpos($list['profile_image'], 'http://') !== false || strpos($list['profile_image'], 'https://') !== false) ){
											$prfImg = $list['profile_image'];
										} else if ($list['profile_image'] != '') {
											$prfImg = base_url()."uploadImage/client_profile_image/".$list['profile_image'];
										}
										
										$licnseImg = base_url()."images/no-image.png";
										if ($list['license_image'] != '') {
											$prfImg = base_url()."uploadImage/client_license_image/".$list['license_image'];
										}
										
                                ?>
                                <tr class="" id="request_tr_<?=$list['id']?>">
									<td style="display: none;"><?=$list['id']?></td>
                                    <td class="center">
										<div class="avatar">
                                            <a class="example-image-link" href="<?=$prfImg?>" data-fancybox="client-image-<?=$list['id']?>">
												<img src="<?=$prfImg?>" style="height: 85px; border-radius: 50%; width: 85px;">
											</a>
                                        </div>
										<p><?=($list['first_name'])?$list['first_name'].' '.$list['last_name']:''?></p>
										<p>Email: <?=($list['email'])?$list['email']:''?></p>
									</td>
                                    <td class="center"> <?=($list['phone'])?$list['phone']:''?> </td>
                                    <td class="center">
										<p>City: <?=($list['city'])?$list['city']:''?></p>
										<p>State: <?=($list['state'])?$list['state']:''?></p>
										<p>Country; <?=($list['country'])?$list['country']:''?></p>
									</td>
                                    <td class="center">
										<p>Email Verified: <?=$list['is_email_verified'] == '1' ? 'Yes' : 'No'?></p>
										<p>Phone Verified: <?=$list['is_phone_verified'] == '1' ? 'Yes' : 'No'?></p>
									</td>
                                    <!--<td class="center"> <?//=$list['register_from']?> </td>-->
                                    <td class="center">
										<div class="avatar">
											<a class="example-image-link" href="<?=$licnseImg?>" data-fancybox="client-license-<?=$list['id']?>">
												<img src="<?=$licnseImg?>" style="height: 85px; border-radius: 50%; width: 85px;">
											</a>
                                        </div>
									</td>
                                    <td class="center"> <?=$request_date?> </td>
                                    <td class="center" style="width:150px !important;">
										<div class="button-list1">
											<button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#editClientModal" data-backdrop="static" keyboard="false" onClick="editClient(<?=$list['id']?>)">Edit</button>
											<button type="button" class="btn btn-danger btn-flat" onClick="deleteClient(<?=$list['id']?>)">Delete</button>
										</button>
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

<div class="modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="editClientModal">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
			<form action="<?=base_url()?>admin/clients/updateClient" method="post" >
				<div class="modal-header">
				<h4 class="modal-title">Edit Client</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin:0; padding:0; font-size:25px;">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<div class="col-md-12">
						<div class="form-group col-md-6 float-left">
							<label for="fname">
								First Name
							</label>
							<input type="hidden" class="form-control" name="id" id="cid"/>
							<input type="text"  data-val="true" data-val-required="this is Required Field" class="form-control" name="first_name" id="fname" required/>
							<span class="field-validation-valid text-danger" data-valmsg-for="fname" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="lname">
								Last Name
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="last_name" id="lname" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="lname" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="email">
								Email
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="email" id="email" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="email" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="phone">
								Phone
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="phone" id="phone" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="phone" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="city">
								City
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="city" id="city" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="city" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="state">
								State
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="state" id="state" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="state" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							<label for="country">
								Country
							</label>
							<input type="text" data-val="true" data-val-required="this is Required Field" class="form-control" name="country" id="country" required/>
							<span class="field-validation-valid text-danger"  data-valmsg-for="country" data-valmsg-replace="true"></span>
						</div>
						
						<div class="form-group col-md-6 float-left">
							&nbsp;
						</div>
						
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
	  </div>
	</div>
</div>

<script>
	var baseUrl = "<?=base_url()?>";
	function deleteClient(id){
		if(confirm('Are you sure, you want to delete?')){
			$(".preloader").show();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: baseUrl + "api/v1/user/deleteClient",
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
	
	function editClient(id){
		$(".preloader").show();
		$.ajax({
			type: "POST",
			dataType: "json",
			url: baseUrl + "api/v1/user/fetchClientDtls",
			data: {'id': id},
			success: function(resp) {
				if(resp.status){
					$('#cid').val(resp.response.id);
					$('#fname').val(resp.response.first_name);
					$('#lname').val(resp.response.last_name);
					$('#email').val(resp.response.email);
					$('#phone').val(resp.response.phone);
					$('#city').val(resp.response.city);
					$('#state').val(resp.response.state);
					$('#country').val(resp.response.country);
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