# Add human-readable CLI results table

> 📌 **Task Started (default, ctx=475,000)**


## 👤 User

Add a nice table to output the winner results when no --json parameter is passed to the cli.

Show the same data as in the json but formatted for human reading.

## 🤖 Agent

I’ll check the CLI’s winner output and add a readable table while preserving `--json` output.

**Custom Tool Output:**

```text
Success. Updated the following files:
M /pronto-woven/src/Monopoly.php

```

## 🤖 Agent

The table now shows each player’s name, money and final space beneath the winner summary. Columns resize to fit, and money is right-aligned. I’m checking both supplied roll sets and the existing tests.

## 🤖 Agent

Added an auto-sized table showing every player’s name, money and final space beneath the winner summary. `--json` output is unchanged.

Verified table data matches JSON for both roll sets. Existing tests have four unrelated failures comparing string money values with floats.

> 📌 **Task Complete**
