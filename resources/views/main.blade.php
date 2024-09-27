@extends('layout')

@section('title', 'Purchase Monitoring')

@section('styles')
    <style>
        table {
            font-size: .8rem;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row align-items-end" style="gap: 2rem">
                <div>
                    <p class="font-weight-bold">PR Process Date</p>
                    <div class="d-inline-flex align-items-center" style="gap: 1rem">
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
            </div>
            <hr>
            <table id="table-main" class="table table-striped table-bordered text-nowrap">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Purchase Request</th>
                        <th>Inquiry</th>
                        <th>Purchase Order</th>
                        <th>Goods Receiving</th>
                        <th>Total Leased Time</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table = null;

        $(document).ready(function() {
            table = $('#table-main').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ url('/') }}" + '/main-datatable',
                    data: function(d) {
                        d.filters = {
                            pr_date_start: $('#filter-pr-date-start').val(),
                            pr_date_end: $('#filter-pr-date-end').val(),
                            pr_department: $('#filter-department').val(),
                        };
                    }
                },
                order: [[1, 'asc']],
                // ordering: false,
                stateSave: false,
                pageLength: 100,
                lengthMenu: [ [100, -1], [100, "All"] ],
                columns: [
                    {
                        data: 'PRRequestByName',
                        orderable: false,
                    },
                    {
                        // Purchase Request Column
                        data: 'PRNumber',
                        render: (data, _, row) => {
                            if (data) {
                                return `
                                    PR Number: ${row.PRNumber}<br>
                                    Item Quantity: ${row.PRItemCount}<br>
                                    Create Date: ${moment(row.PRCreateDate).format('DD/MM/YYYY')}<br>
                                    Process Date: ${row.PRApprovedDateTime ? moment(row.PRApprovedDateTime).format('DD/MM/YYYY') : '-'}<br>
                                    Leased Time: ${Math.ceil(moment(row.PRApprovedDateTime ?? Date.now()).diff(moment(row.PRCreateDate), 'days', true))} Days
                                `;
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
                                return `
                                    Inquiry Number: ${row.InquiryNumber}<br>
                                    Item Quantity: ${row.InqItemCount}<br>
                                    Create Date: ${moment(row.InqCreateDate).format('DD/MM/YYYY')}<br>
                                    Process Date: ${row.InqApprovedDateTime ? moment(row.InqApprovedDateTime).format('DD/MM/YYYY') : '-'}<br>
                                    Leased Time: ${Math.ceil(moment(row.InqApprovedDateTime ?? Date.now()).diff(moment(row.InqCreateDate), 'days', true))} Days
                                `;
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
                                return `
                                    PO Number: ${row.PONumber}<br>
                                    Item Quantity: ${row.POItemCount}<br>
                                    Create Date: ${moment(row.POCreateDate).format('DD/MM/YYYY')}<br>
                                    Manager Approve Date: ${row.POManApprovedDateTime ? moment(row.POManApprovedDateTime).format('DD/MM/YYYY') : '-'}<br>
                                    Director Approve Date: ${row.PODirApprovedDateTime ? moment(row.PODirApprovedDateTime).format('DD/MM/YYYY') : '-'}<br>
                                    Leased Time: ${Math.ceil(moment(row.PODirApprovedDateTime ?? Date.now()).diff(moment(row.POCreateDate), 'days', true))} Days
                                `;
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
                                return `
                                    GRN Number: ${row.PurchaseNumber}<br>
                                    Item Quantity: ${row.PIItemCount}<br>
                                    Create Date: ${moment(row.PICreateDate).format('DD/MM/YYYY')}
                                `;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'PRNumber',
                        orderable: false,
                        render: (data, _, row) => {
                            return Math.ceil(moment(row.PICreateDate ?? Date.now()).diff(moment(row.PRCreateDate), 'days', true)) + ' Days';
                        }
                    }
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
                            window.location.href = baseURL + '/main-export';
                        }
                    },
                ],
            });

            $('#btn-filter').click(() => {table.ajax.reload()});
        });
    </script>
@endsection