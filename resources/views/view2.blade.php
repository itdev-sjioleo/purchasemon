@extends('layout')

@section('title', 'Summary View')

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
            <div class="d-flex flex-row align-items-end flex-wrap" style="gap: 2rem">
                <div>
                    <p class="font-weight-bold">PR Create Date</p>
                    <div class="d-inline-flex align-items-center flex-wrap" style="gap: 1rem">
                        <div>
                            From
                        </div>
                        <div>
                            <input id="filter-pr-date-start" type="date" class="form-control form-control-sm">
                        </div>
                        <div>
                            To
                        </div>
                        <div>
                            <input id="filter-pr-date-end" type="date" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div>
                    <p class="font-weight-bold">Department</p>
                    <select id="filter-department" class="form-control form-control-sm" aria-label="Default select example">
                        <option value="ALL_DEPARTMENT" selected>ALL DEPARTMENT</option>
                        <option value="REF & FRAC">REF & FRAC</option>
                        <option value="TANK FARM">TANK FARM</option>
                        <option value="BOILER">BOILER</option>
                        <option value="LABORATORIUM">LABORATORIUM</option>
                        <option value="GENERAL AFFAIR">GENERAL AFFAIR</option>
                        <option value="MAINTENANCE & EI">MAINTENANCE & EI</option>
                        <option value="IT">IT</option>
                        <option value="HSE">HSE</option>
                        <option value="UTILITY">UTILITY</option>
                        <option value="WAREHOUSE">WAREHOUSE</option>
                        <option value="HRD">HRD</option>
                        <option value="FRAKSINASI">FRAKSINASI</option>
                        <option value="PROJECT">PROJECT</option>
                        <option value="OFFICE HO">OFFICE HO</option>
                        <option value="LOGISTIC">LOGISTIC</option>
                        <option value="LEGAL & REGULATION">LEGAL & REGULATION</option>
                        <option value="COMMERCIAL">COMMERCIAL</option>
                    </select>
                </div>
                <div>
                    <button id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
                </div>
                <div class="d-none">
                    <p class="font-weight-bold">Closed Status</p>
                    <select id="filter-closed" class="form-control form-control-sm" aria-label="Default select example">
                        <option value="ALL" selected>ALL</option>
                        <option value="0">Open</option>
                        <option value="1">Close</option>
                    </select>
                </div>
            </div>
            <!-- <hr class="mt-3 mb-3" /> -->
            <p class="d-none font-weight-bold">Time Duration Days (Greather Than)</p>
            <div class="d-none flex-row align-items-end flex-wrap" style="gap: 2rem">
                <div>
                    <p class="font-weight-bold">PR Created to PR Approved Mgr</p>
                    <input id="filter-pr_created-pr_approved_mgr" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">PR Approved Mgr to PR Process</p>
                    <input id="filter-pr_approved_mgr-pr_process" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">PR Process to PO Created</p>
                    <input id="filter-pr_process-po_created" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">PO Created to PO Approved Mgr</p>
                    <input id="filter-po_created-po_approved_mgr" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">PO Approved Mgr to PO Approved Dir</p>
                    <input id="filter-po_approved_mgr-po_approved_dir" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">PO Approved Dir to Good Received</p>
                    <input id="filter-po_approved_mgr-good_received" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <p class="font-weight-bold">Total Length of Time</p>
                    <input id="filter-length-time" class="form-control form-control-sm" type="number" />
                </div>
                <div>
                    <button id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
                    <button id="btn-clear-filter" class="btn btn-primary btn-sm">Clear Filter</button>
                </div>
            </div>
            <hr>
            <table id="table-master" class="table table-bordered table-striped nowrap" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th>Purchase Request</th>
                        <th>Title</th>
                        <th>PR Create</th>
                        <th>PR Approval 1</th>
                        <th>PR Approval 2</th>
                        <th>PO Create</th>
                        <th>PO Approval 1</th>
                        <th>PO Approval 2</th>
                        <th>ETA</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th>Update</th>
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
                    url: "{{ url('/') }}" + '/master-datatable',
                    data: function(d) {
                        d.filters = {
                            pr_date_start: $('#filter-pr-date-start').val(),
                            pr_date_end: $('#filter-pr-date-end').val(),
                            pr_department: $('#filter-department').val(),
                            pr_closed: $('#filter-closed').val(),
                            pr_created_to_pr_approved_mgr: $('#filter-pr_created-pr_approved_mgr').val(),
                            pr_approved_mgr_to_pr_process: $('#filter-pr_approved_mgr-pr_process').val(),
                            pr_process_to_po_created: $('#filter-pr_process-po_created').val(),
                            po_created_to_po_approved_mgr: $('#filter-po_created-po_approved_mgr').val(),
                            po_approved_mgr_to_po_approved_dir: $('#filter-po_approved_mgr-po_approved_dir').val(),
                            po_approved_mgr_to_good_received: $('#filter-po_approved_mgr-good_received').val(),
                            total_length_time: $('#filter-length-time').val(),
                        };
                    }
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                ],
                fixedColumns: {
                    start: 1,
                },
                autoWidth: false,
                // responsive: true,
                order: [[0, 'asc']],
                // ordering: false,
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        data: 'PRNumber',
                        render: (data, _, row) => {
                            return `<a href="{{ url('detail') }}/${row.PRID}"><strong>${row.PRNumber}</strong></a>`;
                        }

                    },
                    {
                        data: 'PRRemarks',
                        render: (data) => {
                            return `<div class="single-line-ellipsis">${data}</div>`;
                        }
                    },
                    {
                        data: 'PRCreateDate',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'PRManApprovedDateTime',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'PRApprovedDateTime',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'POCreateDate',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'POManApprovedDateTime',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'PODirApprovedDateTime',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'POExpectedDelivery',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {
                        data: 'PRRequiredDate',
                        render: (data) => {
                            return data ? moment(data).format('DD/MM/YYYY') : '';
                        }
                    },
                    {data: 'PRImportance'},
                    {
                        data: 'PRNumber',
                        orderable: false,
                        render: (data, _, row) => {
                            const PRApprovedMan = row.PRManApprovedDateTime != null;
                            const PRApproved = row.PRApprovedDateTime != null;
                            const InqCreated = row.InqCreateDate != null;
                            const InqApproved = row.InqApprovedDateTime != null;
                            const POCreated = row.POCreateDate != null;
                            const POApprovedMan = (row.POManApprovedBy != null && row.POManApprovedBy != '');
                            const POApprovedDir = row.PODirApprovedDateTime != null;
                            const GoodReceived = row.PICreateDate != null;
                            
                            if (!PRApprovedMan) return 'Waiting PR Approval 1';
                            if (!PRApproved) return 'Waiting PR Approval 2';
                            if (!POCreated) return 'Waiting PO Created';
                            if (!POApprovedMan) return 'Waiting PO Approval 1';
                            if (!POApprovedDir) return 'Waiting PO Approval 2';
                            if (!GoodReceived) return 'Waiting for Goods Received';
                            
                            return 'Completed';
                        }
                    }
                ],
                scrollCollapse: true,
                scrollX: true,
                scrollY: 800,
                initComplete: function () {
                    // this.api()
                    //     .columns()
                    //     .every(function () {
                    //         let column = this;
                    //         let title = column.footer().textContent;
            
                    //         // Create input element
                    //         let input = document.createElement('input');
                    //         input.placeholder = title;
                    //         input.classList.add('form-control');
                    //         column.footer().replaceChildren(input);
            
                    //         // Event listener for user input
                    //         input.addEventListener('keyup', () => {
                    //             if (column.search() !== this.value) {
                    //                 column.search(input.value).draw();
                    //             }
                    //         });
                    //     });
                },
                dom: `
                    <'row'
                        <'col-auto flex-grow-1'l>
                        <'col-auto'f>
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
                        text: 'Export All',
                        className: 'btn btn-primary btn-sm',
                        action: function () {
                            window.location.href = baseURL + '/master-export?'
                                + $.param({
                                    filters: {
                                        pr_date_start: $('#filter-pr-date-start').val(),
                                        pr_date_end: $('#filter-pr-date-end').val(),
                                        pr_department: $('#filter-department').val(),
                                        pr_closed: $('#filter-closed').val(),
                                        pr_created_to_pr_approved_mgr: $('#filter-pr_created-pr_approved_mgr').val(),
                                        pr_approved_mgr_to_pr_process: $('#filter-pr_approved_mgr-pr_process').val(),
                                        pr_process_to_po_created: $('#filter-pr_process-po_created').val(),
                                        po_created_to_po_approved_mgr: $('#filter-po_created-po_approved_mgr').val(),
                                        po_approved_mgr_to_po_approved_dir: $('#filter-po_approved_mgr-po_approved_dir').val(),
                                        po_approved_mgr_to_good_received: $('#filter-po_approved_mgr-good_received').val(),
                                        total_length_time: $('#filter-length-time').val(),
                                    }
                                });
                        }
                    },
                ],
            });

            $('#btn-filter').click(() => {table.ajax.reload()});

            $('#btn-clear-filter').click(() => {
                $('#filter-pr-date-start').val('');
                $('#filter-pr-date-end').val('');
                $('#filter-department').val('ALL_DEPARTMENT');
                $('#filter-closed').val('ALL');
                $('#filter-pr_created-pr_approved_mgr').val('');
                $('#filter-pr_approved_mgr-pr_process').val('');
                $('#filter-pr_process-po_created').val('');
                $('#filter-po_created-po_approved_mgr').val('');
                $('#filter-po_approved_mgr-po_approved_dir').val('');
                $('#filter-po_approved_mgr-good_received').val('');
                $('#filter-length-time').val('');
            });
        });
    </script>
@endsection