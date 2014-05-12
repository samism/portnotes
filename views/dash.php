<?php

function newNotebook(){

}



?>

<script src="js/dash.js"></script>

<a id="logout" href="index.php?logout">Logout</a>
<h1 id="notebooks-heading">My Notebooks</h1>

<!-- <section id="options">
	<ul>
		<li><a href="">Create New</a></li>
	</ul>
</section> -->

<section id="dash">
	<?php
		$subjects = array('+');
		array_push($subjects, 'chemistry', 'physics', 'calculus', 'java', 'c++', 'calculus 2', 'photography', 'drafting',
					'computer science', 'CAD', 'psychology', 'anatomy');

		for($i = 0; $i < count($subjects); $i++){
			echo 
				'<div title="' . ($i === 0 ? 'Add a new notebook' :  'Click to view note pages!') . '" class="notebook ' . ($i === 0 ? 'new' : $subjects[$i]) . '">
						<span>' . $subjects[$i] . '</span>
				</div>';
		}

	?>

	<div id="menu">
		<h4>Note pages | <a id="new" href="note.php?new&notebook=">New</a></h4>
		<ul>
			<?php
				$notepages = array('periodic table', 'atoms', 'properties of water', 'etc', 'etc');

				for($i = 0; $i < count($notepages); $i++){
					echo '<li><a class="view" href="note.php?&page=' . $notepages[$i] . '&notebook=">' . $notepages[$i] . '</a></li>';
				}

			?>
		</ul>
	</div>
</section>