function processURLS(){
	$urls = $("#urls_to_process").val();
	$urls = $urls.split(",");
	$urls = JSON.stringify($urls);
	console.log($urls);
	$.ajax({
		  method: "POST",
		  url: "/processURls",
		  data: { urlsToProcess: $urls}
		})
		  .done(function( data ) {
			  var obj = JSON.parse(data);
			  displayResults(obj);
		  })
		  
}

function displayResults(obj){
	var table = '<table class="table"><thead><tr><th scope="col">URL</th><th scope="col">IP Address</th></tr></thead><tbody>';
	var row = '';
	for (var key in obj) {
		row ='<tr><td><a href="'+key+'">'+key+'</a></td><td>IP Addy</td></tr>';
	    table += row;
	}
	table +='</tbody></table>';
	console.log(table);
	$("#myDNSResults").html(table);
}