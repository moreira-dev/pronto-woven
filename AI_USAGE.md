# AI Usage

The main IDE used for this project was PhpStorm (Jetbrains).

AI assistant was used throughout for autocompletion and targetted code generation.

The Air IDE plugin was also used sporadically for agentic coding for specific features. Sessions are available in the `ai-sessions/` folder.

Model used was ChatGPT Sol with medium thinking.

## Pushbacks

I found ChatGPT Sol to give low quality code quite often (I blame my poor prompting), which was a bit disappointing coming from using Claude extensively in the past.

For most sessions, I modified the generated code by hand but I consider most of the output to be a good starting point.

Some examples of output that needed to be changed:

- [Function names](ai-sessions/20261026_set-up-phpunit-and-php-cs-fixer.md) for tests were initially unhelpful. After providing a consistent convention, the subsequent tests created by GPT were of good quality
- [Test generation](ai-sessions/20261027_add-property-and-player-tests.md) was verbose and code was not reusable. It took a few prompts to extract the createProperty function and make it easy for tests to use it
- Asking it to [output a json](ai-sessions/20261027_add-docker-json-output.md) report generated low-quality code that was verbose and overcomplicated. E.g. in index.php:
	```php
	if ($jsonOutput) {
		ob_start();
		try {
			$results[] = $monopoly->startGame();
		} finally {
			ob_end_clean();
		}
	} else {
		$monopoly->startGame();
	}

	if ($jsonOutput) {
		echo json_encode(count($results) === 1 ? $results[0] : $results, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR) . PHP_EOL;
	}
	```
 	I manually added the `generateWinners` and `outputResults` functions to the Monopoly class to assist with output.
