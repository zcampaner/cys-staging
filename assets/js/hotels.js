/* Users JS for CRUD*/
$(document).ready(function() {
				
			$('#modal').hide();
			$("#add").click(function(){
				$('#modal').show();
				$("#edit_button").hide();
				$("#ed").hide();
			});
			$(".edit").click(function(){
				
				var hotel_code = { "hotel_code": $(this).closest('tr').find('td').attr('id') }
				$.ajax({
						method: "POST",
						url: "template_edit.php",
						data: hotel_code,
						dataType: "json"
				})
				.done(function( msg ) {
					console.log(msg[0]);
					$("#hotel_code").val( msg[0].hotel_code );
					$("#hotel").val( msg[0].hotel);
					$("#status").val( msg[0].status );
					$("#chain_code").val( msg[0].chain_code);
				});
				$("#modal").show();
				$("#add_button").hide();
			  	$("#ad").hide();
			});
			$('#edit_button').click(function(){
				var params = { "hotel_code": $('#hotel_code').val(), "hotel": $('#hotel').val(), "status": $('#status').val(), "chain_code": $('#chain_code').val()}
				$.ajax({
					method: "POST",
					url: "edit_file.php",
					data: params					
				})
				.done(function( msg ) {
					if(msg > 0){
						alert('Record updated successfully');
						location.reload();
					}else {
						alert('FAILED!');
					}
						
				});
			});
			$('#add_button').click(function(){
					
				var params = {"hotel_code": $('#hotel_code').val(), "hotel": $('#hotel').val(), "status": $('#status').val(), "chain_code": $('#chain_code').val()}
				$.ajax({
					method: "POST",
					url: "add_file.php",
					data: params					
				})
				.done(function( msg ) {
					alert('New record added');
					location.reload();
				});
			});	
			$('.delete').click(function(){

				var params = { "hotel_code": $(this).closest('tr').find('td').attr('id') };
				var txt;
				var r = confirm("Are you sure you want to delete record?");
					if (r == true) {
						$.ajax({
						method: "POST",
						url: "delete_file.php",
						data: params          
					})
					.done(function( msg ) {
						if(msg > 0){
							alert('Deleted record successfully');
							location.reload();
						}else {
							alert('Cancel');
						}
					});
				}
				
			})
		});


