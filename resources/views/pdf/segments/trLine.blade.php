<tr>


    <th scope="row" rowspan="2">{{ $line->line_number }}</th>
    <td class="text-center"><small>{{ $line->description }}</small></td>
    <td class="text-center" align="right"><small>{{ $line->qty_returned }}</small></td>
    <td class="text-center" align="right"><small>{{ $line->unit }}</small></td>
    <td class="text-center" align="right"><small>{{ $line->qty_inspect }}</small></td>
    <td class="text-center" align="right"><small>{{ $line->good_condition }}</small></td>
    <td class="text-center">
        <small>{{ $line->minor_repair_clean }}</small>
    </td>
    <td class="text-center">
        <small>{{ $line->repair_parts_needed }}</small>
    </td>
    <td class="text-center">
        <small>{{ $line->damaged }}</small>
    </td>
    <td rowspan="2">
        <table width="100%" class="table-inside" style="border:none;">
            @foreach($line->all_comments as $comment)
            <tr>
                <td>
                    <strong>{{ $comment['commented_by'] }}:</strong>
                    <br>
                    <small>{{ $comment['comment'] }}</small>
                </td>
            </tr>
            @endforeach


        </table>

    </td>
</tr>
<tr>

    <td>
        <table width="100%" class="table-inside" style="border:none;">
            <tr>
                <td><strong>DATE:</strong> {{ $date }}</td>
                <td><strong>DOC#:</strong> {{ $line->order_number }}</td>
            </tr>
            <tr>
                <td><strong>PRICE:</strong> {{ $line->price }}</td>
                <td><strong>HC:</strong> {{ $line->hcopy }}</td>
            </tr>

        </table>
    </td>
    <td colspan="2">
        <table width="100%" class="table-inside" style="border:none;">
            <tr>
                <td><strong>REP</strong></td>
                <td><strong>EXC</strong></td>
                <td><strong>RET/</strong></td>
            </tr>
            <tr>
                <td>____</td>
                <td>____</td>
                <td>____</td>
            </tr>
        </table>
    </td>

    <td>
        <small>BY:</small>
    </td>
    <td>
        <small>BY:</small>
    </td>
    <td>
        <small>BY:</small>
    </td>
    <td>
        <small>BY:</small>
    </td>
    <td>

    </td>
</tr>