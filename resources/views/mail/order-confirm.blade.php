@component('mail::message')
# Order Received

Thank you for your order.

<?php $currency=get_current_currency()['symbol'];?>
**Order Number:** {{ $invoice_id }}

**Order Email:** {{ $checkout_data['billing_email'] }}

**Order Name:** {{ $checkout_data['billing_name'] }}

**State:** {{ $checkout_data['shipping_state'] }}

**Order Total:** {{$currency}}{{ (Cart::getTotal()) }}

**Items Ordered**

@foreach (Cart::getContent() as $product)
Name: {{ $product->name }} <br>
Price: {{$currency}}{{ ($product->getPriceWithConditions())}} <br>
Quantity: {{ $product->quantity }} <br>
<br>
@endforeach


You can get further details about your order by logging into our website.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Thank you again for choosing us.

Regards,<br>
{{ config('app.name') }}
@endcomponent