@extends('layout.site')
@section('title', 'Carrinho')
@section('content')

<div class="my-8 flex flex-col gap-4 justify-self-center max-w-[1080px] w-full">

    <div class="text-hcosta-100 text-5xl font-bold">Carrinho</div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($cart_items->count() <= 0)
        <span class="text-8xl font-bold text-hcosta-200">Nenhum item adicionado ainda...</span>
    @else
    <div class="flex gap-6">
        <div class="flex flex-col gap-4 w-full">
            @foreach ($cart_items as $item)
                <div class="flex justify-between p-4 gap-4 w-full h-fit bg-white rounded-2xl">
                    <div class="flex gap-4 h-full">
                        <div class="w-36 h-36 bg-hcosta-200"></div>
                        <div>
                            <span class="text-2xl text-hcosta-100 font-bold">{{  $item->description  }}</span>
                            <div class="gap-3 flex flex-col justify-between items-start font-bold">
                                <span>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</span>
                                <form action="/cart/update" method="POST">
                                    @method('POST')
                                    @csrf
                                    <span>Quantidade</span>
                                    <input type="number" name="product_id" value="{{$item->product_id}}" hidden>
                                    <input type="number" min="0" name="quantity" value="{{ old('quantity', $item->quantity) }}" class="w-16 border-2 border-hcosta-200 rounded-md px-2 py-1">
                                    <button class="bg-hcosta-200 text-white rounded-md px-2 py-1">Check</button>
                                </form>
                                
                                <form action="/cart/delete" method="POST">
                                    @method('POST')
                                    @csrf
                                    <input type="number" name="product_id" value="{{$item->product_id}}" hidden>
                                    <button class="text-xs px-2 py-1 border-hcosta-200 border-2 rounded-md text-hcosta-200">Remover do carrinho</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="self-center">
                        <span class="font-xl font-bold">Total</span>
                        <span class="text-3xl text-hcosta-200 font-bold">R$ {{( number_format($item->unit_price * $item->quantity, 2, ',', '.') )}}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class=" flex flex-col gap-6 bg-white p-4 h-fit rounded-2xl justify-end">
            <span class="text-xl text-hcosta-200 font-bold ">Total</span>
            <form action="/order/create" method="post" class="flex flex-col items-end gap-4 min-w-64">
                @csrf
                @method('POST')
                @foreach ($cart_items as $item)
                <div class="flex justify-between w-full font-medium py-2 border-b-2">
                    <span class="text-sm">{{$item->description}}</span>
                    <span class="text-xl font-bold min-w-fit">R$ {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }}</span> 
                </div>
                @endforeach
                <input type="number" name="total" step=".01" value="{{$total}}" hidden>
                <span class="text-3xl font-bold text-hcosta-200">R$ {{ number_format($total, 2, ',', '.') }}</span> 
                <button class="w-full text-3xl font-bold bg-hcosta-300 text-white rounded-md px-6 py-4">Finalizar</button>
            </form>
        </div>
    </div>
    @endif
</div>

@endsection