
function update(url,element){

	$.get(url,function(data){
		element.html($(data));
	});

	var timer = setInterval(function(){
		 $.get(url,function(data){
				element.html($(data));
		 	});
	},10000);
}