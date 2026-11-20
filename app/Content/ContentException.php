<?php

namespace App\Content;

use RuntimeException;
use Throwable;

/**
 * A file in content/ is missing, unreadable, or does not follow content/README.md.
 */
final class ContentException extends RuntimeException
{
    public static function invalid(string $file, string $reason, ?Throwable $previous = null): self
    {
        return new self("Invalid content in {$file}: {$reason}", 0, $previous);
    }

    public static function invalidField(string $file, string $field, string $expected, ?string $id = null): self
    {
        $where = $id !== null ? " (id: {$id})" : '';

        return self::invalid($file, "field `{$field}` must be {$expected}{$where}");
    }
}
