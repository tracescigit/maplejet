@extends('dummy.app_new')

@section('content')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"> -->
<style>
    /* Custom styles */
    body {
        font-family: 'Numans', sans-serif;
        background-color: #f8f9fa;
        /* Light gray background */
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .card-header {
        background-color: #6c757d;
        color: #fff;
        border-bottom: none;
    }

    .head-print {
        font-size: 30px;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-custom {
        background: linear-gradient(45deg, #700877 0%, #ff2759 100%);
        color: white;
        border-radius: 5px;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-custom:hover {
        background-color: #8a0278;
    }

    .table {
        margin-top: 20px;
    }

    .checkdiv {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .checkdiv span {
        margin-left: 10px;
    }

    .le-checkbox {
        appearance: none;
        position: relative;
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid #ccc;
        cursor: pointer;
    }

    .le-checkbox:checked {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .camera-status {
        font-weight: bold;
    }
</style>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <div id="hello"></div>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="container mt-4">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card pd-20 mg-t-10 col-11 mx-auto">
                <div class="content-header">
                    <h2 class="head-print">Print Module</h2>

                    <button class="btn btn-custom ml-auto mb-2" type="button" onclick="downloadexcel()">
                        Download job Excel
                    </button>

                </div>
                <div class="card-body">
                    @if(session('status'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('jobs.store') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="job" class="form-label">Select Job</label>
                                <select name="job" id="job" class="form-control">
                                    <option value="">Please select</option>
                                    @foreach($job as $value)
                                    <option value="{{ $value->id }}">{{ $value->code }}</option>
                                    @endforeach
                                </select>
                                <div id="job_error" style="color: red;"></div>
                            </div>

                        </div>


                        <div class="col-md-8 mx-auto">
                            <table class="table table-bordered table-striped">
                                <tbody id="table-body">
                                    <tr>
                                        <td><strong>Batch:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>MFG date:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>EXP Date:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Price:</strong></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Link:</strong></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="checkdiv mx-4 ">
                                <input type="checkbox" class="le-checkbox thisonetocheck" disabled>
                                <span class="camera-status">Printer Connected Status</span>
                            </div>
                            <div class="checkdiv mx-4">
                                <input type="checkbox" class="le-checkbox thiscameratocheck" disabled>
                                <span class="camera-status">Camera Connected Status</span>
                            </div>

                            <div id="message" style="color:green"></div>
                            <div id="message_error" style="color:red"></div>
                        </div>
                        <div class="text-center mb-3 col-12 mt-2">
                            <button class="btn btn-success start-print mx-auto" type="button" onclick="ajaxfunction()">Start Print</button>
                            <button class="btn btn-danger button-print mx-3" type="button" onclick="ajaxfunctionstop()">Stop Print</button>
                        </div>


                        <div class="row mt-5">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold text-center mb-3">Camera Data Log</h3>
                                <table id="camera-data-table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Serial No</th>
                                            <th>Message</th>
                                            <th>Data</th>
                                            <th>Current Time</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Rows will be added here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $('.alert').hide();
    var data = '';
    $(document).ready(function() {
        $('#job').change(function() {
            var jobId = $(this).val();
            if (jobId) {
                $.ajax({
                    url: '{{route("print_job")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId
                    },
                    timeout: 300000,
                    success: function(response) {
                        data = response;
                        console.log(response);
                        $('#table-body').html('');

                        function formatDate(dateString) {
                            var date = new Date(dateString);
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                            ];
                            var month = monthNames[date.getMonth()];
                            var year = date.getFullYear();
                            return month + '-' + year;
                        }
                        var html = '<tr>' +
                            '<td><strong>Batch:</strong></td>' +
                            '<td>' + response.batches_name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>MFG date:</strong></td>' +
                            '<td>' + formatDate(response.mfg_date) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>EXP Date:</strong></td>' +
                            '<td>' + formatDate(response.exp_date) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>Price:</strong></td>' +
                            '<td>' + response.price + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><strong>Link:</strong></td>' +
                            '<td>' + response.url + '</td>' +
                            '</tr>';
                        $('#table-body').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                console.log('Please select a job');
            }
        });

    });

    function ajaxfunction() {
        if (data) {
            var jobId = $('#job').val();
            if (data.printer_name) {
                $.ajax({
                    url: '{{route("checkprintconnection")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId,
                        data: data
                    },
                    timeout: 300000,
                    success: function(response) {
                        console.log(response);
                        if (response.message == 'Printer connected successfully!') {
                            checkedbox();

                            $.ajax({
                                url: '{{route("SendPrintData")}}',
                                type: 'GET',
                                data: {
                                    job_id: jobId,
                                    data: data
                                },
                                success: function(response) {
                                    console.log(response);
                                    $('#message').html();
                                    $('#message').html(response);
                                    setTimeout(function() {
                                        $('#message').text('');
                                    }, 10000);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {
                            uncheckedbox();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {

                $.ajax({
                    url: '{{route("checkprintconnection")}}',
                    type: 'GET',
                    data: {
                        job_id: jobId,
                        data: data
                    },
                    timeout: 300000,
                    success: function(response) {
                        if (response.message == 'Printer connected successfully!') {

                            $.ajax({
                                url: '{{route("SendPrintData")}}',
                                type: 'GET',
                                data: {
                                    job_id: jobId,
                                    data: data
                                },
                                success: function(response) {
                                    console.log(response);
                                    $('#message').html();
                                    $('#message').html(response);
                                    setTimeout(function() {
                                        $('#message').text('');
                                    }, 10000);

                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        } else {
            $('#job_error').html();
            $('#job_error').text("Please Select a Job First");
            setTimeout(function() {
                $('#job_error').text('');
            }, 10000);
        }

    }

    function ajaxfunctionstop() {
        if (data) {
            var jobId = $('#job').val();
            $.ajax({
                url: '{{route("stopprint")}}',
                type: 'GET',
                data: {
                    job_id: jobId,
                    data: data
                },
                timeout: 300000,
                success: function(response) {
                    console.log(response.message);
                    $('#hello').html('');
                    $('#message').html('');
                    $('#hello').text(response.message);
                    $('.alert').show();
                    uncheckedbox();

                    setTimeout(function() {
                        $('.alert').hide();
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#job_error').html();
            $('#job_error').text("Please Select a Job First");
            setTimeout(function() {
                $('#job_error').text('');
            }, 5000);
        }
    }

    function downloadexcel() {
        console.log(data); // Ensure 'data' is defined and correct

        if (data) {
            var jobId = $('#job').val();

            $.ajax({
                url: '{{ route("downloadexcell") }}',
                type: 'GET',
                data: {
                    job_id: jobId,
                    data: data
                },
                xhrFields: {
                    responseType: 'blob' // Set the response type to blob (binary data)
                },
                success: function(blob) { // Corrected: Use 'blob' as parameter here
                    var url = window.URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'jobdataexcel.xlsx'; // Set the filename for download
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    console.log('Excel file exported successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error exporting Excel file:', error);
                }
            });
        }else{
            $('#job_error').html();
            $('#job_error').text("Please Select a Job First");
            setTimeout(function() {
                $('#job_error').text('');
            }, 5000);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {

        const ws = new WebSocket('ws://localhost:6001'); // WebSocket server URL
        const responseContainer = document.getElementById('camera-data-table');

        ws.onopen = function() {
            console.log('WebSocket connection established');
            thiscameratocheck();
        };

        let serialNo = 1;
        ws.onmessage = function(event) {
            var jobId = $('#job').val();
            const message = event.data;
            console.log('Received message:', message);
            if (event.data === '{"isCameraConnected":true}') {
                thiscameratocheck();
            } else {


                if (message && jobId) {

                    $.ajax({
                        url: '{{route("cameradatacheck")}}',
                        type: 'GET',
                        data: {
                            message: message,
                            job_id: jobId,
                            data: data
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.message != 'All correct') {
                                appendToTable(serialNo++, response.message, response.data, new Date().toLocaleString(), response.remark || '');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX request failed:', xhr.responseText);
                        }
                    });
                } else {
                    $('#job_error').html();
                    $('#job_error').text("Receiving data from Camera Please Select a Job");
                    setTimeout(function() {
                        $('#job_error').text('');
                    }, 10000);
                }
            }

        };


        ws.onerror = function(error) {
            console.error('WebSocket error:', error);
        };

        ws.onclose = function() {
            console.log('WebSocket connection closed');
            thiscameratouncheck();
        };
    });

    function appendToTable(serialNo, message, data, currentTime, remark) {
        const tableBody = $('#camera-data-table tbody');
        const newRow = `
        <tr>
            <td>${serialNo}</td>
            <td>${message}</td>
            <td>${data}</td>
            <td>${currentTime}</td>
            <td>${remark}</td>
        </tr>
    `;
        tableBody.append(newRow);
    }
</script>
<script>
    pentitle = "Checkboxes";

    function checkedbox() {
        $('.thisonetocheck').prop('checked', true);
    }

    function uncheckedbox() {
        $('.thisonetocheck').prop('checked', false);
    }

    function thiscameratocheck() {
        $('.thiscameratocheck').prop('checked', true);
    }

    function thiscameratouncheck() {
        $('.thiscameratocheck').prop('checked', false);
    }
</script>

<script>
    // $(document).ready(function() {
    //     // Function to check camera connection status
    //     function checkCameraConnection() {
    //         $.ajax({
    //             url: '{{ route("dashboard.checkConnection") }}',
    //             type: 'GET',
    //             dataType: 'json',
    //             success: function(response) {
    //                 console.log(response);
    //                 if (response.isCameraConnected) {
    //                     $('#connectionStatus').text('Camera is connected.');
    //                 } else {
    //                     $('#connectionStatus').text('Camera is disconnected.');
    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error('Error checking camera connection:', error);
    //             }
    //         });
    //     }

    //     // Initial check when the page loads
    //     checkCameraConnection();

    //     // Repeat check every 5 seconds
    //     setInterval(checkCameraConnection, 5000);
    // });
</script>

@endsection