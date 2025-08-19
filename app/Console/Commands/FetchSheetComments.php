<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use App\Services\GoogleSheetService;
use Symfony\Component\Console\Helper\ProgressBar;

class FetchSheetComments extends Command
{
    protected $signature = 'records:fetch-comments {count?}';
    protected $description = 'Fetch comments from Google Sheet and print model ID / comment';

    public function handle()
    {
        $sheetUrl = Setting::getValue('google_sheet_url');
        if (!$sheetUrl) {
            $this->error('Google Sheet URL not set.');
            return 1;
        }
        if (preg_match('~/d/([\w-]+)~', $sheetUrl, $m)) {
            $spreadsheetId = $m[1];
        } else {
            $this->error('Invalid Google Sheet URL.');
            return 1;
        }
        $service = new GoogleSheetService();
        $rows = $service->getSheetData($spreadsheetId, 'A2:D'); // теперь только 4 колонки
        if (is_null($rows)) {
            $this->error('No rows returned from Google Sheet. Check access and range.');
            return 1;
        }
        $count = $this->argument('count') ? (int) $this->argument('count') : count($rows ?? []);
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        $printed = 0;
        foreach ($rows as $row) {
            if ($printed >= $count)
                break;
            $id = $row[0] ?? '';
            $comment = $row[3] ?? ''; // индекс 3 = comment
            $this->line("ID: $id | Comment: $comment");
            $bar->advance();
            $printed++;
        }
        $bar->finish();
        $this->newLine();
        $this->info('Done.');
        return 0;

    }
}
