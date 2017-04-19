function getCrime(crimeId){
	$.ajax({
		url: '../api.php?action=get_crime',
		type: 'POST',
		dataType: 'json',
		data: {id: crimeId},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
		console.log("complete");
	});
};


function deleteCrime(crimeId){
	$.ajax({
		url: '../api.php?action=delete_crime',
		type: 'POST',
		dataType: 'json',
		data: {id: crimeId},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
		console.log("complete");
	});
};

function getCriminal(criminalId){
	$.ajax({
		url: '../api.php?action=get_criminal',
		type: 'POST',
		dataType: 'json',
		data: {id: criminalId},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
		console.log("complete");
	});
};

function deleteCriminal(criminalId){
	$.ajax({
		url: '../api.php?action=delete_criminal',
		type: 'POST',
		dataType: 'json',
		data: {id: criminalId},
	})
	.done(function(data) {
		console.log(data);
	})
	.fail(function(err) {
		console.log(err);
	})
	.always(function(data) {
		console.log("complete");
	});
};