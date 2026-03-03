<?php

use App\Models\AuditLog;

if (! function_exists('audit')) {
    function audit(
        string $action,
        string $entityType,
        ?int $entityId = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ): void {
        try {
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'route' => request()->path(),
                'ip' => request()->ip(),
                'user_agent' => substr((string) request()->userAgent(), 0, 500),
                'old_values' => $oldValues,
                'new_values' => $newValues,
            ]);
        } catch (\Throwable $e) {
            // On ne casse jamais l'app juste pour l'audit
        }
    }
}