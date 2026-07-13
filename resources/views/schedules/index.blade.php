@extends('layouts.app')
@section('title', 'Jadwal Kerja')
@section('content')
<div class="gh-card">
    <div class="gh-card-header flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
        <h1 class="font-header" style="letter-spacing:0.1em;">Jadwal Kerja</h1>
        <a href="{{ route('schedules.create') }}" class="btn btn-gold text-xs">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jadwal
        </a>
    </div>

    <div class="px-6 py-4" style="border-bottom:1px solid var(--cream-200);">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="date" name="date" value="{{ request('date') }}" class="gh-input" style="width:auto; min-width:160px;">
            <button type="submit" class="btn btn-primary">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                Filter
            </button>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="gh-table">
            <thead><tr>
                <th>Tanggal</th>
                <th>User</th>
                <th>Shift</th>
                <th>Jam Kerja</th>
                <th>Aksi</th>
            </tr></thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr>
                    <td style="color:var(--gray-500);">{{ $schedule->date->format('d/m/Y') }}</td>
                    <td class="font-bold" style="color:var(--brown-900);">{{ $schedule->user->name }}</td>
                    <td><span class="badge badge-brown">{{ $schedule->shift->name }}</span></td>
                    <td style="color:var(--gray-500);">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</td>
                    <td>
                        @if(!$schedule->date->startOfDay()->lt(today()))
                        <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-secondary">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        @endif
                        <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus jadwal ini?')">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10" style="color:var(--gray-300);">Belum ada data jadwal</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4">{{ $schedules->links() }}</div>
</div>
@endsection
