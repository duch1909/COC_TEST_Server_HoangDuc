<?php

namespace App\Services\Traits;

trait ImageTrait
{
    public function uploadImage(array $file = [])
    {
        $values = array_map(
            function ($value) {
                return $value->storeAs(
                    $this->generateFilePath(),
                    $value->getClientOriginalName(),
                    config('filesystems.default')
                );
            },
            $file
        );

        return $values;
    }

    protected function generateFilePath(string $name = null, $prefix = null)
    {
        $path = date('Y/m_d/H_m/') . crc32(get_class($this)) . '/' . rand();

        return trim($prefix . '/' . $path . '/' . preg_replace('/[^\w\.]/', '1', $name), '/');
    }
}
