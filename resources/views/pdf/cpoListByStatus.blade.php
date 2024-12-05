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



    @if(isset($cpos))
    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('images/times-trans.png')}}" alt="" width="150" /></td>
            <td align="right">
                {{ $date }}
            </td>

        </tr>

    </table>


    <p style="font-size: x-small;">
        LIST OF CPOS BY STATUS
    </p>

    <table width="100%" style="border: 1px solid;" class="to-border">
        <thead style="background-color: lightgray;">
            <tr>

                <th>RPO#</th>
                <th>Ref#</th>
                <th>CUSTOMER</th>
                <th>ADDRESS</th>
                <th>STATUS</th>

            </tr>
        </thead>
        <tbody>
            @foreach($cpos as $cpo)
            <tr>
                <th scope="row">{{ $cpo->formatted_id }}</th>
                <td class="text-center"><small>{{ $cpo->customer_reference_number }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_name }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_address }}</small></td>
                <td class="text-center"><small>{{ $header_statuses[$cpo->status_id] }}</small></td>

            </tr>
            @endforeach


        </tbody>


    </table>


    @endif


    @if(isset($cpos_modified))
    @if(isset($cpos))
    <div class="page-break"> </div>

    @endif

    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('images/times-trans.png')}}" alt="" width="150" /></td>
            <td align="right">
                {{ $date }}
            </td>

        </tr>

    </table>
    <p style="font-size: x-small;">
        LIST OF CPOS MODIFIED FROM {{ $modified_from }} TO {{ $modified_to }}
    </p>

    <table width="100%" style="border: 1px solid;" class="to-border">
        <thead style="background-color: lightgray;">
            <tr>

                <th>RPO#</th>
                <th>Ref#</th>
                <th>CUSTOMER</th>
                <th>ADDRESS</th>
                <th>Modified date</th>

            </tr>
        </thead>
        <tbody>
            @foreach($cpos_modified as $cpo)
            <tr>
                <th scope="row">{{ $cpo->formatted_id }}</th>
                <td class="text-center"><small>{{ $cpo->customer_reference_number }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_name }}</small></td>
                <td class="text-center"><small>{{ $cpo->customer_address }}</small></td>
                <td class="text-center"><small>{{ $cpo->updated_at }}</small></td>

            </tr>
            @endforeach


        </tbody>


    </table>



    @endif

    @if(isset($cpos_changed_status))
    <div class="page-break">
    </div>
    <table width="100%">
        <tr>
            <td valign="top"><img src="{{asset('images/times-trans.png')}}" alt="" width="150" /></td>
            <td align="right">
                {{ $date }}
            </td>

        </tr>

    </table>
    <p style="font-size: x-small;">
        LIST OF CPOS CHANGED STATUS FROM {{ $changed_status_from }} TO {{ $changed_status_to }}
    </p>

    <table width="100%" style="border: 1px solid;" class="to-border">
        <thead style="background-color: lightgray;">
            <tr>

                <th>RPO#</th>
                <th>REF#</th>
                <th>Modified date</th>
                <th>Status From</th>
                <th>Status To</th>

            </tr>
        </thead>
        <tbody>
            @foreach($cpos_changed_status as $cpo)
            <tr>
                <th scope="row">{{ $cpo->formatted_id }}</th>
                <td class="text-center"><small>{{ $cpo->customer_reference_number }}</small></td>
                <td class="text-center"><small>{{ $cpo->changed_date }}</small></td>
                <td class="text-center"><small>{{ $cpo->status_old }}</small></td>
                <td class="text-center"><small>{{ $cpo->status_new }}</small></td>

            </tr>
            @endforeach


        </tbody>


    </table>





    @endif
</body>

</html>