<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }

    table {
        font-size: x-small;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: x-small;
    }

    thead th {
        font-size: 10px;
    }


    .gray {
        background-color: lightgray
    }

    td.text-center {
        text-align: center;
        vertical-align: middle;
    }



    .to-border,
    .to-border td,
    .to-border th {
        border: 1px solid;
    }

    .to-border {
        width: 100%;
        border-collapse: collapse;
    }

    .table-inside,
    .table-inside td {
        font-size: 10px;
        border: none;
    }

    .page-break {
        page-break-after: always;
    }
    </style>

</head>

<body>
    @foreach($cpos as $cpo)
    <div>
        <table width="100%">
            <tr>
                <td valign="top"><img src="{{asset('images/times-trans.png')}}" alt="" width="150" /></td>
                <td align="right">
                    <h3>________________ PULL OUT FORM</h3>
                </td>
            </tr>

        </table>
        <br>

        <table width="100%">
            <tr>
                <td><small><strong>NAME:</strong> {{ $cpo['customer_name'] }}</small></td>
                <td><small><strong>RPO#:</strong> {{ $cpo['id'] }}</small></td>
                <td><small><strong>DATE:</strong> {{ $date }}</small></td>
            </tr>
            <tr>
                <td colspan="2"><small><strong>ADDRESS:</strong> {{ $cpo['customer_address'] }}</small></td>
                <td><small><strong>CONTACT:</strong> {{ $cpo['contact_number'] }}</small></td>
            </tr>
            <tr>

                <td><small><strong>PREPARED BY:</strong> {{ $cpo['prepared_by'] }} </small></td>
                <td><small><strong>SALESMAN:</strong> LET / JIA</small></td>
                <td><small><strong>AUTHORIZED BY:</strong> {{ $cpo['authorized_by'] }} </small></td>
            </tr>


        </table>


        <p style="font-size: x-small;">
            THIS DOCUMENT IS TO ACKNOWLEDGE PULL OUT OF THE ITEMS: (TO BE FILLED IN BY TIMES STAFF)
        </p>

        <table width="100%" style="border: 1px solid;" class="to-border">
            <thead style="background-color: lightgray;">
                <tr>
                    <td>#</td>
                    <th>DESCRIPTION</th>
                    <th>QTY<br>RETURNED</th>
                    <th>UNIT</th>
                    <th>QTY<br>INSPECT</th>
                    <th>GOOD<br>CONDITION</th>
                    <th>MINOR<br>REPAIR/<br>CLEAN</th>
                    <th>REPAIR/<br>PARTS<br>NEEDED</th>
                    <th>DAMAGED</th>
                    <th>COMMENTS</th>
                </tr>
            </thead>
            <tbody>

                @foreach($cpo['lines'] as $line)
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
                        <small>{{ $line->comments }}</small>
                    </td>
                </tr>
                <tr>

                    <td>
                        <table width="100%" class="table-inside" style="border:none;">
                            <tr>
                                <td><strong>DATE:</strong> {{ $date }}</td>
                                <td><strong>DOC#:</strong> 1245784</td>
                            </tr>
                            <tr>
                                <td><strong>PRICE:</strong> 45.33</td>
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
                        <small sy>BY:</small>
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
                @endforeach

            </tbody>


        </table>

        <table width="100%">
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
                <td class="text-center">__________</td>
                <td class="text-center">__________</td>
                <td class="text-center">__________</td>
            </tr>


        </table>
        <p style="font-size: x-small;">
            NOTE: PLEASE REFER TO RMA FOR COMPLETE DETAILS RE: RESOLUTION OF THIS TRANSACTION
        </p>

    </div>
    @if(!$loop->last)
    <div class="page-break"></div>
    @endif


    @endforeach

</body>

</html>