<?php

namespace App\Services;

use App\Models\Record;
use App\Models\Setting;
use Google_Client;
use Google_Service_Sheets;

class GoogleSheetService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets Sync');
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('/app/google/credentials.json'));
        $this->client->setAccessType('offline');
        $this->service = new Google_Service_Sheets($this->client);
    }

    public function getService()
    {
        return $this->service;
    }

    public function getSheetData($spreadsheetId, $range): array
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues() ?? [];
    }

    public function updateSheetData($spreadsheetId, $range, $values)
    {
        $body = new \Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = ['valueInputOption' => 'RAW'];
        return $this->service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
    }

    public function clearSheet($spreadsheetId, $range)
    {
        return $this->service->spreadsheets_values->clear($spreadsheetId, $range, new \Google_Service_Sheets_ClearValuesRequest());
    }

    public function syncRecord()
    {
        $sheetUrl = Setting::getValue('google_sheet_url');
        if (!$sheetUrl) {
            return 1;
        }
        // Извлекаем spreadsheetId из URL
        if (preg_match('~/d/([\w-]+)~', $sheetUrl, $m)) {
            $spreadsheetId = $m[1];
        } else {
            return 1;
        }
        $range = 'A1';
        $records = Record::allowed()->get();
        // Формируем заголовки и строки
        $header = ['id', 'text', 'status', 'comment'];
        $rows = [$header];
        foreach ($records as $record) {
            $rows[] = [
                $record->id,
                $record->text,
                $record->status,
                '', // comment (будет заполнен пользователем в Google Sheet)
            ];
        }
        // Получаем существующие комментарии
        $existing = $this->getSheetData($spreadsheetId, 'A2:D'); // теперь только 4 колонки
        $comments = [];
        foreach ($existing as $row) {
            if (isset($row[0]) && isset($row[3])) { // индекс 3 = comment
                $comments[$row[0]] = $row[3];
            }
        }

        // Вставляем комментарии обратно по id
        foreach ($rows as $i => $row) {
            if ($i === 0)
                continue; // header
            $id = $row[0];
            if (isset($comments[$id])) {
                $rows[$i][3] = $comments[$id]; // 3-й индекс = comment
            }
        }

        // Очищаем и обновляем диапазон
        $this->clearSheet($spreadsheetId, 'A1:D');
        $this->updateSheetData($spreadsheetId, 'A1', $rows);
        return 0;
    }
}
