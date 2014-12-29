Sudoku solver
=============

Usage
-----

```php
// load the script
require_once __DIR__ . '/Sudoku.php';

// create board
$sudoku = new Sudoku([
	[5,		NULL,	NULL,	4,		NULL,	6,		3,		2,		NULL],
	[2,		NULL,	NULL,	NULL,	NULL,	7,		NULL,	NULL,	NULL],
	[NULL,	NULL,	NULL,	NULL,	NULL,	3,		NULL,	4,		1],
	[NULL,	4,		NULL,	NULL,	NULL,	NULL,	6,		NULL,	NULL],
	[NULL,	NULL,	2,		NULL,	9,		NULL,	1,		NULL,	NULL],
	[NULL,	NULL,	1,		NULL,	NULL,	NULL,	NULL,	9,		NULL],
	[4,		2,		NULL,	6,		NULL,	NULL,	NULL,	NULL,	NULL],
	[NULL,	NULL,	NULL,	3,		NULL,	NULL,	NULL,	NULL,	4],
	[NULL,	6,		9,		1,		NULL,	2,		NULL,	NULL,	8],
]);

// print it
$sudoku->dump();

/* output:

+-------+-------+-------+
| 5 - - | 4 - 6 | 3 2 - |
| 2 - - | - - 7 | - - - |
| - - - | - - 3 | - 4 1 |
+-------+-------+-------+
| - 4 - | - - - | 6 - - |
| - - 2 | - 9 - | 1 - - |
| - - 1 | - - - | - 9 - |
+-------+-------+-------+
| 4 2 - | 6 - - | - - - |
| - - - | 3 - - | - - 4 |
| - 6 9 | 1 - 2 | - - 8 |
+-------+-------+-------+

*/

// solve it
$sudoku->solve();

// print the solution
$sudoku->dump();

/* output:

+-------+-------+-------+
| 5 1 7 | 4 8 6 | 3 2 9 |
| 2 3 4 | 9 1 7 | 8 5 6 |
| 8 9 6 | 5 2 3 | 7 4 1 |
+-------+-------+-------+
| 9 4 8 | 2 3 1 | 6 7 5 |
| 6 5 2 | 7 9 4 | 1 8 3 |
| 3 7 1 | 8 6 5 | 4 9 2 |
+-------+-------+-------+
| 4 2 3 | 6 5 8 | 9 1 7 |
| 1 8 5 | 3 7 9 | 2 6 4 |
| 7 6 9 | 1 4 2 | 5 3 8 |
+-------+-------+-------+

*/
```
