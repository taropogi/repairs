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

    @if(isset($cpos))
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
                <td class="text-center"><small>{{ $header_statuses[$cpo->status_id] }}</small></td>

            </tr>
            @endforeach


        </tbody>


    </table>

    @endif


    @if(isset($cpos_modified))
    <p style="font-size: x-small;">
        LIST OF CPOS MODIFIED FROM {{ $modified_from }} TO {{ $modified_to }}
    </p>

    <table width="100%" style="border: 1px solid;" class="to-border">
        <thead style="background-color: lightgray;">
            <tr>
                <td>#</td>
                <th>RPO#</th>
                <th>CUSTOMER</th>
                <th>ADDRESS</th>
                <th>Modified date</th>

            </tr>
        </thead>
        <tbody>
            @foreach($cpos_modified as $cpo)
            <tr>
                <th scope="row">{{ $cpo->id }}</th>
                <td class="text-center"><small>{{ $cpo->rpo_number }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_name }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_address }}</small></td>
                <td class="text-center"><small>{{ $cpo->updated_at }}</small></td>

            </tr>
            @endforeach


        </tbody>


    </table>

    @endif
</body>

</html>