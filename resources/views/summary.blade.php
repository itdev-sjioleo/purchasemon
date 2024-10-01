@extends('layout')

@section('title', 'Purchase Monitoring')


@section('styles')
    <!-- <link rel="stylesheet" href="http://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css"> -->
    <style>
        table {
            font-size: .8rem;
        }
    </style>
@endsection

@section('content')
    <div class="card">
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
            <table id="table-summary" class="table table-bordered text-nowrap display" width="100%">
                <thead>
                    <tr>
                        <th>Purchase Request</th>
                        <th>Inquired</th>
                        <th>PO Issued</th>
                        <th>PO Approved</th>
                        <th>Good Received</th>
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
            table = $('#table-summary').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('/') }}" + '/summary-datatable',
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
                // responsive: true,
                order: [[0, 'asc']],
                // ordering: false,
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        // Purchase Request Column
                        data: 'PRNumber',
                        render: (data, _, row) => {
                            return `<div>
                                <a href="{{ url('detail') }}/${row.PRID}"><strong>${row.PRNumber}</strong></a><br>
                                ${row.PRImportance}<br>
                                ${row.PRItemCount} Item</br>
                                Processed at ${moment(row.PRApprovedDateTime).format('DD/MM/YYYY HH:mm')}
                            </div>`;
                        }
                    },
                    {
                        // Inquiry Column
                        render: (data, _, row) => {
                            return `<div>
                                <strong>${row.InqItemCount} / ${row.PRItemCount} Item</strong><br>
                                ${row.InqLastTime ?
                                    `Last Inquired at ${moment(row.InqLastTime).format('DD/MM/YYYY HH:mm')}`
                                    : ''
                                }
                            </div>`;
                        }
                    },
                    {
                        // Purchase Order Column
                        render: (data, _, row) => {
                            return `<div>
                                <strong>${row.POItemCount} / ${row.PRItemCount} Item</strong><br>
                                ${row.POLastTime ?
                                    `Last PO Issued at ${moment(row.POLastTime).format('DD/MM/YYYY HH:mm')}`
                                    : ''
                                }
                            </div>`;
                        }
                    },
                    {
                        // Purchase Order Approved Column
                        render: (data, _, row) => {
                            return `<div>
                                <strong>${row.POApproveItemCount} / ${row.PRItemCount} Item</strong><br>
                                ${row.POApproveLastTime ?
                                    `Last PO Approved at ${moment(row.POApproveLastTime).format('DD/MM/YYYY HH:mm')}`
                                    : ''
                                }
                            </div>`;
                        }
                    },
                    {
                        // Purchase Invoice Column
                        render: (data, _, row) => {
                            return `<div>
                                <strong>${row.PIPercent * 100}%</strong><br>
                                ${row.PILastTime ?
                                    `Last Received at ${moment(row.PILastTime).format('DD/MM/YYYY HH:mm')}`
                                    : ''
                                }
                            </div>`;
                        }
                    },
                ],
                scrollCollapse: true,
                scrollX: true,
                scrollY: 600,
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
                            window.location.href = baseURL + '/summary-export';
                        }
                    },
                ],
            });

            $('#btn-filter').click(() => {table.ajax.reload()});
        });
    </script>
@endsection