function getCrime(crimeId){
	$.ajax({
		url: baseUrl+'api.php?action=get_crime',
		type: 'POST',
		dataType: 'json',
		data: {id: crimeId},
	})
	.done(function(data) {
		if (data.response == 0) {
			alert(data.message);
		}else{
			$("#crime-details").modal('show');
			$("#crime-details .modal-title span").html(data.crime.name);
			$("#crime-details .modal-title small").html(data.crime.created_date);
			var crimeImages = data.crime.images.split(",");
			var crimeImageOl  = $("#crime-image-carousel ol.carousel-indicators");
			var crimeImageInner  = $("#crime-image-carousel .carousel-inner");
			$(crimeImageOl).html("");
			$(crimeImageInner).html("");
			for (var i = 0; i <= crimeImages.length - 1; i++) {
				var imageLi = '<li data-target="#crime-image-carousel" data-slide-to="'+i+'" class="active"></li>';
				var imgDiv = '<div class="item active"><img src="../uploads/'+crimeImages[i]+'" alt="Chania" width="380"></div>';
				if (i!=0) {
					imageLi = '<li data-target="#crime-image-carousel" data-slide-to="'+i+'"></li>';
					imgDiv = '<div class="item"><img src="../uploads/'+crimeImages[i]+'" alt="" width="380"></div>';
				}
				$(crimeImageOl).append(imageLi);
				$(crimeImageInner).append(imgDiv);
			}
			$("#crime-data .description").html("<b>Description: </b> "+data.crime.description);
			var crNames = (data.crime.criminal_names)?data.crime.criminal_names:"Not mapped";
			$("#crime-data .criminals").html("<b>Criminals: </b> "+crNames);
			$("#crime-data .type").html("<b>Type: </b> "+data.crime.type);
			$("#crime-data .reported-by").html("<b>Reported By: </b> "+data.crime.reported_by);
			$("#crime-data .status").html("<b>Status: </b> "+data.crime.status);
			$("#crime-data .tags").html("<b>Tags: </b> "+data.crime.tags);
		}
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
	});
};

function editCrime(crimeId){
	$.ajax({
		url: baseUrl+'api.php?action=get_crime',
		type: 'POST',
		dataType: 'json',
		data: {id: crimeId},
	})
	.done(function(data) {
		if (data.repsonse == 0) {
			alert(data.message);
			return;
		}
		$("#update-crime form input[name='crime_id']").val(crimeId);
		$("#update-crime form input[name='name']").val(data.crime.name);
		$("#update-crime form input[name='type']").val(data.crime.type);
		$("#update-crime form textarea[name='description']").val(data.crime.description);
		$("#update-crime form input[name='occured_on']").val(data.crime.created_date);
		$("#update-crime").modal("show");
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function() {
	});
};

function deleteCrime(crimeId){
	$.ajax({
		url: baseUrl+'api.php?action=delete_crime',
		type: 'POST',
		dataType: 'json',
		data: {id: crimeId},
	})
	.done(function(data) {
		if (data.response != 1 ) {
			alert("Could not be delated. Try again.");
		}else{
			window.location.reload();
		}
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
	});
};

function getCriminal(criminalId){
	$.ajax({
		url: baseUrl+'api.php?action=get_criminal',
		type: 'POST',
		dataType: 'json',
		data: {id: criminalId},
	})
	.done(function(data) {
		if (data.response == 0) {
			alert(data.message);
		}else{
			$("#criminal-details").modal('show');
			$("#criminal-details .modal-title span").html(data.criminal.name);
			$("#criminal-details .modal-title small").html(data.criminal.created_date);
			var criminalImages = data.criminal.images.split(",");
			var criminalImageOl  = $("#criminal-image-carousel ol.carousel-indicators");
			var criminalImageInner  = $("#criminal-image-carousel .carousel-inner");
			$(criminalImageOl).html("");
			$(criminalImageInner).html("");
			for (var i = 0; i <= criminalImages.length - 1; i++) {
				var imageLi = '<li data-target="#criminal-image-carousel" data-slide-to="'+i+'" class="active"></li>';
				var imgDiv = '<div class="item active"><img src="../uploads/'+criminalImages[i]+'" alt="Chania" width="380"></div>';
				if (i!=0) {
					imageLi = '<li data-target="#criminal-image-carousel" data-slide-to="'+i+'"></li>';
					imgDiv = '<div class="item"><img src="../uploads/'+criminalImages[i]+'" alt="" width="380"></div>';
				}
				$(criminalImageOl).append(imageLi);
				$(criminalImageInner).append(imgDiv);
			}
			$("#criminal-data .description").html("<b>Description: </b> "+data.criminal.description);
			$("#criminal-data .address").html("<b>Crimes: </b> "+data.criminal.address);
			$("#criminal-data .status").html("<b>Type: </b> "+data.criminal.status);
			$("#criminal-data .reported-by").html("<b>Reported By: </b> "+data.criminal.created_by);
			$("#criminal-data .status").html("<b>Status: </b> "+data.criminal.status);
			$("#criminal-data .tags").html("<b>Tags: </b> "+data.criminal.tags);
		}
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
	});
};

function editCriminal(criminalId){
	$.ajax({
		url: baseUrl+'api.php?action=get_criminal',
		type: 'POST',
		dataType: 'json',
		data: {id: criminalId},
	})
	.done(function(data) {
		if (data.repsonse == 0) {
			alert(data.message);
			return;
		}
		$("#update-criminal form input[name='criminal_id']").val(criminalId);
		$("#update-criminal form input[name='name']").val(data.criminal.name);
		$("#update-criminal form input[name='email']").val(data.criminal.email);
		$("#update-criminal form textarea[name='description']").val(data.criminal.description);
		$("#update-criminal form textarea[name='address']").val(data.criminal.address);
		$("#update-criminal form select[name='status'] option").each(function(index, el) {
			if (this.value == data.criminal.status) {
				$(this).attr('selected', 'selected');
			}	
		});
		$("#update-criminal").modal("show");
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function() {
	});

}

function deleteCriminal(criminalId){
	$.ajax({
		url: baseUrl+'api.php?action=delete_criminal',
		type: 'POST',
		dataType: 'json',
		data: {id: criminalId},
	})
	.done(function(data) {
		if (data.response != 1 ) {
			alert("Could not be delated. Try again.");
		}else{
			window.location.reload();
		}
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
		console.log("complete");
	});
};

$(document).ready(function() {
    $('.multiselect-dropdown').multiselect({
        enableFiltering: true,
        filterPlaceholder: 'Type and search...'
    });
});