<table width="100%">
    <tr>
        <td valign="top" style="width: 20%">
            <img src="{{ $image_src }}" alt="" width="100%" />
        </td>
        <td valign="middle" style="width: 60%; text-align: center">
            <strong style="font-size: 24px;">PULL OUT FORM</strong>
        </td>
        <td align="right" style="width: 20%">
            <h1 style="margin-top: 0; font-size: 24px;"># <span
                    style="border-bottom: 2px solid; padding-bottom: 20px;font-size: 24px;">{{ $cpo['formatted_id'] }}</span>
            </h1>
        </td>
    </tr>
</table>
<br>

<table width="100%">
    <tr>
        <td><small><strong>NAME:</strong> {{ $cpo['customer_name'] }}</small></td>
        <td><small><strong>AUTHORIZED BY:</strong> {{ $cpo['authorized_by'] }} </small></td>
        <td><small><strong>DATE:</strong> {{ $date }}</small></td>
    </tr>
    <tr>
        <td rowspan="2" style="max-width: 200px;"><small><strong>ADDRESS:</strong>
                {{ $cpo['customer_address'] }}</small></td>
        <td><small><strong>CONTACT:</strong> {{ $cpo['contact_number'] }}</small></td>
        <td><small><strong>CUSTOMER REF#:</strong> {{ $cpo['customer_reference_number'] }}</small></td>

    </tr>
    <tr>


        <td><small><strong>SALESMAN:</strong> -</small></td>
        <td><small><strong>PREPARED BY:</strong> {{ $cpo['prepared_by'] }} </small></td>


    </tr>


</table>


<p>
    THIS DOCUMENT IS TO ACKNOWLEDGE PULL OUT OF THE ITEMS: (TO BE FILLED IN BY TIMES STAFF)
</p>