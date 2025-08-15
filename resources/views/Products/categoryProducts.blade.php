<h1>{{ $category->name }} Products</h1>

<ul>
    @foreach ($products as $product)
        <li>{{ $product->name }}</li>
    @endforeach
</ul>
