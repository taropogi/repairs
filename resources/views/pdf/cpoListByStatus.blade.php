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
    </style>

</head>

<body>

    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('images/times-trans.png')}}" alt="" width="150" /></td>
            <td align="right">
                {{ $date }}
            </td>

        </tr>

    </table>
    <br>

    <table width="100%">



    </table>


    <p style="font-size: x-small;">
        LIST OF CPOS BY STATUS
    </p>

    <table width="100%" style="border: 1px solid;" class="to-border">
        <thead style="background-color: lightgray;">
            <tr>
                <td>#</td>
                <th>RPO#</th>
                <th>CUSTOMER</th>
                <th>ADDRESS</th>
                <th>STATUS</th>

            </tr>
        </thead>
        <tbody>
            @foreach($cpos as $cpo)
            <tr>
                <th scope="row">{{ $cpo->id }}</th>
                <td class="text-center"><small>{{ $cpo->rpo_number }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_name }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_address }}</small></td>
                <td class="text-center"><small>{{ $header_statuses[$cpo->status_id]->status }}</small></td>

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

</body>

</html>