$(function(){
	// Creates the element for the alert
	var loading = $('<span class="loading"></span>');
	loading.insertAfter($('#persist'));

	$('#persist').click(function(){
		var me = $(this);
		loading.html('Aguarde, buscando dados...');
		loading.removeClass('error sucess');
		$.get( "persist.php", function(data) {
		  loading.addClass('sucess');
		  loading.html(data.message);
		},'json')
		.fail(function(data) {
		  loading.addClass('error');
		  loading.html(data.responseJSON.message);
		});
	});
});