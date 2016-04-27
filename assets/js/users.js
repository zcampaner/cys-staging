/* Users JS for CRUD*/
$(document).ready(function() {
				
			$('#modal').hide();
			$("#add").click(function(){
				$('#modal').show();
				$("#edit_button").hide();
				$("#ed").hide();
			});
			$(".edit").click(function(){
				
				var login_name = { "login_name": $(this).closest('tr').find('td').attr('id') }
				$.ajax({
						method: "POST",
						url: "template_edit.php",
						data: login_name,
						dataType: "json"
				})
				.done(function( msg ) {
					console.log(msg[0]);
					$("#login_name").val( msg[0].login_name );
					$("#first_name").val( msg[0].first_name );
					$("#last_name").val( msg[0].last_name );
					$("#email").val( msg[0].email );
				});
				$("#modal").show();
				$("#add_button").hide();
			  	$("#ad").hide();
			});
			$('#edit_button').click(function(){
				var params = { "login_name": $('#login_name').val(), "password": $('#password').val(), "first_name": $('#first_name').val(), "last_name": $('#last_name').val(), "email": $('#email').val() }
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
					
				var params = { "login_name": $('#login_name').val(), "password": $('#password').val(), "first_name": $('#first_name').val(), "last_name": $('#last_name').val(), "email": $('#email').val() }
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

				var params = { "login_name": $(this).closest('tr').find('td').attr('id') };
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

