$(document).ready(function() {

	$("#findPeople").on('click', function() {
		var string = $("#searchString").val()
		var table = $("#people-result")

		$.ajax({
			headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
			url: '/friends/findFriends',
			data: {
				q: string
			},
			success: function(users) {

				if (users.error) {
					data = "!";
					$.notify({
        				icon: "add_alert",
				        message: "Search field cannot be empty"

				    },{
				        type: 'danger',
				        timer: 4000,
				        placement: {
				            from: 'top',
				            align: 'right'
				        }
				    });
				} else {
					var data = '<table class="table">' +
			                    '<thead class="text-primary">' +
				                  	'<tr>' +
					                    '<th>Name</th>' +
					                    '<th>Email</th>' +
					                    '<th>Action</th>' +
				                  	'</tr>' +
			                  	'</thead>' +
		                  	'<tbody>';

					for (var i = 0; i < users.users.length; i++) {
						data += '<tr>' +
			                        '<td>' + users.users[i].name + '</td>' +
			                        '<td>' + users.users[i].email +'</td>' +
			                        '<td id="' + users.users[i].id + '">' +
			                        	'<button class="addfriend pointer btn btn-sm btn-success">send request</button>' +
		                        	'</td>' +
	                      		'</tr>';
					}

					data += '</tbody>' +
	                    '</table>';

                    table.html(data)
				}
			}
		})
	})

	$(document).on('click', '.addfriend', function() {
		var id = $(this).parent().attr('id')
		var obj = $(this);
		obj.addClass('disabled');
        obj.html('<span class="fal fa-spin fa-circle-notch"></span> Sending request ...');
		$.ajax({
			headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
			method: 'GET',
			url: '/friends/sendRequest',
			data: {
				id: id
			},
			success: function(data){
				if (data.error) {
					$.notify({
        				icon: "add_alert",
				        message: data.error

				    },{
				        type: 'danger',
				        timer: 4000,
				        placement: {
				            from: 'top',
				            align: 'right'
				        }
				    });
				} else {
					swal({
						title: 'Done!',
						text: data.success,
						type: 'success',
						confirmButtonText: 'Sweet',
						confirmButtonClass: 'btn btn-success',
						buttonsStyling: false
					}).done();

					obj.removeClass('disabled addfriend');
        			obj.html('<span class="fal fa-check"></span> Request sent!');
				}
			}
		})
	})

	$(document).on('click', '.respondRequest', function() {
		var id = $(this).attr('id')
		var obj = $(this);
		var declineRequest = false;

		if ($(this).hasClass('declineRequest')) {
			declineRequest = true;
		}

		obj.addClass('disabled');

		$.ajax({
			headers: {
	          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
			method: 'GET',
			url: '/friends/respondRequest',
			data: {
				id: id,
				decline: declineRequest
			},
			success: function(data){
				if (data.error) {
					$.notify({
        				icon: "add_alert",
				        message: data.error
				    },{
				        type: 'danger',
				        timer: 4000,
				        placement: {
				            from: 'top',
				            align: 'right'
				        }
				    });
				} else {
					if (data.canceled) {
						swal({
							title: 'Done!',
							text: data.success,
							type: 'info',
							confirmButtonText: 'Alright',
							confirmButtonClass: 'btn btn-success',
							buttonsStyling: false
						}).then(function () {
							return location.reload();
						}).done();
					} else {
						swal({
							title: 'Done!',
							text: data.success,
							type: 'success',
							confirmButtonText: 'Fuck yeah!',
							confirmButtonClass: 'btn btn-success',
							buttonsStyling: false
						}).then(function () {
							return location.reload();
						}).done();
					}
				}
			}
		})
	})
});