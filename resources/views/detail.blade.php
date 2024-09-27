@inject('carbon', 'Illuminate\Support\Carbon')

@extends('layout')

@section('title', 'PR Detail: '.$purchase_request->PRNumber)

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
            <table class="table table-bordered mb-0">
                <tr>
                    <th style="width: 150px">Purchase Request</th>
                    <td>
                        <table class="table table-bordered table-sm" style="width: fit-content">
                            <tr>
                                <th>PR Number</th>
                                <td>{{ $purchase_request->PRNumber }}</td>
                            </tr>
                            <tr>
                                <th>PR Create</th>
                                <td>{{ $purchase_request->CreatedBy }} at {{ $purchase_request->formatDate('CreatedDate') }}</td>
                            </tr>
                            <tr>
                                <th>PR Process</th>
                                <td>{{ $purchase_request->ApprovedBy }} at {{ $purchase_request->formatDate('ApprovedDateTime') }}</td>
                            </tr>
                            <tr>
                                <th>Duration Time</th>
                                <td>{{ ceil($carbon::parse($purchase_request->ApprovedDateTime)->diffInHours($carbon::parse($purchase_request->CreateDate))/24) }} Days</td>
                            </tr>
                            <tr>
                                <th>Items</th>
                                <td>
                                    <table class="table table-sm table-bordered mb-0" style="width: fit-content">
                                        <thead>
                                            <tr>
                                                <th>ItemCode</th>
                                                <th>ItemName</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($purchase_request->pritems as $pritem)
                                                <tr>
                                                    <td>{{ $pritem->item?->ItemCode }}</td>
                                                    <td>{{ $pritem->item?->ItemName }}</td>
                                                    <td>{{ number_format($pritem->Quantity) }} {{ $pritem->itemUOM() }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Inquiry</th>
                    <td>
                        @foreach($purchase_request->inquiries as $inquiry)
                            <table class="table table-bordered table-sm" style="width: fit-content">
                                <tr>
                                    <th>Inquiry Number</th>
                                    <td>{{ $inquiry->InquiryNumber }}</td>
                                </tr>
                                <tr>
                                    <th>Inquiry Create</th>
                                    <td>{{ $inquiry->CreatedBy }} at {{ $inquiry->CreateDate }}</td>
                                </tr>
                                <tr>
                                    <th>Inquiry Process</th>
                                    <td>{{ $inquiry->ApprovedBy }} at {{ $inquiry->ApprovedDateTime }}</td>
                                </tr>
                                <tr>
                                    <th>Duration Time</th>
                                    <td>{{ ceil($carbon::parse($inquiry->ApprovedDateTime)->diffInHours($carbon::parse($inquiry->CreateDate))/24) }} Days</td>
                                </tr>
                                <tr>
                                    <th>Items</th>
                                    <td>
                                        <table class="table table-sm table-bordered mb-0" style="width: fit-content">
                                            <thead>
                                                <tr>
                                                    <th>ItemCode</th>
                                                    <th>ItemName</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inquiry->inqitems as $inqitem)
                                                    <tr>
                                                        <td>{{ $inqitem->item?->ItemCode }}</td>
                                                        <td>{{ $inqitem->item?->ItemName }}</td>
                                                        <td>{{ number_format($inqitem->Quantity) }} {{ $inqitem->itemUOM() }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Purchase Order</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Goods Receiving</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>-</td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script> -->
    <script>
    </script>
@endsection