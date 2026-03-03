@props(['title' => null, 'subtitle' => null])

@php
    $title = $title ?? ($attributes['title'] ?? null);
    $subtitle = $subtitle ?? ($attributes['subtitle'] ?? null);
@endphp

@include('layouts.admin', [
    'title' => $title,
    'subtitle' => $subtitle,
    'slot' => $slot
])