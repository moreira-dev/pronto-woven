# AI Usage

The main IDE used for this project is PhpStorm.

AI assistant was used throughout for autocompletion and targetted code generation.

The Air IDE plugin was also used sporatically for agentic coding for specific features.

Model used was ChatGPT Sol with medium thinking.

## Pushbacks

I found ChatGPT Sol to give low quality code quite often, which was a bit disappointing (I've mostly used Claude in the past).

Some examples of output that needed to be changed:

- Function names for test were initially unhelpful. After providing a consistent convention, the following tests created by GPT were of good quality
- Test generation was verbose and code was not reusable. It took a few prompts to extract the createProperty function and make it easy for tests to use it
- Asking it to output a json report generated low-quality code that was verbose and overcomplicated. E.g. in index.php:
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
 	I manually added the generateWinners and outputResults functions to the Monopoly class to assist with output.
