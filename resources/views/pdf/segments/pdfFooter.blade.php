<table width="100%" style="margin-top: 30px;">
    <tr>
        <td style="text-align: center;">
            <strong>TOTAL AMOUNT : </strong> Php {{ $cpo->total_amount }}
        </td>
        <td style="text-align: center;">
            <strong>TOTAL QTY RETURNED : </strong> {{ $cpo->total_qty_returned }}
        </td>
    </tr>
</table>

<table width="100%" style="margin-top: 20px;">
    <tr>
        <td class="text-center"><small><strong>RETURNED BY</strong></small></td>
        <td class="text-center"><small><strong>RECEIVED BY WHSE</strong></small></td>
        <td class="text-center"><small><strong>INSPECTED BY</strong></small></td>
        <td class="text-center"><small><strong>RM#</strong></small></td>
        <td class="text-center"><small><strong>RECOVERED BY</strong></small></td>
        <td class="text-center"><small><strong>DATE</strong></small></td>
    </tr>
    <tr>
        <td class="text-center">__________</td>
        <td class="text-center">__________</td>
        <td class="text-center">__________</td>
        <td class="text-center underline-spacing">{{ $cpo->rma_number ? $cpo->formatted_rma_number : 'N/A' }}</td>
        <td class="text-center">__________</td>
        <td class="text-center">__________</td>
    </tr>


</table>
<p>
    NOTE: PLEASE REFER TO RMA FOR COMPLETE DETAILS RE: RESOLUTION OF THIS TRANSACTION
</p>