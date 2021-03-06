@extends('layouts/app')

@section('title')
    Client Lookup
@endsection

@section('content')
    <form id="clientForm" class="form-inline" role="form" method="GET" action="/client/$clientId">
        <div class="form-group">
            <label for="clientId">Client ID</label>
            <input type="text" class="form-control" id="clientId" required>
        </div>
        <button id="clientSubmit" type="submit" class="btn btn-default">Get Details</button>
    </form>
    <br>

    @if(isset($client))
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> {{ $client->id }}</li>
            <li class="list-group-item"><strong>Surname:</strong> {{ $client->surname }}</li>
            <li class="list-group-item">
                <strong>DOB:</strong> {{ Carbon\Carbon::parse($client->dob)->format('d-m-Y') }}
            </li>
            <li class="list-group-item"><strong>Postcode:</strong> {{ $client->postcode }}</li>
        </ul>


        <ul class="list-group">
            <li class="list-group-item"><strong>First Name:</strong>
                @php
                foreach($details as $detail) {
                if(isset($unique)) {
                if($unique == strtoupper($detail['first_name'])) {

                } else {
                echo " / ".$detail['first_name'];
                }
                } else {
                $unique = strtoupper($detail['first_name']);
                echo " ".$detail['first_name'];
                }
                }
                @endphp
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item"><strong>NI:</strong>
                @php
                unset($unique);
                foreach($details as $detail) {
                if($detail['ni'] == '' || $detail['ni'] == 'N/A') {

                } else {
                if(isset($unique)) {
                if($unique == strtoupper($detail['ni'])) {

                } else {
                echo " / ".$detail['ni'];
                }
                } else {
                $unique = strtoupper($detail['ni']);
                echo " ".$detail['ni'];
                }
                }
                }
                @endphp
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item"><strong>NHS No:</strong>
                @php
                unset($unique);
                foreach($details as $detail) {
                if($detail['nhs_no'] == '' || $detail['nhs_no'] == 'N/A') {

                } else {
                if(isset($unique)) {
                if($unique == strtoupper($detail['nhs_no'])) {

                } else {
                echo " / ".$detail['nhs_no'];
                }
                } else {
                $unique = strtoupper($detail['nhs_no']);
                echo " ".$detail['nhs_no'];
                }
                }
                }
                @endphp
            </li>
        </ul>

        <ul class="list-group">
            <li class="list-group-item"><strong>Full Address:</strong>
                <div class="row">
                    @php
                    unset($unique);
                    foreach($details as $detail) {
                    if($detail['full_address'] == '' || $detail['full_address'] == 'N/A') {

                    } else {
                    if(isset($unique)) {
                    $compare = strtolower($detail['full_address']);
                    $compare = str_replace(' ', '', $compare);
                    $compare = str_replace(',', '', $compare);
                    if($unique == $compare) {

                    } else {
                    echo '
                    <div class="col-sm-3">'.$detail['full_address'].'</div>
                    ';
                    }
                    } else {
                    $unique = strtolower($detail['full_address']);
                    $unique = str_replace(' ', '', $unique);
                    $unique = str_replace(',', '', $unique);
                    echo '
                    <div class="col-sm-3">'.$detail['full_address'].'</div>
                    ';
                    }
                    }
                    }
                    @endphp
                </div>
            </li>
        </ul>

        <hr>

        <table class="table" id="client-spend-table"
               data-toggle="table"
               data-show-export="true"
               data-search="true"
               data-pagination="true"
               data-show-multi-sort="true"
               data-show-columns="true">
            <thead>
            <tr>
                <th data-field="service" data-sortable="true">Service</th>
                <th data-field="service_type" data-sortable="true">Service Type</th>
                <th data-field="need" data-sortable="true">Need</th>
                <th data-field="start_date" data-sortable="true">Start Date</th>
                <th data-field="end_date" data-sortable="true">End Date</th>
                <th data-field="frequency" data-sortable="true">Cost Frequency</th>
                <th data-formatter="formatSpend" data-field="unit_cost" data-sortable="true">Unit Cost</th>
            </tr>
            </thead>
        </table>



    @endif

@stop

@section('headerScripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
@endsection

@section('footerScripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="/js/tableExport.js"></script>
    <script>
        $("#clientForm").submit(function (event) {
            $(this).attr("action", "/client/" + $("#clientId").val());
        });

        /* Create Object */
                <?php if (isset($clientSpend)) {
                    $clientSpendVar = $clientSpend;
                } else {
                    $clientSpendVar = "''";
                } ?>


        var clientSpend = <?php echo $clientSpendVar; ?>;

        $('#client-spend-table').bootstrapTable({
            data: clientSpend,
            exportDataType: 'all',
        });

        $("#client-spend-table tr td:nth-child(4), #client-spend-table tr td:nth-child(5)").each(function () {
            if ($(this).text() == '-') {

            } else {
                var d = moment($(this).text()).format("DD/MM/YYYY");
                $(this).html(d);
            }
        });

        function formatSpend(value, row, index) {
            return '£' + formatNumber(value);
        }

        function formatNumber(n) {
            return Number(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        }
    </script>
@stop