jQuery(function($){
	$('#filter').submit(function(){
		var filter = $('#filter');
		$.ajax({
			url:filter.attr('action'),
			data:filter.serialize(), // form data
			type:filter.attr('method'), // POST
			beforeSend:function(xhr){
				filter.find('button').text('필터중...'); // changing the button label
			},
			success:function(data){
				filter.find('button').text('필터 적용하기'); // changing the button label back
				$('#response').html(data); // insert data
			}
		});
		return false;
	});
});
