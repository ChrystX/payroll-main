@extends('layouts.main')
@section('title', 'Payment Logbook')

@section('content')
<!-- Month Selector and Export Button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <label for="monthSelector">Select Month:</label>
        <input type="month" id="monthSelector" class="form-control d-inline-block" style="width: 200px;" />
    </div>
    <button class="btn btn-primary">Export to PDF</button>
</div>

<hr />

<!-- Payment Records Table -->
<h3>Logbook</h3>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Target Account</th>
                <th>Worker's ID</th>
                <th>Source Account</th>
                <th>Date</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>987654321</td>
                <td>101</td>
                <td>123456789</td>
                <td>2024-10-10</td>
                <td>{{ number_format(1500, 2) }}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>876543210</td>
                <td>102</td>
                <td>123456789</td>
                <td>2024-11-05</td>
                <td>{{ number_format(1200, 2) }}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>765432109</td>
                <td>103</td>
                <td>987654321</td>
                <td>2024-11-03</td>
                <td>{{ number_format(1800, 2) }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
