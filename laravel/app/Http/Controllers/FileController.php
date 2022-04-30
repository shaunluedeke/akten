<?php

namespace App\Http\Controllers;

use App\Models\fractions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public $fraction;

    public function __construct($fracid)
    {
        $this->fraction = fractions::findorfail($fracid);
        $this->create();
    }

    public function create(): void
    {
        if (Storage::disk('public')->exists('fraction/' . $this->fraction->textfile . '.json')) {
            return;
        }
        Storage::disk('public')->put('fraction/' . $this->fraction->textfile . '.json', $this->default());
    }

    public function read(): array
    {
        try {
            return json_decode(Storage::disk('public')->get('fraction/' . $this->fraction->textfile . '.json') ?? "{}", true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }
        return [];
    }

    public function readkey(string $key, string $default = ""): string
    {
        $data = $this->read();
        $keys = explode(".", $key);
        foreach ($keys as $k) {
            if (is_string($data)) {
                return $data;
            }
            if (isset($data[$k])) {
                $data = $data[$k];
            } else {
                return $default;
            }
        }
        return $data;
    }

    public function writekey(string $key, string $value = "", string $split="-") : void
    {
        $data = $this->read();
        $keys = explode($split, $key);
        array_shift($keys);
        $data[array_shift($keys)][array_pop($keys)] = $value;
        $this->writ($data);
    }

    public function writ($data): void
    {
        try {
            Storage::disk('public')->put('fraction/' . $this->fraction->textfile . '.json', json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
        }
    }

    private function default(): string
    {
        $a =
            [
                "akten" =>
                    [
                        "straftat" => "Straftat",
                        "aufklaerung" => "Aufklärung",
                        "urteil" => "Urteil"
                    ],
                "bussgeld" =>
                    [
                        "geld" => "Bußgeld",
                    ]
            ];

        try {
            return json_encode($a, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }
        return "{}";
    }
}
