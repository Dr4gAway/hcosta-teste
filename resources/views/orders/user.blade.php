@extends('layout.site')
@section('title', 'Pedidos')
@section('content')

<div class="my-8 flex flex-col gap-4 justify-self-center max-w-[1080px] w-full">

    @if ($orders->count() <= 0 )
        <span class="text-8xl font-bold text-hcosta-200">Nenhum item adicionado ainda...</span>
    @else

    <div class="text-hcosta-100 text-5xl font-bold">Pedidos</div>
    <div>
        
        <form action="/orders/filter" method="GET" class="bg-white rounded-md w-fit px-4 py-2">
            @csrf
            @method('GET')
            <span class="font-bold">Filtrar por</span>
            <select class="bg-slate-300 text-md rounded-md px-2 py-1" name="filterby" id="status">
                <option value="status" selected>Status</option>
                <option value="total">Valor</option>
            </select>
            
            <button class="bg-hcosta-200 text-white rounded-md px-2 py-1">Check</button>
        </form> 
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex gap-6">
        <div class="flex flex-col gap-4 w-full">
            @foreach ($orders as $order)
                <div class="flex flex-col justify-between p-4 rounded-xl bg-white min-w-56">
                    <div class="flex w-full justify-between mb-4">
                        <div class="flex gap-6">
                            <div>
                                <span class="">ID</span>
                                <span class="text-xl font-bold text-hcosta-200">{{ $order->id }}</span>
                            </div>
                            <div>
                                <span>Total</span>
                                <span class="text-xl font-bold text-hcosta-200">R${{ number_format($order->total, 2, ',', '.') }}</span>
                            </div>
                        </div>
                        @if ($order->status == 1)
                            <form action="/order/update" method="POST">
                                @csrf
                                @method('POST')
                                <span class="font-bold ">Status</span>
                                <select class="bg-slate-300 text-md rounded-md px-2 py-1" name="status" value="{{old('status', $order->status)}}" id="status">
                                    <option value="1">Pendente</option>
                                    <option value="2">Pago</option>
                                    <option value="3">Finalizado</option>
                                </select>
                                <input type="number" name="order_id" value="{{$order->id}}" hidden >
                                <button class="bg-hcosta-200 text-white rounded-md px-2 py-1">Check</button>
                            </form>    
                        @else
                        <div>
                            <span class="font-bold ">Status</span>
                            @if ($order->status == 2)
                                <span class="bg-slate-300 text-md rounded-md px-2 py-1" name="status">Pago</span>
                            @else
                                <span class="bg-slate-300 text-md rounded-md px-2 py-1" name="status">Finalizado</span>
                            @endif
                            
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col p-6 gap-2 bg-slate-400 rounded-xl">
                        @foreach ($order->orderProduct as $orderProduct)
                            @if ($orderProduct->order_id == $order->id)
                            <div>
                                <span class="font-bold text-xl">{{ $orderProduct->description }}</span>
                                <div class="flex gap-8">
                                    <span class="">Qtd. {{ $orderProduct->quantity}}</span>
                                    <span>Preço total: R${{ number_format($orderProduct->unit_price * $orderProduct->quantity, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

@endsection