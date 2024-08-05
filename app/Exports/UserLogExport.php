<?php

namespace App\Exports;

use App\Models\UserLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserLogExport implements FromCollection, WithHeadings
{
    protected $userlog;
    protected $url;

    public function __construct($userlog, $url)
    {
        $this->userlog = $userlog;
        $this->url = $url;
    }

    public function collection()
    {
        return $this->userlog->map(function ($log) {
            $properties = json_decode($log->properties, true);

            // Separate the attributes and old sections for user view
            $attributes = isset($properties['attributes']) ? $properties['attributes'] : [];
            $old = isset($properties['old']) ? $properties['old'] : [];

            // Prepare readable strings for attributes and old
            $attributesStr = $this->prepareReadableString($attributes);
            $oldStr = $this->prepareReadableString($old);
            return [
                'ID' => $log->id,
                'Log Name' => $log->log_name,
                'Description' => $log->description,
                'Event' => $log->event,
                'Url' => $this->url,
                'New Value' => $attributesStr,
                'Old Value' => $oldStr,
                'Date' => date('d-m-Y H:i:s', $log->created_at->timestamp)
            ];
        });
    }


    public function headings(): array
    {
        return [
            'ID',
            'Log Name',
            'Description',
            'Event',
            'User',
            'New Value',
            'Old Value',
            'Date'
        ];
    }
    private function prepareReadableString($data)
    {
        if (empty($data)) {
            return '';
        }

        $result = '';
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $result .= $key . ' -> ' . $subKey . ': ' . $subValue .','. PHP_EOL;
                }
            } else {
                $result .= $key . ': ' . $value .' ,'. PHP_EOL;
            }
            $result .= PHP_EOL;
        }

        return $result;
    }
}
