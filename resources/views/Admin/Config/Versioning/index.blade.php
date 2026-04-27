@extends('layouts.app')
@section('title', 'Versioning & Rollback')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="mb-6">
        <h1 class="text-h3 font-bold text-text-primary">14.7 Versioning & Rollback</h1>
        <p class="text-body-sm text-text-secondary mt-1">Configuration history, diffs, and one-click rollback.</p>
    </div>

    <div class="card p-0 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-bg-tertiary border-b border-border-strong text-caption uppercase text-text-secondary font-semibold">
                <tr>
                    <th class="px-5 py-3">Version ID</th>
                    <th class="px-5 py-3">Author</th>
                    <th class="px-5 py-3">Timestamp</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-default">
                <tr class="hover:bg-bg-secondary">
                    <td class="px-5 py-4 font-mono text-body-sm font-bold text-brand-primary">v14.1.0 <span class="ml-2 bg-semantic-success-bg text-semantic-success px-1.5 py-0.5 rounded text-[9px] uppercase border border-semantic-success/20">Live</span></td>
                    <td class="px-5 py-4 text-body-sm">System Admin</td>
                    <td class="px-5 py-4 text-caption text-text-tertiary">Oct 26, 2026 10:00</td>
                    <td class="px-5 py-4 text-right">
                        <button class="btn btn-sm btn-secondary">Diff Viewer</button>
                    </td>
                </tr>
                <tr class="hover:bg-bg-secondary">
                    <td class="px-5 py-4 font-mono text-body-sm text-text-primary">v14.0.9</td>
                    <td class="px-5 py-4 text-body-sm">John Doe</td>
                    <td class="px-5 py-4 text-caption text-text-tertiary">Oct 25, 2026 14:30</td>
                    <td class="px-5 py-4 text-right flex justify-end gap-2">
                        <button class="btn btn-sm btn-secondary">Diff Viewer</button>
                        <button class="btn btn-sm btn-destructive" onclick="alert('Rolling back configuration to v14.0.9...')">1-Click Rollback</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection