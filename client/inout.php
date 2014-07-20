<?php include('header.php'); ?>
<!-- 
	Have header include top <body> tag
	Footer includes bottom <body> tag
	We can then just fill in the middle!
-->
<body>
	<style>
	ul {
		list-style-type: none;
	}
	</style>
	<form>
		<button id="add_btn" class="btn">Add</button>
		<ul id="inoutlist">
	              <li class="inout">
	              	<input type="text" class="in" placeholder="Input">
	              	<input type="text" class="out" placeholder="Output">
	              </li>
	    </ul>
	    <button type="submit" class="btn">Submit</button>
	</form>

	<script src="js/amalgation.js" type="text/javascript"></script>
	<script>

		$('#add_btn').click(function(e) {
			e.preventDefault();
			var clone = $('.inout:first').clone();
			clone.children().val("");
            clone.append('<button type="button" class="btn remove_button">Remove</button>');
			$('#inoutlist').append(clone);

		});

        $('#inoutlist').on("click", ".remove_button", function(e) {
            $(this).parent().remove();
        });


		$('form').submit(function(e) {
			
			e.preventDefault();
			var acc = [];
			var answer;

			$('ul .inout').each(function(idx) {
				var input = $(this).find(".in");
				var output = $(this).find(".out");

				answer = {
					answer_key: input.val(),
					answer_value: output.val(),
					correct: true
				}

				acc.push(answer);
			});
			console.log(acc);
		});

	</script>
</body>
</html>
