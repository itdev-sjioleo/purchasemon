@extends('layout')

@section('title', 'Auth Log')

@section('styles')
    <!-- <link rel="stylesheet" href="http://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css"> -->
    <style>
        body {
            font-size: .9rem;
        }
        table {
            font-size: .8rem;
        }
        .single-line-ellipsis {
            width: 200px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('content')
    <div class="card" style="max-width: 1920px; margin: 0 auto;">
        <div class="card-body">
            <table id="table-master" class="table table-bordered table-striped nowrap" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Timestamp</th>
                        <th>username</th>
                        <th>event_type</th>
                        <th>ip_address</th>
                        <th>user_agent</th>
                        <th>notes</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script> -->
    <script>
        let table = null;

        $(document).ready(function() {
            table = $('#table-master').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('/') }}" + '/auth-log-datatable'
                },
                order: [[0, 'desc']],
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        data: 'timestamp',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY HH:mm') : '';
                        }
                    },
                    {data: 'username'},
                    {data: 'event_type'},
                    {data: 'ip_address'},
                    {data: 'user_agent'},
                    {data: 'notes'}
                ],
                dom: `
                    <'row'
                        <'col-auto flex-grow-1'
                            <'d-flex flex-row'
                                <l>
                                <'ml-5'f>
                            >
                        >
                        <'col-auto'B>
                    >
                    <'row'
                        <'col-sm-12'tr>
                    >
                    <'row'
                        <'col-sm-12 col-md-5'i>
                        <'col-sm-12 col-md-7'p>
                    >
                `,
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export Excel',
                        className: 'btn btn-primary btn-sm'
                    }
                    // {
                    //     extend: 'excel',
                    //     text: 'Export All',
                    //     className: 'btn btn-primary btn-sm',
                    //     action: function () {
                    //         window.location.href = baseURL + '/master-export?'
                    //             + $.param({
                    //                 filters: {
                    //                     pr_date_start: $('#filter-pr-date-start').val(),
                    //                     pr_date_end: $('#filter-pr-date-end').val(),
                    //                     pr_department: $('#filter-department').val(),
                    //                     pr_closed: $('#filter-closed').val(),
                    //                     pr_created_to_pr_approved_mgr: $('#filter-pr_created-pr_approved_mgr').val(),
                    //                     pr_approved_mgr_to_pr_process: $('#filter-pr_approved_mgr-pr_process').val(),
                    //                     pr_process_to_po_created: $('#filter-pr_process-po_created').val(),
                    //                     po_created_to_po_approved_mgr: $('#filter-po_created-po_approved_mgr').val(),
                    //                     po_approved_mgr_to_po_approved_dir: $('#filter-po_approved_mgr-po_approved_dir').val(),
                    //                     po_approved_mgr_to_good_received: $('#filter-po_approved_mgr-good_received').val(),
                    //                     total_length_time: $('#filter-length-time').val(),
                    //                 }
                    //             });
                    //     }
                    // },
                ],
            });
        });
    </script>
@endsection