<!DOCTYPE html>
<html lang="en" style="background:#f5f7fa; margin:0; padding:0; font-family: Arial, sans-serif;">

<head>
    <meta charset="UTF-8" />
    <title>Order Confirmation - #{{ $order->number }}</title>
</head>

<body style="margin:0; padding:0; background:#f5f7fa;">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f5f7fa" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff"
                    style="border-radius: 8px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td bgcolor="#007bff"
                            style="padding: 20px; color: white; text-align: center; font-size: 24px; font-weight: bold;">
                            Thank You for Your Order!
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 30px; color: #333333; font-size: 16px; line-height: 1.5;">
                            <p>Hello {{ $order->user->name ?? 'Customer' }},</p>
                            <p>We have successfully received your order <strong>#{{ $order->number }}</strong>. Below
                                are the details of your purchase.</p>
                        </td>
                    </tr>

                    <!-- Order Details Table -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                                <thead>
                                    <tr style="background: #007bff; color: white; text-align: left;">
                                        <th style="padding: 12px;">Product</th>
                                        <th style="padding: 12px;">Quantity</th>
                                        <th style="padding: 12px;">Price</th>
                                        <th style="padding: 12px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr style="border-bottom: 1px solid #e0e0e0;">
                                            <td style="padding: 12px;">{{ $item->product_name }}</td>
                                            <td style="padding: 12px; text-align: center;">{{ $item->quantity }}</td>
                                            <td style="padding: 12px; text-align: right;">
                                                ${{ number_format($item->price, 2) }}</td>
                                            <td style="padding: 12px; text-align: right;">
                                                ${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: bold;">
                                            Subtotal:</td>
                                        <td style="padding: 12px; text-align: right;">
                                            ${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: bold;">
                                            Discount:</td>
                                        <td style="padding: 12px; text-align: right;">
                                            ${{ number_format($order->discount ?? 0, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 12px; text-align: right; font-weight: bold;">
                                            Shipping:</td>
                                        <td style="padding: 12px; text-align: right;">
                                            ${{ number_format($order->shipping, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 2px solid #007bff;">
                                        <td colspan="3"
                                            style="padding: 12px; text-align: right; font-weight: bold; font-size: 18px;">
                                            Total:</td>
                                        <td
                                            style="padding: 12px; text-align: right; font-weight: bold; font-size: 18px;">
                                            ${{ number_format($order->total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>

                    <!-- Payment & Status -->
                    <tr>
                        <td style="padding: 0 30px 30px 30px; font-size: 14px; color: #555;">
                            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                            <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td bgcolor="#f1f1f1" style="padding: 20px; text-align: center; color: #999; font-size: 13px;">
                            If you have any questions, feel free to contact us at <a href="mailto:support@example.com"
                                style="color: #007bff;">support@example.com</a>.<br>
                            &copy; {{ date('Y') }} Online Shop. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
