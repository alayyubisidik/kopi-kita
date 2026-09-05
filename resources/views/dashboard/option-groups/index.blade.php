@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
                    @if(session('alert'))
                        <div class="mb-6 p-4 rounded-lg {{ session('alert.type') === 'error' ? 'bg-red-50 text-red-800' : 'bg-green-50 text-green-800' }}">
                            {{ session('alert.message') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <form method="GET" class="flex-1 max-w-md">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ $search }}" 
                                        placeholder="Cari option group..." 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    >
                                </form>
                                <a href="{{ route('dashboard.option-groups.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Option Group
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Seleksi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Option</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($optionGroups as $optionGroup)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $optionGroup->name }}</div>
                                                @if($optionGroup->description)
                                                    <div class="text-sm text-gray-500">{{ Str::limit($optionGroup->description, 50) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $optionGroup->selection_type === 'single' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $optionGroup->selection_type === 'single' ? 'Single' : 'Multiple' }}
                                                </span>
                                                @if($optionGroup->selection_type === 'multiple')
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        @if($optionGroup->min_selection)
                                                            Min: {{ $optionGroup->min_selection }}
                                                        @endif
                                                        @if($optionGroup->max_selection)
                                                            Max: {{ $optionGroup->max_selection }}
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $optionGroup->options_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($optionGroup->is_active)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Aktif
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center gap-3">
                                                    <a href="{{ route('dashboard.option-groups.edit', $optionGroup) }}" class="text-blue-600 hover:text-blue-900">
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('dashboard.option-groups.destroy', $optionGroup) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="text-red-600 hover:text-red-900 delete-btn">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                                Tidak ada option group.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($optionGroups->hasPages())
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $optionGroups->links() }}
                            </div>
                        @endif
                    </div>
                </div>
@endsection
