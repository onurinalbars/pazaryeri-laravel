<?php

namespace App\Services\Settings;

use Illuminate\Support\Facades\Storage;

class SettingService
{
    protected string $disk = 'local';
    protected string $directory = 'settings';

    public function get(string $key, array $default = []): array
    {
        $path = $this->path($key);

        if (! Storage::disk($this->disk)->exists($path)) {
            return $default;
        }

        $payload = json_decode(Storage::disk($this->disk)->get($path), true);

        return is_array($payload) ? $payload : $default;
    }

    public function put(string $key, array $data): void
    {
        Storage::disk($this->disk)->put($this->path($key), json_encode($data));
    }

    protected function path(string $key): string
    {
        return "{$this->directory}/{$key}.json";
    }
}
