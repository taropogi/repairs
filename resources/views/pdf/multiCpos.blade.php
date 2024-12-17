<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        @page {
            margin: 50px;
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

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 12px;
        }

        .page-number:after {
            content: counter(page);
        }
    </style>

</head>

<body>




    <div>

        @foreach($cpos as $cpo)

        @php
        $chunks = array_chunk($cpo['lines']->toArray(), 14);

        @endphp

        @foreach($chunks as $chunk)
        @include('pdf.segments.pdfHeader')
        <footer class="footer">
            Page <span class="page-number"></span>
        </footer>
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
                @foreach($chunk as $line)
                @include('pdf.segments.trLine', ['line' => (object) $line])
                @endforeach
            </tbody>


        </table>

        @if(!$loop->last)

        <div class="page-break"></div>
        @endif

        @endforeach

        @include('pdf.segments.pdfFooter')
    </div>
    @if(!$loop->last)
    <div class="page-break"></div>
    @endif


    @endforeach

</body>

</html>