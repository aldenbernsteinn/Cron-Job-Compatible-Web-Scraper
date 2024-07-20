# Minor Codes Scraper

This PHP script fetches and processes minor codes from the [UCSD Minor Codes page](https://blink.ucsd.edu/instructors/academic-info/majors/minor-codes.html). It scrapes the data, processes it, and generates a CSV file with the minor codes, names, and URLs. 

## Features

- Fetches the HTML content from the specified URL using cURL.
- Parses the HTML content to extract minor codes and names.
- Overrides URLs for specific minors with custom URLs.
- Saves the extracted data into a CSV file.

## Cron Job Compatibility

This script is highly compatible with cron jobs for the following reasons:

1. **Command-Line Compatibility**:
   - The script is self-contained and operates entirely through PHP's command-line interface (CLI), without relying on a web server's HTTP request lifecycle. This makes it ideal for execution via cron jobs.

2. **Independent Execution**:
   - It performs all necessary operations from start to finish: fetching data, processing it, and saving it as a CSV file. This allows the script to be scheduled to run at specific intervals without requiring user interaction.

3. **No Web Dependencies**:
   - The script does not depend on any web-based input or output, meaning it can run independently of a web server's state. This independence ensures reliable execution when used as a cron job.

4. **Error Handling**:
   - It includes error checking for the cURL request, ensuring that any issues encountered during data fetching are reported. This helps diagnose problems when the script is executed by a cron job.

5. **File System Operations**:
   - The script writes output directly to a file on the server’s file system. This approach is suitable for cron jobs, as the file system is stable and accessible for scheduled tasks.

6. **Scheduled Execution**:
   - Hosting services like Bluehost provide tools in cPanel for scheduling cron jobs. The script's straightforward execution command (`php /path/to/your/script.php`) can be easily configured in these tools to run at desired intervals (e.g., daily, weekly).

## Requirements

- PHP 7.0 or higher
- cURL extension enabled in PHP
- `DOMDocument` and `DOMXPath` extensions enabled in PHP

## Instructions for implementing provided example PHP script.

1. **Set Up**: Ensure that you have PHP installed and the necessary extensions enabled to place this script in your website's directory.

2. **Run the Script**: Execute the script via the command line or your web server's terminal (reccomended) to test its functionality. For command line execution, use:
   ```bash
   php path/to/your/minorcatscrapescript.php

3. Hosting services like Bluehost make it simple to set up cron jobs and automate scripts. Visit the Cron Jobs section in your cPanel to schedule and automate the execution of this script. All you have to do is copy the execution command above from Step 2 and makesure that the script is located somewhere in the websites directory, which could be accessed and implemented into your website's HTML code with embedded JavaScript / CSS.
