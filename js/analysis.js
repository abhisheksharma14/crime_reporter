function search(){
    var search_query = $("input[name='search_query']").val()
    if ($.trim(search_query).length < 3) {
        return false;
    }
    $("#search-btn").html("<i class='fa fa-spinner fa-pulse fa-fw'>");
    $.ajax({
        "url": baseUrl+"api.php?action=search",
        "type": "POST",
        "data": {query:search_query},
        dataType: 'json',
    })
    .done(function(res) {
        if (res.response == 1) {
            var dataSet = [];
            for (var i = 0; i < res.result.length; i++) {
                var resultSet = res.result[i];
                dataSet.push([resultSet.id, resultSet.name, resultSet.type, resultSet.status, resultSet.created_by, resultSet.created_date]);
            }
            $('#search-result-table').dataTable( {
                retrieve: true,
                data: dataSet,
                columns: [
                    { title: "ID" },
                    { title: "Name" },
                    { title: "Type" },
                    { title: "Status" },
                    { title: "Reported By" },
                    { title: "Date" },
                ]
            });
            $('#search-result-table').dataTable().fnClearTable();
            $('#search-result-table').dataTable().fnAddData(dataSet);
        }else{
            alert("No data found. try some other keywords.");
        }
    })
    .fail(function() {
    })
    .always(function() {
        $("#search-btn").html("Search &nbsp; &nbsp;<i class='fa fa-search'>");
    });
};


var table = $('#search-result-table').DataTable();     
$('#search-result-table tbody').on('click', 'tr', function () {
    var data = table.row( this ).data();
    if (data[2] == 'crime') {
        getCrime(data[0]);
    }else if(data[2] == 'criminal'){
        getCriminal(data[0]);
    }
} );