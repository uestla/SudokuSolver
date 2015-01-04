<?php require_once __DIR__ . '/../Sudoku.php'; ?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sudoku solver</title>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.1/paper/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo mtime('style.css'); ?>">
<?php if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1') { ?>		<script type="text/javascript">(function(a,e,f,g,b,c,d){a.GoogleAnalyticsObject=b;a[b]=a[b]||function(){(a[b].q=a[b].q||[]).push(arguments)};a[b].l=1*new Date;c=e.createElement(f);d=e.getElementsByTagName(f)[0];c.async=1;c.src=g;d.parentNode.insertBefore(c,d)})(window,document,"script","//www.google-analytics.com/analytics.js","ga");ga("create","UA-58061262-1","auto");ga("send","pageview");</script>
<?php } ?>
	</head>
	
	<body>

		<div class="container">
			<div class="page-header">
				<h1>
					<a href="">Sudoku solver</a>
				</h1>
			</div>

			<div class="row">
				<div class="col-sm-5 text-center">
					<table id="board">
<?php for ($i = 0; $i < Sudoku::SIZE; $i++) { ?>
						<tr>
<?php for ($j = 0; $j < Sudoku::SIZE; $j++) { $classes = array(); if (($i + 1) % 3 === 0) $classes[] = 'bbt'; if (($j + 1) % 3 === 0) $classes[] = 'brg'; ?>
							<td<?php if (count($classes)) { ?> class="<?php echo implode(' ', $classes); ?>"<?php } ?>>
								<input type="number" name="v[<?php echo $i; ?>][<?php echo $j; ?>]"
									value="" min="1" max="<?php echo Sudoku::SIZE; ?>"<?php if ($i === 0 && $j === 0) { ?> autofocus<?php } ?>>
							</td>
<?php } ?>
						</tr>
<?php } ?>
					</table>

					<div class="row">
						<div class="col-sm-1"></div>

						<div class="col-sm-4">
							<div>
								<button id="solve" class="btn btn-lg btn-block btn-primary">
									<span class="glyphicon glyphicon-cog"></span>
									Solve
								</button>
							</div>

							<div>
								<button id="clear" class="btn btn-sm btn-block btn-warning">
									<span class="glyphicon glyphicon-remove"></span>
									Clear
								</button>
							</div>
						</div>

						<div class="col-sm-1"></div>

						<div class="col-sm-6">
							<span id="status"></span>
						</div>
					</div>
				</div>

				<div class="col-sm-7">
					<h2>How to use</h2>

					<ul class="lead">
						<li>fill in clues</li>
						<li>use arrows to quickly switch between fields</li>
						<li>hit the &quot;Solve&quot; button or Enter</li>
						<li>&hellip;</li>
						<li>PROFIT !!!</li>
					</ul>

					<h3>Links</h3>

					<ul class="lead">
						<li>author: <a href="http://kesspess.1991.cz">kesspess</a></li>
						<li>sources on <a href="https://github.com/uestla/SudokuSolver">GitHub</a></li>
						<li>bootswatch theme <a href="http://bootswatch.com/paper/">Paper</a></li>
					</ul>
				</div>
			</div>
		</div>


		<script src="//code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
		<script src="<?php echo mtime('script.js'); ?>" type="text/javascript"></script>

	</body>
</html>

<?php

function mtime($file)
{
	$mtime = @filemtime(__DIR__ . '/' . $file);
	return $mtime === FALSE ? $file : $file . '?' . $mtime;
}
