<x-app-layout>
<x-slot name="header">
    <h2 class="text-2xl font-bold text-gray-800">Detail Order</h2>
</x-slot>

<div class="max-w-6xl mx-auto py-10 grid md:grid-cols-3 gap-6">

    <!-- DATA ORDER -->
    <div class="md:col-span-2 bg-white rounded-2xl shadow-xl p-8">
        <h3 class="font-bold text-xl mb-6 text-indigo-600 border-b pb-2">
            Informasi Pesanan
        </h3>

        <table class="w-full text-sm space-y-3">
            <tr>
                <td class="text-gray-500 py-2">ID Order</td>
                <td class="font-semibold">#{{ $order->order_id }}</td>
            </tr>

            <tr>
                <td class="text-gray-500 py-2">Total Harga</td>
                <td class="font-semibold text-indigo-600">
                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td class="text-gray-500 py-2">Status Order</td>
                <td>
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $order->status == 'success' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                        {{ $order->status }}
                    </span>
                </td>
            </tr>

            <tr>
                <td class="text-gray-500 py-2">Status Pembayaran</td>
                <td>
                    <span class="px-3 py-1 rounded-full text-xs
                        {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        {{ $order->payment_status }}
                    </span>
                </td>
            </tr>

            <tr>
                <td class="text-gray-500 py-2">Tanggal</td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <!-- PEMBAYARAN -->
    <div class="bg-white rounded-2xl shadow-xl p-8 flex flex-col justify-between text-center">
        <div>
            <h3 class="font-bold text-xl mb-4 text-indigo-600">Pembayaran</h3>
            <p class="text-sm text-gray-500 mb-6">
                Silakan selesaikan pembayaran untuk memproses pesanan Anda.
            </p>
        </div>

        @if ($order->payment_status == 'unpaid')
            <button id="pay-button"
                class="bg-green-500 hover:bg-green-600 upd py-3 rounded-xl font-semibold transition duration-200">
                Bayar Sekarang
            </button>
        @else
            <div class="text-green-600 font-bold text-lg">
                Pembayaran Berhasil ✅
            </div>
        @endif
    </div>
</div>
</x-app-layout>

<!-- MIDTRANS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
const payButton = document.getElementById('pay-button');

if (payButton) {
    payButton.addEventListener('click', function () {
        payButton.innerText = 'Memproses...';
        payButton.disabled = true;

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                location.reload();
            },
            onPending: function(result){
                location.reload();
            },
            onError: function(result){
                alert('Pembayaran gagal, silakan coba lagi');
                payButton.innerText = 'Bayar Sekarang';
                payButton.disabled = false;
            }
        });
    });
}
</script>
