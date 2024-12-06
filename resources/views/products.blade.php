@extends('layout.site')
@section('title', 'Produtos')
@section('content')
<div class="my-8 flex flex-col gap-4 justify-self-center max-w-[1080px]">
    <h4 class="text-hcosta-100 text-5xl font-bold">Produtos</h4>
    <div class="flex gap-4 flex-wrap">
        @foreach($products as $item)
            <div class="flex flex-col justify-between p-4 rounded-xl bg-white min-w-56 w-fit h-72">
                <span class="w-full h-36 bg-hcosta-200"></span>
                <form action="/addToCart" method="POST" class="flex flex-col">
                    @method('post')
                    @csrf
                    <input type="hidden" name="description" value="{{ $item->descricao }}">
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <input type="hidden" name="unit_price" value="{{ (float)$item->valor }}">
                    <input type="hidden" name="quantity" value="1">
                    
                    <span class="font-bold text-hcosta-200 text-2xl max-w-4xl">{{ $item->descricao }}</span>
                    <span class="font-bold">R$ {{ $item->valor }}</span>
                    <button type"submit" class="bg-hcosta-300 p-4 py-2 font-bold text-white rounded-md">Comprar</button>
                </form>
            </div>
        @endforeach
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
</div>
@endsection
