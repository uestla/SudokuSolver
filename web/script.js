
(function ($) {

	$(function () {

		var solve = $('#solve');
		var status = $('#status');
		var fields = $('#board input');


		resetStatus();


		solve.on('click', function (event) {
			event.preventDefault();

			var clues = {};
			fields.each(function (key) {
				clues[key] = $(this).val() !== '';
			});

			var start = new Date().getTime();

			$.ajax('solver.php', {
				type: 'GET',
				data: {
					values: getValues()
				},
				success: function (response) {
					if (response.indexOf('error ') === 0) {
						var errno = parseInt(response.substring(5));

						switch (errno) {
							case 1:
								error('Unsolvable :(');
								break;

							case 2:
								error('Invalid clues!');
								break;

							default:
								error('Unknown error.');
								break;
						}

					} else {
						var solution = response.split('');

						for (var i = 0, len = solution.length; i < len; i++) {
							var field = fields.eq(i);
							field.val(solution[i]);

							if (clues[i]) {
								field.addClass('clue');
							}
						}

						success('Solved in ' + ((new Date().getTime()) - start) + ' ms!');
					}
				}
			});
		});


		$('#clear').on('click', function (event) {
			fields.not('.clue').val('');
			fields.removeClass('clue');
			fields.first().trigger('focus');
			resetStatus();
		});


		fields.on('keydown keyup', function (event) {
			if (noMetaPressed(event) && (event.keyCode === 38 || event.keyCode === 40)) {
				event.preventDefault();
			}
		});


		fields.on('keydown', function (event) {
			var field = $(this);
			var code = event.keyCode;
			var max = fields.length - 1;
			var index = fields.index(field);

			if (noMetaPressed(event)) {
				switch (code) {
					case 13: // enter
						solve.trigger('click');
						return ;

					case 37: // left
						if (index - 1 >= 0) {
							index--;
						}

						break;

					case 38: // up
						if (index - 9 >= 0) {
							index -= 9;
						}
						
						break;

					case 39: // right
						if (index + 1 <= max) {
							index++;
						}
						
						break;

					case 40: // down
						if (index + 9 <= max) {
							index += 9;
						}
						
						break;

					default:
						var n = null;
						if (code >= 97 && code <= 105) {
							n = code - 96;

						} else if (code >= 49 && code <= 57) {
							n = code - 48;
						}

						if (n !== null && index + 1 <= max) {
							event.preventDefault();
							field.val(n);
							index++;

						} else {
							return ;
						}
				}
			}

			fields.eq(index).trigger('focus');

			var val = field.val();
			var pint = parseInt(val);
			field.val(val === '' || isNaN(pint) ? '' : Math.max(1, Math.min(9, pint)));
		});


		function getValues()
		{
			var values = [];

			fields.each(function (key) {
				var x = Math.floor(key / 9);
				var y = key % 9;

				if (typeof values[x] === 'undefined') {
					values[x] = [];
				}

				var value = $(this).val();
				values[x][y] = value.length ? parseInt(value) : null;
			});

			return values;
		}


		function error(message)
		{
			status.removeClass('success').addClass('error').text(message);
		}


		function success(message)
		{
			status.removeClass('error').addClass('success').text(message);
		}


		function resetStatus()
		{
			status.removeClass('error').removeClass('success').text('- ready -');
		}


		function noMetaPressed(event)
		{
			return !event.ctrlKey && !event.metaKey && !event.shiftKey && !event.altKey;
		}

	});

})(window.jQuery);
