@extends('layouts.app')

@section('title', 'Jadwal Kerja')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Jadwal Kerja</h1>
        <a href="{{ route('schedules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Jadwal
        </a>
    </div>

    <div class="mb-4">
        <form method="GET" class="flex gap-4">
            <input type="date" name="date" value="{{ request('date') }}" 
                class="px-4 py-2 border rounded-lg">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>
            <a href="{{ route('schedules.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Reset
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Shift</th>
                    <th class="px-4 py-2 text-left">Jam Kerja</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $schedule->date->format('d/m/Y') }}</td>
                    <td class="px-4 py-2">{{ $schedule->user->name }}</td>
                    <td class="px-4 py-2">{{ $schedule->shift->name }}</td>
                    <td class="px-4 py-2">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('schedules.destroy', $schedule) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus jadwal ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada data jadwal</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
</div>
@endsection
