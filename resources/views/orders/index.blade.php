@extends('layout')

@section('title', 'My Orders')

@section('content')
<div class="container my-4">
    <h2 class="mb-3">My Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <p>No orders yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Items</th>
                    <th>Total (EGP)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            @php $items = json_decode($order->items, true); @endphp
                            <ul>
                                @foreach ($items as $item)
                                    <li>{{ $item['name'] }} (x{{ $item['quantity'] }}) - {{ $item['total'] }} EGP</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->total }} EGP</td>
                        <td>
                            <form action="{{ route('orders.update', $order) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select me-2">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button class="btn btn-sm btn-primary">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
