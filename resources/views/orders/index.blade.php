<x-app-layout>
<x-slot name="header">
    <h2 class="text-2xl font-bold text-gray-800">Riwayat Pesanan</h2>
</x-slot>

<div class="max-w-5xl mx-auto py-10">
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="p-4">#</th>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td>#{{ $order->order_id }}</td>
                    <td class="text-indigo-600 font-semibold">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="px-3 py-1 rounded-full text-xs
                        {{ $order->status == 'success' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('orders.show',$order->id) }}"
                           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-400">Belum ada order</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
