@extends('layout')

@section('title', 'Purchase Monitoring')


@section('styles')
    <!-- <link rel="stylesheet" href="http://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css"> -->
    <style>
        body {
            font-size: .9rem;
        }
        table {
            font-size: .8rem;
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
                    <p class="font-weight-bold">Closed Status</p>
                    <select id="filter-closed" class="form-control form-control-sm" aria-label="Default select example">
                        <option value="ALL" selected>ALL</option>
                        <option value="0">Open</option>
                        <option value="1">Close</option>
                    </select>
                </div>
                <div>
                    <button id="btn-filter" class="btn btn-primary btn-sm">Filter</button>
                </div>
            </div>
            <hr>
            <table id="table-master" class="table table-bordered table-striped text-nowrap display" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <!-- <th>Department</th> -->
                        <th style="width: 363px">Purchase Request</th>
                        <th style="width: 363px">Inquiry / VASF</th>
                        <th style="width: 363px">Purchase Order</th>
                        <th style="width: 363px">Goods Receiving</th>
                        <th style="width: 363px">Summary</th>
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
                    // {
                    //     data: 'PRRequestByName',
                    //     orderable: false,
                    // },
                    {
                        // Purchase Request Column
                        data: 'PRNumber',
                        render: (data, _, row) => {
                            if (data) {
                                return `<div>
                                    <a href="{{ url('detail') }}/${row.PRID}"><strong>${row.PRNumber}</strong></a><br><br>
                                    ${ row.PRRemarks != '' ? '<p style="width: 200px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">'+row.PRRemarks+'</p>' : '' }
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Item Quantity</th>
                                            <td>${row.PRItemCount}</td>
                                        </tr>
                                        <tr>
                                            <th>Create Date</th>
                                            <td>${moment(row.PRCreateDate).format('DD/MM/YYYY HH:mm')}</td>
                                        </tr>
                                        <tr>
                                            <th>Mgr Approve</th>
                                            <td>${ row.PRManApprovedBy ? row.PRManApprovedBy+' at ' : '' } ${row.PRManApprovedDateTime ? moment(row.PRManApprovedDateTime).format('DD/MM/YYYY HH:mm') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Procurement Process</th>
                                            <td>${ row.PRApprovedBy ? row.PRApprovedBy+' at ' : '' } ${row.PRApprovedDateTime ? moment(row.PRApprovedDateTime).format('DD/MM/YYYY HH:mm') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Duration Time</th>
                                            <td>${ row.PRApprovedDateTime ? Math.ceil(moment(row.PRApprovedDateTime ?? Date.now()).diff(moment(row.PRCreateDate), 'days', true)).toString()+' Days' : '-' }</td>
                                        </tr>
                                    </table>
                                </div>`;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        // Inquiry Column
                        data: 'InquiryNumber',
                        render: (data, _, row) => {
                            if (data) {
                                return `<div>
                                    <strong>${row.InquiryNumber}</strong><br><br>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Item Quantity</th>
                                            <td>${row.InqItemCount}</td>
                                        </tr>
                                        <tr>
                                            <th>Create Date</th>
                                            <td>${moment(row.InqCreateDate).format('DD/MM/YYYY HH:mm')}</td>
                                        </tr>
                                        <tr>
                                            <th>Approve Date</th>
                                            <td>${ row.InqApprovedBy ? row.InqApprovedBy+' at ' : '' } ${row.InqApprovedDateTime ? moment(row.InqApprovedDateTime).format('DD/MM/YYYY HH:mm') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Duration Time</th>
                                            <td>${ row.InqApprovedDateTime ? Math.ceil(moment(row.InqApprovedDateTime ?? Date.now()).diff(moment(row.InqCreateDate), 'days', true)).toString()+' Days' : '-' }</td>
                                        </tr>
                                    </table>
                                </div>`;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        // Purchase Order Column
                        data: 'PONumber',
                        render: (data, _, row) => {
                            if (data) {
                                return `<div>
                                    <strong>${row.PONumber}</strong><br><br>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Item Quantity</th>
                                            <td>${row.POItemCount}</td>
                                        </tr>
                                        <tr>
                                            <th>Create Date</th>
                                            <td>${moment(row.POCreateDate).format('DD/MM/YYYY HH:mm')}</td>
                                        </tr>
                                        <tr>
                                            <th>GM Approve Date</th>
                                            <td>${ row.POManApprovedBy ? row.POManApprovedBy+' at ' : '' } ${row.POManApprovedDateTime ? moment(row.POManApprovedDateTime).format('DD/MM/YYYY HH:mm') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Director Approve Date</th>
                                            <td>${ row.PODirApprovedBy ? row.PODirApprovedBy+' at ' : '' } ${row.PODirApprovedDateTime ? moment(row.PODirApprovedDateTime).format('DD/MM/YYYY HH:mm') : '-'}</td>
                                        </tr>
                                        <tr>
                                            <th>Duration Time</th>
                                            <td>${ row.PODirApprovedDateTime ? Math.ceil(moment(row.PODirApprovedDateTime ?? Date.now()).diff(moment(row.POCreateDate), 'days', true)).toString()+' Days' : '-' }</td>
                                        </tr>
                                    </table>
                                </div>`;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        // Purchase Invoice Column
                        data: 'PurchaseNumber',
                        render: (data, _, row) => {
                            if (data) {
                                return `<div>
                                    <strong>${row.PurchaseNumber}</strong><br><br>
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Item Quantity</th>
                                            <td>${row.PIItemCount}</td>
                                        </tr>
                                        <tr>
                                            <th>Create Date</th>
                                            <td>${moment(row.PICreateDate).format('DD/MM/YYYY HH:mm')}</td>
                                        </tr>
                                    </table>
                                </div>`;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'PRNumber',
                        orderable: false,
                        render: (data, _, row) => {
                            const PRApproved = row.PRApprovedDateTime != null;
                            const InqApproved = row.InqApprovedDateTime != null;
                            const POApprovedMan = (row.POManApprovedBy != null && row.POManApprovedBy != '');
                            const POApprovedDir = row.PODirApprovedDateTime != null;
                            const GoodReceived = row.PICreateDate != null;

                            const POCreateToApproveMgrDays = Math.ceil(moment(row.POManApprovedDateTime).diff(moment(row.POCreateDate), 'days', true));
                            const POApproveMgrToApproveDirDays = Math.ceil(moment(row.PODirApprovedDateTime).diff(moment(row.POManApprovedDateTime), 'days', true));
                            const POApprovedDirToGoodReceived = Math.ceil(moment(row.PICreateDate).diff(moment(row.PODirApprovedDateTime), 'days', true));

                            return `<div>
                                <strong>PR Process to PO Created</strong><br> ${
                                    row.PRApprovedDateTime ? `
                                        <span class="badge badge-${Math.ceil(moment(row.POCreateDate ?? Date.now()).diff(moment(row.PRApprovedDateTime), 'days', true)) > 7 ? 'danger' : 'success'}">
                                            ${Math.ceil(moment(row.POCreateDate ?? Date.now()).diff(moment(row.PRApprovedDateTime), 'days', true))} Days
                                        </span>
                                    ` : ''
                                }
                                ${PRApproved ? '<span class="badge badge-success">PR Processed</span>' : '<span class="badge badge-danger">PR Waiting to Processed by Procurement</span>'}
                                ${InqApproved ? '<span class="badge badge-success">Inquiry Approved</span>' : '<span class="badge badge-danger">Inquiry Waiting Approval</span>'}
                                <br><br>
                                <strong>PO Created to PO Approved Mgr</strong><br> ${
                                    row.POManApprovedDateTime ? `
                                        <span class="badge badge-${ POCreateToApproveMgrDays > 7 ? 'danger' : 'success'}">
                                            ${POCreateToApproveMgrDays} Days
                                        </span>
                                    ` : ''
                                }
                                ${POApprovedMan ? '<span class="badge badge-success">PO Approved Manager</span>' : '<span class="badge badge-danger">PO Waiting Manager Approval</span>'}
                                <br><br>
                                <strong>PO Approved Mgr to PO Approved Dir</strong><br> ${
                                    row.PODirApprovedDateTime ? `
                                        <span class="badge badge-${ POApproveMgrToApproveDirDays > 7 ? 'danger' : 'success'}">
                                            ${POApproveMgrToApproveDirDays} Days
                                        </span>
                                    ` : ''
                                }
                                ${POApprovedDir ? '<span class="badge badge-success">PO Approved Director</span>' : '<span class="badge badge-danger">PO Waiting Director Approval</span>'}
                                <br><br>
                                <strong>PO Approved Dir to Good Received</strong><br> ${
                                    row.PICreateDate ? `
                                        <span class="badge badge-${ POApprovedDirToGoodReceived > 7 ? 'danger' : 'success'}">
                                            ${POApprovedDirToGoodReceived} Days
                                        </span>
                                    ` : ''
                                }
                                ${GoodReceived ? '<span class="badge badge-success">Goods Received</span>' : '<span class="badge badge-danger">Goods Not Yet Received</span>'}
                                <br><br>
                                <strong>Total Length of Time</strong><br> ${Math.ceil(moment(row.PICreateDate ?? Date.now()).diff(moment(row.PRCreateDate), 'days', true))} Days
                            </div>`;
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
                            window.location.href = baseURL + '/master-export';
                        }
                    },
                ],
            });

            $('#btn-filter').click(() => {table.ajax.reload()});
        });
    </script>
@endsection