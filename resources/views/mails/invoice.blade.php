<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>Name</tr>
            <tr>Price</tr>
            <tr>Qty.</tr>
            <tr>Total</tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>{{ $item->product->name }}</tr>
            <tr>{{ $item->price }}</tr>
            <tr>{{ $item->quantity }}</tr>
            <tr>{{ $item->price * $item->quantity }}</tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr colspan='3'>Total</tr>
            <tr>{{ $order->total }}</tr>
        </tfoot>
    </table>
</body>
</html>